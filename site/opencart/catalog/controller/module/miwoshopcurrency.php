<?php 
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerModuleMiwoshopcurrency extends Controller {
	protected function index() {
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/miwoshopcurrency.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/miwoshopcurrency.tpl';
		} else {
			$this->template = 'default/template/module/miwoshopcurrency.tpl';
		}

		$this->render();
	}
}
?>