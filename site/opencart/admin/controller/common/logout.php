<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');
       
class ControllerCommonLogout extends Controller {   
	public function index() { 
    	$this->user->logout();
 
 		unset($this->session->data['token']);

		$this->redirect($this->url->link('common/login', '', 'SSL'));
  	}
}  
?>