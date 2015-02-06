<?php
/*
* @package		MiwoShop
* @copyright	2009-2013 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerCommonDbfix extends Controller {

    public function index() {

		$this->data['link'] = $this->url->link('common/dbfix/fix', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL');
		$this->data['link2'] = $this->url->link('common/dbfix/media', 'format=raw&tmpl=component&token=' . $this->session->data['token'], 'SSL');

        $this->data['link']=str_replace('&amp;', '&', $this->data['link']);
        $this->data['link2']=str_replace('&amp;', '&', $this->data['link2']);

        $this->template = 'common/dbfix.tpl';

        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
	
	public function fix(){
	
		$this->load->model('common/dbfix');
		$results = $this->model_common_dbfix->addTables();
		$results = $this->model_common_dbfix->addColumns();
        $results = $this->model_common_dbfix->deleteColumns();
		$results = $this->model_common_dbfix->changeColumns();
        $results = $this->model_common_dbfix->deleteTables();

        $results = $this->model_common_dbfix->changeImagePaths();
        $results = $this->model_common_dbfix->changeSettings();
        $results = $this->model_common_dbfix->addPermissions();

        echo 'Successful';
        exit();
	}

    public function backup() {
        if ($this->user->hasPermission('modify', 'tool/backup')) {
            ob_end_clean();
            ob_start();

            $this->response->addheader('Pragma: public');
            $this->response->addheader('Expires: 0');
            $this->response->addheader('Content-Description: File Transfer');
            $this->response->addheader('Content-Type: application/octet-stream');
            $this->response->addheader('Content-Disposition: attachment; filename=' . date('Y-m-d_H-i-s', time()).'_backup.sql');
            $this->response->addheader('Content-Transfer-Encoding: binary');

            $this->load->model('common/dbfix');

            $this->response->setOutput($this->model_common_dbfix->backup($this->getTableList()));
        } else {
            $this->session->data['error'] = $this->language->get('error_permission');

            $this->redirect($this->url->link('common/dbfix', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

    public function media() {
        if ($this->user->hasPermission('modify', 'common/dbfix')) {
            if(!dir(MPATH_MIWI. '/media/miwoshop_files/')) {
                mkdir(MPATH_MIWI. '/media/miwoshop_files/');
            }

            if(dir(MPATH_MIWOSHOP_OC.'/download')) {
                rename(MPATH_MIWOSHOP_OC . '/download', MPATH_MIWI . '/media/miwoshop_files/download');
            }

            if(dir(MPATH_MIWOSHOP_OC.'/image/data')) {
                rename(MPATH_MIWOSHOP_OC.'/image/data', MPATH_MIWI. '/media/miwoshop_files/catalog');
            }

            echo 'Successful';
        }
        else{
            echo 'Error';
        }
    }

    public function getTableList(){
        $tables = array('address', 'affiliate', 'affiliate_activity', 'affiliate_login', 'affiliate_transaction', 'api', 'attribute', 'attribute_description', 'attribute_group', 'attribute_group_description', 'banner', 'banner_image', 'banner_image_description', 'category', 'category_description', 'category_filter', 'category_path', 'category_to_layout', 'category_to_store', 'country', 'coupon', 'coupon_category', 'coupon_history', 'coupon_product', 'currency', 'customer', 'customer_activity', 'customer_ban_ip', 'customer_group', 'customer_group_description', 'customer_history', 'customer_ip', 'customer_login', 'customer_online', 'customer_reward', 'customer_transaction', 'download', 'download_description', 'event', 'extension', 'filter', 'filter_description', 'filter_group', 'filter_group_description', 'geo_zone', 'information', 'information_description', 'information_to_layout', 'information_to_store', 'j_integrations', 'jgroup_cgroup_map', 'jgroup_ugroup_map', 'juser_ocustomer_map', 'juser_ouser_map', 'language', 'layout', 'layout_module', 'layout_route', 'length_class', 'length_class_description', 'location', 'manufacturer', 'manufacturer_to_store', 'marketing', 'modification', 'module', 'option', 'option_description', 'option_value', 'option_value_description', 'order', 'order_custom_field', 'order_fraud', 'order_history', 'order_option', 'order_product', 'order_status', 'order_total', 'order_voucher', 'product', 'product_attribute', 'product_description', 'product_discount', 'product_filter', 'product_image', 'product_option', 'product_option_value', 'product_related', 'product_reward', 'product_special', 'product_to_category', 'product_to_download', 'product_to_layout', 'product_to_store', 'recurring', 'recurring_description', 'return', 'return_action', 'return_history', 'return_reason', 'return_status', 'review', 'stock_status', 'store', 'tax_class', 'tax_rate', 'tax_rate_to_customer_group', 'tax_rule', 'upload', 'url_alias', 'user', 'user_group', 'voucher', 'voucher_history', 'voucher_theme', 'voucher_theme_description', 'weight_class', 'weight_class_description', 'zone', 'zone_to_geo_zone');
        return $tables;
    }
}
?>