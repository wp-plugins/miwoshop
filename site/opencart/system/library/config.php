<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class MiwoshopConfig {


  	public function get($key) {
    	return (isset($this->data[$key]) ? $this->data[$key] : null);
  	}	
	
	public function set($key, $value) {
    	$this->data[$key] = $value;
  	}

	public function has($key) {
    	return isset($this->data[$key]);
  	}

  	public function load($filename) {
		$file = DIR_CONFIG . $filename . '.php';
		
    	if (file_exists($file)) { 
	  		$_ = array();
	  
	  		require($file);
	  
	  		$this->data = array_merge($this->data, $_);
		} else {
			trigger_error('Error: Could not load config ' . $filename . '!');
			exit();
		}
  	}
}
?>