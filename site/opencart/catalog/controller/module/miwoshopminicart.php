<?php 
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerModuleMiwoshopminicart extends Controller {
	protected function index() {
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/miwoshopminicart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/miwoshopminicart.tpl';
		} else {
			$this->template = 'default/template/module/miwoshopminicart.tpl';
		}

		$this->render();
	}
}
?>