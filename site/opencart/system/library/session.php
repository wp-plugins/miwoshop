<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class Session {
	public $data = array();

	public function __construct() {
		if (!session_id()) {
			ini_set('session.use_only_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');
			ini_set('session.cookie_httponly', 'On');

			session_set_cookie_params(0, '/');
			session_start();
		}

		$this->data =& $_SESSION;
	}

	function getId() {
		return session_id();
	}
}
?>