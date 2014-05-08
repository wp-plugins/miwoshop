<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelCommonEditorbutton extends Model {
    public function getProductOptions($product_id) {
   		$product_option_data = array();

   		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

   		foreach ($product_option_query->rows as $product_option) {
   			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
   				$product_option_value_data = array();

   				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

   				foreach ($product_option_value_query->rows as $product_option_value) {
   					$product_option_value_data[] = array(
   						'product_option_value_id' => $product_option_value['product_option_value_id'],
   						'option_value_id'         => $product_option_value['option_value_id'],
   						'name'                    => $product_option_value['name'],
   						'image'                   => $product_option_value['image'],
   						'quantity'                => $product_option_value['quantity'],
   						'subtract'                => $product_option_value['subtract'],
   						'price'                   => $product_option_value['price'],
   						'price_prefix'            => $product_option_value['price_prefix'],
   						'weight'                  => $product_option_value['weight'],
   						'weight_prefix'           => $product_option_value['weight_prefix']
   					);
   				}

   				$product_option_data[] = array(
   					'product_option_id' => $product_option['product_option_id'],
   					'option_id'         => $product_option['option_id'],
   					'name'              => $product_option['name'],
   					'type'              => $product_option['type'],
   					'option_value'      => $product_option_value_data,
   					'required'          => $product_option['required']
   				);
   			} else {
   				$product_option_data[] = array(
   					'product_option_id' => $product_option['product_option_id'],
   					'option_id'         => $product_option['option_id'],
   					'name'              => $product_option['name'],
   					'type'              => $product_option['type'],
   					'option_value'      => $product_option['option_value'],
   					'required'          => $product_option['required']
   				);
   			}
         	}

   		return $product_option_data;
   	}

}