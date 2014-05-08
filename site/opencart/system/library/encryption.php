<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

final class Encryption {
	private $key;
	private $iv;
	
	public function __construct($key) {
        $this->key = hash('sha256', $key, true);
		$this->iv = mcrypt_create_iv(32, MCRYPT_RAND);
	}
	
	public function encrypt($value) {
		return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $value, MCRYPT_MODE_ECB, $this->iv)), '+/=', '-_,');
	}
	
	public function decrypt($value) {
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode(strtr($value, '-_,', '+/=')), MCRYPT_MODE_ECB, $this->iv));
	}
}
?>