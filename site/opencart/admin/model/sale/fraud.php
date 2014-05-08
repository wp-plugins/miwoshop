<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelSaleFraud extends Model {
	public function getFraud($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_fraud` WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->row;
	}
}
?>