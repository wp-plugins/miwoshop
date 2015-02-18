<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelSearchSearch extends Model {
    public function getProducts($data = array()) {
        $sql = "SELECT p.product_id, pd.name, p.model, p.image
                FROM " . DB_PREFIX . "product p
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
                    AND ( pd.name LIKE '" . $this->db->escape($data['query']) . "%'
                          OR p.model LIKE '" . $this->db->escape($data['query']) . "%'
                          OR p.sku LIKE '" . $this->db->escape($data['query']) . "%'
                        )
                GROUP BY p.product_id
                ORDER BY pd.name ASC
                LIMIT 5";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getCategories($data = array()) {
        $sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.image
                FROM " . DB_PREFIX . "category_path cp
                LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id)
                LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id)
                LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id)
                LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id)
                WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "'
                    AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'
                    AND cd1.name LIKE '" . $this->db->escape($data['query']) . "%'
                GROUP BY cp.category_id
                ORDER BY cd1.name ASC
                LIMIT 5";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getManufacturers($data = array()) {
        $sql = "SELECT manufacturer_id, name, image
                FROM " . DB_PREFIX . "manufacturer
                WHERE name LIKE '" . $this->db->escape($data['query']) . "%'
                ORDER BY name ASC
                LIMIT 5";

        $query = $this->db->query($sql);

        return $query->rows;
    }


    public function getCustomers($data = array()) {
        $sql = "SELECT customer_id, email, CONCAT(c.firstname, ' ', c.lastname) AS name
                FROM " . DB_PREFIX . "customer c
                WHERE c.firstname LIKE '" . $this->db->escape($data['query']) . "%'
                    OR c.email LIKE '" . $this->db->escape($data['query']) . "%'
                    OR c.lastname LIKE '" . $this->db->escape($data['query']) . "%'
                ORDER BY name ASC
                LIMIT 5";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getOrders($data = array()) {
        $sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, o.total, o.currency_code, o.currency_value, o.date_added, o.email
                FROM `" . DB_PREFIX . "order` o
                WHERE o.order_status_id > '0'
                AND (o.order_id = '" . (int)$this->db->escape($data['query']) . "'
                     OR o.firstname LIKE '" . $this->db->escape($data['query']) . "%'
                     OR o.email LIKE '" . $this->db->escape($data['query']) . "%'
                     OR o.lastname LIKE '" . $this->db->escape($data['query']) . "%'
                     OR CONCAT(o.invoice_prefix, o.invoice_no) LIKE '" . $this->db->escape($data['query']) . "%')
                ORDER BY o.order_id ASC
                LIMIT 5";

        $query = $this->db->query($sql);

        return $query->rows;
    }
}