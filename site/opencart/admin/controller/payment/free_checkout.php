<?php
/*
* @package		MijoShop
* @copyright	2009-2013 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('_JEXEC') or die('Restricted access');
 
class ControllerPaymentFreeCheckout extends Controller {
	private $error = array();

  	public function index() {
		return true;
  	}

  	private function validate() {
		return true;
  	}
}
?>