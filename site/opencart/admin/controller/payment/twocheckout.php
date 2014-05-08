<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerPaymentTwoCheckout extends Controller {
    private $error = array();

  	public function index() {
          return true;
  	}

  	private function validate() {
          return true;
  	}
}
?>