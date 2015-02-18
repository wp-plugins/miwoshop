<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted Access');

// Imports
mimport('framework.installer.installer');
mimport('framework.installer.helper');
mimport('framework.filesystem.file');
mimport('framework.filesystem.folder');

class ModelCommonUpgrade extends Model {

    // Upgrade
    public function upgrade() {
        $base = Miwoshop::get('base');
        $utility = Miwoshop::get('utility');

        $type = MRequest::getCmd('type');
        if ($type == 'upload') {
            $userfile = MRequest::getVar('install_package', null, 'files', 'array');
            $package = $utility->getPackageFromUpload($userfile);
        }
        elseif ($type == 'server') {
            $package = $utility->getPackageFromServer('index.php?option=com_mijoextensions&view=download&model=com_miwoshop&version='.$base->getMiwoshopVersion().'&pid='.$base->getConfig()->get('pid'));
        }

        if (!$package || empty($package['dir'])) {
            //$this->setState('message', 'Unable to find install package.');
            return false;
        }

        $file_name = $package['dir'].'/com_miwoshop.zip';

        if (MFile::exists($file_name)) {
            $p1 = $utility->unpack($file_name);
            $installer = new JInstaller();
            $installer->install($p1['dir']);

            $lib_file_name = $package['dir'].'/pkg_miwoshop_library.zip';
            if (MFile::exists($lib_file_name)) {
                $p2 = $utility->unpack($lib_file_name);
                $installer = new JInstaller();
                $installer->install($p2['dir']);
            }

            $plg_file_name = $package['dir'].'/plg_miwoshop_jquery.zip';
            if (MFile::exists($plg_file_name)) {
                $p3 = $utility->unpack($plg_file_name);
                $installer = new JInstaller();
                $installer->install($p3['dir']);
            }

            /*$thm_file_name = $package['dir'].'/pkg_miwoshop_themes.zip';
            if (MFile::exists($thm_file_name)) {
                $p4 = $utility->unpack($thm_file_name);
                $installer = new JInstaller();
                $installer->install($p4['dir']);
            }*/
        }
        else {
            $installer = new JInstaller();
            $installer->install($package['dir']);
        }

        MFolder::delete($package['dir']);

        return true;
    }
}