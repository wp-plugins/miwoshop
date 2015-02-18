<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelDashboardRecenttabs extends Model {

    public function getBestSellers() {
        $complete_status_ids = '('.implode(',', $this->config->get('config_complete_status')).')';

   		$query = $this->db->query("SELECT SUM( op.quantity )AS total, op.product_id, pd.name FROM " . DB_PREFIX . "order_product AS op LEFT JOIN " . DB_PREFIX . "order AS o ON ( op.order_id = o.order_id ) LEFT JOIN  " . DB_PREFIX . "product_description AS pd ON (op.product_id = pd.product_id)  WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') ."' AND o.order_status_id IN " . $complete_status_ids . " GROUP BY pd.name ORDER BY total DESC LIMIT 5");
   		return $query->rows;
   	}

    public function getLessSellers() {
        $complete_status_ids = '('.implode(',', $this->config->get('config_complete_status')).')';

   		$query = $this->db->query("SELECT SUM( op.quantity )AS total, op.product_id, pd.name FROM " . DB_PREFIX . "order_product AS op LEFT JOIN " . DB_PREFIX . "order AS o ON ( op.order_id = o.order_id ) LEFT JOIN  " . DB_PREFIX . "product_description AS pd ON (op.product_id = pd.product_id)  WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') ."' AND o.order_status_id IN " . $complete_status_ids . " GROUP BY pd.name ORDER BY total ASC LIMIT 5");
   		return $query->rows;
   	}

    public function getMostViewed() {
   		$query = $this->db->query("SELECT p.product_id, pd.name, p.viewed FROM `" . DB_PREFIX . "product` AS p LEFT JOIN  " . DB_PREFIX . "product_description AS pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') ."' GROUP BY product_id ORDER BY viewed DESC LIMIT 5");
   		return $query->rows;
   	}
}