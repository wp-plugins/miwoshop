<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

//No Permision
defined('MIWI') or die('Restricted access');

require_once(MPATH_WP_PLG.'/miwoshop/site/miwoshop/miwoshop.php');

mimport('framework.form.formfield');

class MFormFieldMiwoShopVersion extends MFormField {

    protected $type = 'MiwoShopVersion';

    protected function getInput() {
        return MiwoShop::get('base')->getMiwoshopVersion();
    }
}
