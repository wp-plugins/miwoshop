<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class Cache { 
	private $expire = 3600; 

	public function get($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			$cache = file_get_contents($files[0]);
			
			$data = unserialize($cache);
			
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

      			if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
      			}
    		}
			
			return $data;			
		}
	}

  	public function set($key, $value) {
    	$this->delete($key);
		
		if (!is_dir(DIR_CACHE)) {
            mkdir(DIR_CACHE);         
        }
		
		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);
    	
		$handle = fopen($file, 'w');

    	fwrite($handle, serialize($value));
		
    	fclose($handle);
  	}
	
  	public function delete($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		
		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					unlink($file);
				}
    		}
		}
  	}
}
?>