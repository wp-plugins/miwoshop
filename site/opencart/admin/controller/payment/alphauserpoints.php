<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');
 
class ControllerPaymentAlphauserpoints extends Controller {
	private $error = array(); 

	public function index() {
		return true;
	}

	protected function validate() {
		return true;
	}
}
?>