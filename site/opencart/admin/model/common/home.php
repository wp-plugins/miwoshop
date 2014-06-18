<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelCommonHome extends Model {
    public function getSales($date_start, $date_end, $group){
        $query = $this->db->query("SELECT SUM(total) AS total, HOUR(date_added) AS hour, CONCAT(MONTHNAME(date_added), ' ', YEAR(date_added)) AS month, YEAR(date_added) AS year, DATE(date_added) AS date  FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "' GROUP BY ". $group ."(date_added) ORDER BY date_added ASC");
        return $query;
    }

    public function getTotalSales($date_start, $date_end){
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "'");
        return $query->row;
    }

    public function getOrders($date_start, $date_end, $group){
        $query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour, CONCAT(MONTHNAME(date_added), ' ', YEAR(date_added)) AS month, YEAR(date_added) AS year, DATE(date_added) AS date  FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "' GROUP BY ". $group ."(date_added) ORDER BY date_added ASC");
        return $query;
    }

    public function getTotalOrders($date_start, $date_end){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "'");
        return $query->row;
    }

    public function getCustomers($date_start, $date_end, $group){
        $query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour, CONCAT(MONTHNAME(date_added), ' ', YEAR(date_added)) AS month, YEAR(date_added) AS year, DATE(date_added) AS date  FROM `" . DB_PREFIX . "customer` WHERE  DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "' GROUP BY ". $group ."(date_added) ORDER BY date_added ASC");
        return $query;
    }

    public function getTotalCustomers($date_start, $date_end){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer` WHERE  DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "'");
        return $query->row;
    }

    public function getReviews($date_start, $date_end, $group){
        $query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour, CONCAT(MONTHNAME(date_added), ' ', YEAR(date_added)) AS month, YEAR(date_added) AS year, DATE(date_added) AS date  FROM `" . DB_PREFIX . "review` WHERE  DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "' GROUP BY ". $group ."(date_added) ORDER BY date_added ASC");
        return $query;
    }

    public function getTotalReviews($date_start, $date_end){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "review` WHERE  DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "'");
        return $query->row;
    }

    public function getAffiliates($date_start, $date_end, $group){
        $query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour, CONCAT(MONTHNAME(date_added), ' ', YEAR(date_added)) AS month, YEAR(date_added) AS year, DATE(date_added) AS date  FROM `" . DB_PREFIX . "affiliate` WHERE DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "' GROUP BY ". $group ."(date_added) ORDER BY date_added ASC");
        return $query;
    }

    public function getTotalAffiliates($date_start, $date_end){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "affiliate` WHERE status = 1 AND DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "'");
        return $query->row;
    }

    public function getRewards($date_start, $date_end, $group){
        $query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour, CONCAT(MONTHNAME(date_added), ' ', YEAR(date_added)) AS month, YEAR(date_added) AS year, DATE(date_added) AS date  FROM `" . DB_PREFIX . "customer_reward` WHERE DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "' GROUP BY ". $group ."(date_added) ORDER BY date_added ASC");
        return $query;
    }

    public function getTotalRewards($date_start, $date_end){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer_reward` WHERE DATE(date_added) BETWEEN '" . $this->db->escape($date_start) . "' AND '" . $this->db->escape($date_end) . "'");
        return $query->row;
    }

    public function getBestSellers() {
   		$query = $this->db->query("SELECT SUM( op.quantity )AS total, op.product_id, pd.name FROM " . DB_PREFIX . "order_product AS op LEFT JOIN " . DB_PREFIX . "order AS o ON ( op.order_id = o.order_id ) LEFT JOIN  " . DB_PREFIX . "product_description AS pd ON (op.product_id = pd.product_id)  WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') ."' AND o.order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' GROUP BY pd.name ORDER BY total DESC LIMIT 5");
   		return $query->rows;
   	}

    public function getLessSellers() {
   		$query = $this->db->query("SELECT SUM( op.quantity )AS total, op.product_id, pd.name FROM " . DB_PREFIX . "order_product AS op LEFT JOIN " . DB_PREFIX . "order AS o ON ( op.order_id = o.order_id ) LEFT JOIN  " . DB_PREFIX . "product_description AS pd ON (op.product_id = pd.product_id)  WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') ."' AND o.order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' GROUP BY pd.name ORDER BY total ASC LIMIT 5");
   		return $query->rows;
   	}

    public function getMostViewed() {
   		$query = $this->db->query("SELECT p.product_id, pd.name, p.viewed FROM `" . DB_PREFIX . "product` AS p LEFT JOIN  " . DB_PREFIX . "product_description AS pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') ."' GROUP BY product_id ORDER BY viewed DESC LIMIT 5");
   		return $query->rows;
   	}
}