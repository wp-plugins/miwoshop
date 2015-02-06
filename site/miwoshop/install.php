<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die ('Restricted access');

mimport('framework.filesystem.file');
mimport('framework.filesystem.folder');
require_once(MPATH_WP_PLG .'/miwoshop/site/miwoshop/miwoshop.php');

class MiwoShopInstall {

	public function createTables() {
		$db = MiwoShop::get('db')->getDbo();

		$tables	= $db->getTableList();
		$miwoshop_address = $db->getPrefix().'miwoshop_address';
		if (!is_array($tables) || in_array($miwoshop_address, $tables)) {
			return;
		}

		$this->_runSqlFile(MPATH_MIWOSHOP_ADMIN.'/install.sql');
	}

	public function createUserTables() {
        $db = MiwoShop::get('db');
        $jdb = MiwoShop::get('db')->getDbo();

        $this->_createUserMapTables();

        $tables	= $jdb->getTableList();
		$miwoshop_user = $jdb->getPrefix().'miwoshop_user';
		if (!is_array($tables) || in_array($miwoshop_user, $tables)) {
			return;
		}

        $jdb->setQuery("CREATE TABLE IF NOT EXISTS `#__miwoshop_user` (
		  `user_id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_group_id` int(11) NOT NULL,
		  `username` varchar(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `password` varchar(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `salt` varchar(9) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `firstname` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `lastname` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `email` varchar(96) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `code` varchar(32) COLLATE utf8_general_ci NOT NULL,
		  `ip` varchar(40) COLLATE utf8_general_ci NOT NULL DEFAULT '',
		  `status` tinyint(1) NOT NULL,
		  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`user_id`)
		) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        $jdb->query();
	}

    public function _createUserMapTables() {
        $db = MiwoShop::get('db');
        $jdb = MiwoShop::get('db')->getDbo();

        $tables	= $jdb->getTableList();
        $miwoshop_muser_ocustomer_map = $jdb->getPrefix().'miwoshop_muser_ocustomer_map';
        if (!is_array($tables) || in_array($miwoshop_muser_ocustomer_map, $tables)) {
            return;
        }

        $jdb->setQuery("CREATE TABLE IF NOT EXISTS `#__miwoshop_muser_ocustomer_map` (
          `muser_id` INT(11) NOT NULL,
          `ocustomer_id` INT(11) NOT NULL,
          PRIMARY KEY (`muser_id`),
          UNIQUE (`ocustomer_id`)
        ) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        $jdb->query();

        $jdb->setQuery("CREATE TABLE IF NOT EXISTS `#__miwoshop_muser_ouser_map` (
          `muser_id` INT(11) NOT NULL,
          `ouser_id` INT(11) NOT NULL,
          PRIMARY KEY (`muser_id`),
          UNIQUE (`ouser_id`)
        ) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        $jdb->query();
    }

	public function createGroupTables() {
        $db = MiwoShop::get('db');
        $jdb = MiwoShop::get('db')->getDbo();

		$tables	= $jdb->getTableList();
		$miwoshop_mgroup_cgroup_map = $jdb->getPrefix().'miwoshop_mgroup_cgroup_map';
		if (!is_array($tables) || in_array($miwoshop_mgroup_cgroup_map, $tables)) {
			return;
		}

        $registered = 'subscriber';
        $publisher = 'author';
        $administrator = 'administrator';

        $jdb->setQuery("CREATE TABLE IF NOT EXISTS `#__miwoshop_mgroup_cgroup_map` (
		  `mgroup_id` VARCHAR(255) NOT NULL,
		  `cgroup_id` INT(11) NOT NULL,
		  PRIMARY KEY (`cgroup_id`)
		) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        $jdb->query();

		$customer_groups = $db->run('SELECT customer_group_id FROM #__miwoshop_customer_group', 'loadColumn');
		if (!empty($customer_groups)) {
            foreach ($customer_groups as $customer_group) {
                $j_group = $registered;
                if ($customer_group == 6) {
                    $j_group = $publisher;
                }

                $db->run("INSERT INTO #__miwoshop_mgroup_cgroup_map SET mgroup_id = '{$j_group}', cgroup_id = '{$customer_group}'", 'query');
            }
        }

        $jdb->setQuery("CREATE TABLE IF NOT EXISTS `#__miwoshop_mgroup_ugroup_map` (
      		  `mgroup_id` VARCHAR(255) NOT NULL,
      		  `ugroup_id` INT(11) NOT NULL,
      		  PRIMARY KEY (`ugroup_id`)
      		) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        $jdb->query();

        $user_groups = $db->run('SELECT user_group_id FROM #__miwoshop_user_group', 'loadColumn');
		if (!empty($user_groups)) {
            foreach ($user_groups as $user_group) {
                $db->run("INSERT INTO #__miwoshop_mgroup_ugroup_map SET mgroup_id = '{$administrator}', ugroup_id = '{$user_group}'", 'query');
            }
        }
	}

    public function createIntegrationTables() {
        $db = MiwoShop::get('db');
        $jdb = MiwoShop::get('db')->getDbo();

        $tables	= $jdb->getTableList();
        $miwoshop_j_integrations = $jdb->getPrefix().'miwoshop_j_integrations';
        if (!is_array($tables) || in_array($miwoshop_j_integrations, $tables)) {
            return;
        }

        $jdb->setQuery("CREATE TABLE IF NOT EXISTS `#__miwoshop_j_integrations` (
			`product_id` INT NOT NULL,
			`content` TEXT NOT NULL
			) CHARSET=utf8 COLLATE=utf8_general_ci;");
        $jdb->query();
    }

    public function addPage(){
        $page_content="<!-- MiwoShop Shortcode. Please do not remove to shopping cart work properly. -->[miwoshop]<!-- MiwoShop Shortcode End. -->";
        add_option("miwoshop_page_id",'','','yes');

        $miwoshop_post  = array();
        $_tmp_page      = null;

        $id = get_option("miwoshop_page_id");

        if (!empty($id) && $id > 0) {
            $_tmp_page = get_post($id);
        }

        if ($_tmp_page != null){
            $miwoshop_post['ID']            = $id;
            $miwoshop_post['post_status']   = 'publish';

            wp_update_post($miwoshop_post);
        }
        else{
            $miwoshop_post['post_title']    = 'Shop';
            $miwoshop_post['post_content']  = $page_content;
            $miwoshop_post['post_status']   = 'publish';
            $miwoshop_post['post_author']   = 1;
            $miwoshop_post['post_type']     = 'page';
            $miwoshop_post['comment_status']= 'closed';

            $id = wp_insert_post($miwoshop_post);
            update_option('miwoshop_page_id',$id);
        }
    }

    public function _runSqlFile($sql_file) {
        $db = MiwoShop::get('db')->getDbo();
		
        if (!file_exists($sql_file)) {
            return;
        }

        $buffer = file_get_contents($sql_file);

        if ($buffer === false) {
            return;
        }

        $queries = $db->splitSql($buffer);

        if (count($queries) == 0) {
            return;
        }

        foreach ($queries as $query) {
            $query = trim($query);

            if ($query != '' && $query{0} != '#') {
                $db->setQuery($query);

                if (!$db->query()) {
                    MError::raiseWarning(1, 'JInstaller::install: '.MText::_('SQL Error')." ".$db->stderr(true));
                    return;
                }
            }
        }
    }

	public function upgrade120(){
        $jdb = MiwoShop::get('db')->getDbo();

        //add wizard done
        $jdb->setQuery("SELECT `value` FROM #__miwoshop_setting WHERE `key`='config_miwoshop' ");
        $settings = $jdb->loadResult();

        $settings = unserialize($settings);
        $settings['wizard'] = 1;
        $settings = serialize($settings);

        $jdb->setQuery("UPDATE `#__miwoshop_setting` SET value = '". $settings . "' WHERE `key` = 'config_miwoshop'");
        $jdb->query();
		
		//insert permission for support/support
        $jdb->setQuery("SELECT permission FROM `#__miwoshop_user_group` WHERE `user_group_id` = 1");
        $permission = $jdb->loadResult();
        $permission = unserialize($permission);
		
		if (!array_search('payment/bluepay_hosted_form', $permission['access'])){
            $permission['access'][] = 'payment/bluepay_hosted_form';
            $permission['modify'][] = 'payment/bluepay_hosted_form';
        }
		
        if (!array_search('payment/bluepay_redirect', $permission['access'])){
            $permission['access'][] = 'payment/bluepay_redirect';
            $permission['modify'][] = 'payment/bluepay_redirect';
        }
		
		if (!array_search('payment/firstdata', $permission['access'])){
            $permission['access'][] = 'payment/firstdata';
            $permission['modify'][] = 'payment/firstdata';
        }
		
		if (!array_search('payment/firstdata_remote', $permission['access'])){
            $permission['access'][] = 'payment/firstdata_remote';
            $permission['modify'][] = 'payment/firstdata_remote';
        }		
		
		if (!array_search('payment/securetrading_pp', $permission['access'])){
            $permission['access'][] = 'payment/securetrading_pp';
            $permission['modify'][] = 'payment/securetrading_pp';
        }
				
		if (!array_search('payment/securetrading_ws', $permission['access'])){
            $permission['access'][] = 'payment/securetrading_ws';
            $permission['modify'][] = 'payment/securetrading_ws';
        }
		
		if (!array_search('payment/alphauserpoints', $permission['access'])){
            $permission['access'][] = 'payment/alphauserpoints';
            $permission['modify'][] = 'payment/alphauserpoints';
        }
		
		if (!array_search('payment/easysocialpoints', $permission['access'])){
            $permission['access'][] = 'payment/easysocialpoints';
            $permission['modify'][] = 'payment/easysocialpoints';
        }
		
		if (!array_search('payment/jomsocialpoints', $permission['access'])){
            $permission['access'][] = 'payment/jomsocialpoints';
            $permission['modify'][] = 'payment/jomsocialpoints';
        }
		
		if (!array_search('payment/mercadopago2', $permission['access'])){
            $permission['access'][] = 'payment/mercadopago2';
            $permission['modify'][] = 'payment/mercadopago2';
        }
		
		if (!array_search('common/wizard', $permission['access'])){
            $permission['access'][] = 'common/wizard';
            $permission['modify'][] = 'common/wizard';
        }

        $permission = serialize($permission);

        $jdb->setQuery("UPDATE `#__miwoshop_user_group` SET `permission` = '".$permission."' WHERE `user_group_id` = 1");
        $jdb->query();
		
		//$this->_addIndexes();
   	}
	
	public function upgrade121(){
        $jdb = MiwoShop::get('db')->getDbo();
		
        $jdb->setQuery("SELECT permission FROM `#__miwoshop_user_group` WHERE `user_group_id` = 1");
        $permission = $jdb->loadResult();
        $permission = unserialize($permission);
		
		if (!array_search('common/dbfix', $permission['access'])){
            $permission['access'][] = 'common/dbfix';
            $permission['modify'][] = 'common/dbfix';
        }

        $permission = serialize($permission);

        $jdb->setQuery("UPDATE `#__miwoshop_user_group` SET `permission` = '".$permission."' WHERE `user_group_id` = 1");
        $jdb->query();
   	}
	
    public function checkLanguage(){
        $db = MiwoShop::get('db');

        $oc_langs   = self::getOcLanguages();
        $j_langs    = self::getInstalledJoomlaLanguages();
        $j_contents = self::getLanguageList();

        foreach ($oc_langs as $key => $oc_lang) {
            if(isset($j_langs[$key]) and !isset($j_contents[$key])) {
                $db->run("INSERT INTO #__languages SET lang_code = '".$j_langs[$key]['tag']."', title = '".$j_langs[$key]['name']."', title_native = '".$j_langs[$key]['name']."', sef ='".$j_langs[$key]['code']."', image ='".$j_langs[$key]['code']."', published = 1, access = 1, ordering = 0", 'query');
            }
        }
    }
	
	public function getOcLanguages() {
        $language_data = array();

        $results = MiwoShop::get('db')->run("SELECT * FROM #__miwoshop_language WHERE status = 1 ORDER BY sort_order, name", 'loadAssocList');

        foreach ($results as $result) {
            $language_data[$result['code']] = array(
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'code'        => $result['code'],
                'locale'      => $result['locale'],
                'image'       => $result['image'],
                'directory'   => $result['directory'],
                'filename'    => $result['filename'],
                'sort_order'  => $result['sort_order'],
                'status'      => $result['status']
            );
        }

        return $language_data;
    }

    public function getInstalledJoomlaLanguages($client = 0) {

        $langlist = array();

        //$results = MiwoShop::get('db')->run("SELECT name, element FROM #__extensions WHERE type = 'language' AND state = 0 AND enabled = 1 AND client_id= ". (int) $client, 'loadAssocList');
        $results = array();

        foreach ($results as $result) {
            $_result = explode('-', $result['element']);

            if($result['element'] == 'pt-BR'){
                $_result[0] = strtolower($result['element']);
            }

            $langlist[$_result[0]] = array(
                'code' => $_result[0],
                'tag'  => $result['element'],
                'name'  => $result['name']
            );
        }

        return $langlist;
    }
	
	public function getLanguageList() {

		$language_data = array();

		$results = MiwoShop::get('db')->run("SELECT * FROM #__languages ORDER BY ordering, title", 'loadAssocList');

		foreach ($results as $result) {
			$language_data[$result['sef']] = array(
				'language_id' => $result['lang_id'],
				'name'        => $result['title_native'],
				'code'        => $result['sef'],
				'locale'      => $result['lang_code'],
				'image'       => $result['image'].'.gif',
				'directory'   => 'english',
				'filename'    => 'english',
				'sort_order'  => $result['ordering'],
				'status'      => $result['published']
			);
		}
        

        return $language_data;
    }
	
    private function _getPath($cat_id, $path = array()){
        $jdb = MiwoShop::get('db')->getDbo();
		
        $jdb->setQuery("SELECT parent_id FROM `#__miwoshop_category` WHERE category_id = ".$cat_id);
        $parent_id = $jdb->loadResult();

        if ((int)$parent_id != 0) {
            $path[] = $parent_id;
            $path = self::_getPath($parent_id, $path);
        }

        return $path;
    }
	
	private function _addIndexes(){
		$queries[] = "ALTER TABLE #__miwoshop_address ADD INDEX company_idd (company_id);";
		$queries[] = "ALTER TABLE #__miwoshop_address ADD INDEX tax_idd (tax_id);";
		$queries[] = "ALTER TABLE #__miwoshop_address ADD INDEX country_idd (country_id);";
		$queries[] = "ALTER TABLE #__miwoshop_address ADD INDEX zone_idd (zone_id);";
		$queries[] = "ALTER TABLE #__miwoshop_affiliate ADD INDEX country_idd (country_id);";
		$queries[] = "ALTER TABLE #__miwoshop_affiliate ADD INDEX zone_idd (zone_id);";
		$queries[] = "ALTER TABLE #__miwoshop_affiliate_transaction ADD INDEX affiliate_idd (affiliate_id);";
		$queries[] = "ALTER TABLE #__miwoshop_affiliate_transaction ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_attribute ADD INDEX attribute_group_idd (attribute_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_attribute_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_attribute_group_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_banner_image ADD INDEX banner_idd (banner_id);";
		$queries[] = "ALTER TABLE #__miwoshop_banner_image_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_banner_image_description ADD INDEX banner_idd (banner_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category ADD INDEX parent_idd (parent_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category_filter ADD INDEX filter_idd (filter_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category_path ADD INDEX path_idd (path_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category_to_layout ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category_to_layout ADD INDEX layout_idd (layout_id);";
		$queries[] = "ALTER TABLE #__miwoshop_category_to_store ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_coupon_category ADD INDEX category_idd (category_id);";
		$queries[] = "ALTER TABLE #__miwoshop_coupon_history ADD INDEX coupon_idd (coupon_id);";
		$queries[] = "ALTER TABLE #__miwoshop_coupon_history ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_coupon_history ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_coupon_product ADD INDEX coupon_idd (coupon_id);";
		$queries[] = "ALTER TABLE #__miwoshop_coupon_product ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer ADD INDEX address_idd (address_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer ADD INDEX customer_group_idd (customer_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_group_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_history ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_ip ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_online ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_reward ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_reward ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_transaction ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_customer_transaction ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_download_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_filter ADD INDEX filter_group_idd (filter_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_filter_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_filter_description ADD INDEX filter_group_idd (filter_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_filter_group_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_information_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_information_to_layout ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_information_to_layout ADD INDEX layout_idd (layout_id);";
		$queries[] = "ALTER TABLE #__miwoshop_information_to_store ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_j_integrations ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_jgroup_cgroup_map ADD INDEX jgroup_idd (jgroup_id);";
		$queries[] = "ALTER TABLE #__miwoshop_jgroup_ugroup_map ADD INDEX jgroup_idd (jgroup_id);";
		$queries[] = "ALTER TABLE #__miwoshop_layout_route ADD INDEX layout_idd (layout_id);";
		$queries[] = "ALTER TABLE #__miwoshop_layout_route ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_length_class_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_manufacturer_to_store ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_option_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_option_value ADD INDEX option_idd (option_id);";
		$queries[] = "ALTER TABLE #__miwoshop_option_value_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_option_value_description ADD INDEX option_idd (option_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX customer_group_idd (customer_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX payment_company_idd (payment_company_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX payment_tax_idd (payment_tax_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX payment_country_idd (payment_country_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX payment_zone_idd (payment_zone_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX shipping_country_idd (shipping_country_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX shipping_zone_idd (shipping_zone_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX order_status_idd (order_status_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX affiliate_idd (affiliate_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order ADD INDEX currency_idd (currency_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_download ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_download ADD INDEX order_product_idd (order_product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_fraud ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_fraud ADD INDEX maxmind_idd (maxmind_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_history ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_history ADD INDEX order_status_idd (order_status_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_option ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_option ADD INDEX order_product_idd (order_product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_option ADD INDEX product_option_idd (product_option_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_option ADD INDEX product_option_value_idd (product_option_value_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_product ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_product ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_status ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_voucher ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_voucher ADD INDEX voucher_idd (voucher_id);";
		$queries[] = "ALTER TABLE #__miwoshop_order_voucher ADD INDEX voucher_theme_idd (voucher_theme_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product ADD INDEX stock_status_idd (stock_status_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product ADD INDEX manufacturer_idd (manufacturer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product ADD INDEX tax_class_idd (tax_class_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product ADD INDEX weight_class_idd (weight_class_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product ADD INDEX length_class_idd (length_class_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_attribute ADD INDEX attribute_idd (attribute_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_attribute ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_discount ADD INDEX customer_group_idd (customer_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_filter ADD INDEX filter_idd (filter_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_image ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_option ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_option ADD INDEX option_idd (option_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_option_value ADD INDEX product_option_idd (product_option_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_option_value ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_option_value ADD INDEX option_idd (option_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_option_value ADD INDEX option_value_idd (option_value_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_related ADD INDEX related_idd (related_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_reward ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_reward ADD INDEX customer_group_idd (customer_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_special ADD INDEX customer_group_idd (customer_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_to_category ADD INDEX category_idd (category_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_to_download ADD INDEX download_idd (download_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_to_layout ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_to_layout ADD INDEX layout_idd (layout_id);";
		$queries[] = "ALTER TABLE #__miwoshop_product_to_store ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return ADD INDEX product_idd (product_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return ADD INDEX return_reason_idd (return_reason_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return ADD INDEX return_action_idd (return_action_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return ADD INDEX return_status_idd (return_status_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return_action ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return_history ADD INDEX return_idd (return_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return_history ADD INDEX return_status_idd (return_status_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return_reason ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_return_status ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_review ADD INDEX customer_idd (customer_id);";
		$queries[] = "ALTER TABLE #__miwoshop_setting ADD INDEX store_idd (store_id);";
		$queries[] = "ALTER TABLE #__miwoshop_stock_status ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_tax_rate ADD INDEX geo_zone_idd (geo_zone_id);";
		$queries[] = "ALTER TABLE #__miwoshop_tax_rate_to_customer_group ADD INDEX customer_group_idd (customer_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_tax_rule ADD INDEX tax_class_idd (tax_class_id);";
		$queries[] = "ALTER TABLE #__miwoshop_tax_rule ADD INDEX tax_rate_idd (tax_rate_id);";
		$queries[] = "ALTER TABLE #__miwoshop_url_alias ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_user ADD INDEX user_group_idd (user_group_id);";
		$queries[] = "ALTER TABLE #__miwoshop_voucher ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_voucher ADD INDEX voucher_theme_idd (voucher_theme_id);";
		$queries[] = "ALTER TABLE #__miwoshop_voucher_history ADD INDEX voucher_idd (voucher_id);";
		$queries[] = "ALTER TABLE #__miwoshop_voucher_history ADD INDEX order_idd (order_id);";
		$queries[] = "ALTER TABLE #__miwoshop_voucher_theme_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_weight_class_description ADD INDEX language_idd (language_id);";
		$queries[] = "ALTER TABLE #__miwoshop_zone ADD INDEX country_idd (country_id);";
		$queries[] = "ALTER TABLE #__miwoshop_zone_to_geo_zone ADD INDEX country_idd (country_id);";
		$queries[] = "ALTER TABLE #__miwoshop_zone_to_geo_zone ADD INDEX zone_idd (zone_id);";
		$queries[] = "ALTER TABLE #__miwoshop_zone_to_geo_zone ADD INDEX geo_zone_idd (geo_zone_id);";

		$db = MiwoShop::get('db');
		
		foreach($queries as $query) {
			@$db->run($query, 'query');
		}
	}
}