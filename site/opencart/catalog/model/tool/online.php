<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelToolOnline extends Model {	
	public function whosonline($ip, $customer_id, $url, $referer) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_online` WHERE (UNIX_TIMESTAMP(`date_added`) + 3600) < UNIX_TIMESTAMP(NOW())");
		 
		$this->db->query("REPLACE INTO `" . DB_PREFIX . "customer_online` SET `ip` = '" . $this->db->escape($ip) . "', `customer_id` = '" . (int)$customer_id . "', `url` = '" . $this->db->escape($url) . "', `referer` = '" . $this->db->escape($referer) . "', `date_added` = NOW()");
	}
}
?>