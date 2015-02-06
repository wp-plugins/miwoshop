<?php
/*
* @package		MiwoShop
* @copyright	2009-2013 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelCommonDbfix extends Model
{

    private $lang;
    private $simulate;
    private $showOps;
    private $prefix;


    public function addTables()
    {
        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        $text = '';
        if (!array_search($this->prefix . 'affiliate_activity', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'affiliate_activity` (
  		`activity_id` int(11) NOT NULL AUTO_INCREMENT,
  		`affiliate_id` int(11) NOT NULL,
  		`key` varchar(64) NOT NULL,
  		`data` text NOT NULL,
  		`ip` varchar(40) NOT NULL,
  		`date_added` datetime NOT NULL,
  		PRIMARY KEY (`activity_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'affiliate_login', $this->getTables())) {
            $sql = '
                  CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'affiliate_login` (
                   `affiliate_login_id` int(11) NOT NULL AUTO_INCREMENT,
                   `email` varchar(96) NOT NULL,
                   `ip` varchar(40) NOT NULL,
                   `total` int(4) NOT NULL,
                   `date_added` datetime NOT NULL,
                   `date_modified` datetime NOT NULL,
                   PRIMARY KEY (`affiliate_login_id`),
                   KEY `email` (`email`),
                   KEY `ip` (`ip`)
                   ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'api', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'api` (
  		  `api_id` int(11) NOT NULL AUTO_INCREMENT,
  		  `username` varchar(64) NOT NULL,
  		  `firstname` varchar(64) NOT NULL,
  		  `lastname` varchar(64) NOT NULL,
  		  `password` text NOT NULL,
  		  `status` tinyint(1) NOT NULL,
  		  `date_added` datetime NOT NULL,
  		  `date_modified` datetime NOT NULL,
  		  PRIMARY KEY (`api_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);



            $sql = '
  		  INSERT INTO
  		 	   `' . $this->prefix . 'api` (`api_id`, `username`, `password`, `status`, `date_added`, `date_modified`)
  		  VALUES
  			   (1, \'localhost\', \'abcdefghijk\', 1, NOW(), NOW());';

            $this->db->query($sql);

        }

        if (!array_search($this->prefix . 'customer_activity', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'customer_activity` (
  		`activity_id` int(11) NOT NULL AUTO_INCREMENT,
  		`customer_id` int(11) NOT NULL,
  		`key` varchar(64) NOT NULL,
  		`data` text NOT NULL,
  		`ip` varchar(40) NOT NULL,
  		`date_added` datetime NOT NULL,
  		PRIMARY KEY (`activity_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'customer_login', $this->getTables())) {
            $sql = '
                  CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'customer_login` (
                   `customer_login_id` int(11) NOT NULL AUTO_INCREMENT,
                   `email` varchar(96) NOT NULL,
                   `ip` varchar(40) NOT NULL,
                   `total` int(4) NOT NULL,
                   `date_added` datetime NOT NULL,
                   `date_modified` datetime NOT NULL,
                   PRIMARY KEY (`customer_login_id`),
                   KEY `email` (`email`),
                   KEY `ip` (`ip`)
                   ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);


        }

        if (array_search($this->prefix . 'custom_field_to_customer_group', $this->getTables())) {
            $sql = '
                  RENAME TABLE
                        `' . $this->prefix . 'custom_field_to_customer_group`
                  TO
                        `' . $this->prefix . 'custom_field_customer_group`';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'event', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'event` (
  		`event_id` int(11) NOT NULL AUTO_INCREMENT,
  		`code` varchar(32) NOT NULL,
  		`trigger` text NOT NULL,
  		`action` text NOT NULL,
  		PRIMARY KEY (`event_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'layout_module', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'layout_module` (
  		`layout_module_id` int(11) NOT NULL AUTO_INCREMENT,
  		`layout_id` int(11) NOT NULL,
  		`code` varchar(64) NOT NULL,
  		`position` varchar(14) NOT NULL,
  		`sort_order` int(3) NOT NULL,
  		PRIMARY KEY (`layout_module_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'location', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'location` (
  		`location_id` int(11) NOT NULL AUTO_INCREMENT,
  		`name` varchar(32) NOT NULL,
  		`address` text NOT NULL,
  		`telephone` varchar(32) NOT NULL,
  		`fax` varchar(32) NOT NULL,
  		`geocode` varchar(32) NOT NULL,
  		`image` varchar(255) DEFAULT NULL,
  		`open` text NOT NULL,
  		`comment` text NOT NULL,
  		PRIMARY KEY (`location_id`),
  		KEY `name` (`name`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'marketing', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'marketing` (
  		`marketing_id` int(11) NOT NULL AUTO_INCREMENT,
  		`name` varchar(32) NOT NULL,
  		`description` text NOT NULL,
  		`code` varchar(64) NOT NULL,
  		`clicks` int(5) NOT NULL DEFAULT \'0\',
  		`date_added` datetime NOT NULL,
  		PRIMARY KEY (`marketing_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'modification', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'modification` (
                   `modification_id` int(11) NOT NULL AUTO_INCREMENT,
                   `name` varchar(64) NOT NULL,
                   `code` varchar(64) NOT NULL,
                   `author` varchar(64) NOT NULL,
                   `version` varchar(32) NOT NULL,
                   `link` varchar(255) NOT NULL,
                   `xml` text NOT NULL,
                   `status` tinyint(1) NOT NULL,
                   `date_added` datetime NOT NULL,
                  PRIMARY KEY (`modification_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'module', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'module` (
                   `module_id` int(11) NOT NULL AUTO_INCREMENT,
                   `name` varchar(64) NOT NULL,
                  `code` varchar(32) NOT NULL,
                  `setting` text NOT NULL,
                  PRIMARY KEY (`module_id`)
                 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'order_custom_field', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'order_custom_field` (
  		`order_custom_field_id` int(11) NOT NULL AUTO_INCREMENT,
  		`order_id` int(11) NOT NULL,
  		`custom_field_id` int(11) NOT NULL,
  		`custom_field_value_id` int(11) NOT NULL,
  		`name` varchar(255) NOT NULL,
  		`value` text NOT NULL,
  		`type` varchar(32) NOT NULL,
  		`location` varchar(16) NOT NULL,
  		PRIMARY KEY (`order_custom_field_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'recurring', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'recurring` (
  		`recurring_id` int(11) NOT NULL AUTO_INCREMENT,
  		`price` decimal(10,4) NOT NULL,
  		`frequency` enum(\'day\',\'week\',\'semi_month\',\'month\',\'year\') NOT NULL,
  		`duration` int(10) unsigned NOT NULL,
  		`cycle` int(10) unsigned NOT NULL,
  		`trial_status` tinyint(4) NOT NULL,
  		`trial_price` decimal(10,4) NOT NULL,
  		`trial_frequency` enum(\'day\',\'week\',\'semi_month\',\'month\',\'year\') NOT NULL,
  		`trial_duration` int(10) unsigned NOT NULL,
  		`trial_cycle` int(10) unsigned NOT NULL,
  		`status` tinyint(4) NOT NULL,
  		`sort_order` int(11) NOT NULL,
  		PRIMARY KEY (`recurring_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'product_recurring', $this->getTables())) {
            $sql = '
			CREATE TABLE IF NOT EXISTS `'. $this->prefix .'product_recurring` (
			`product_id` int(11) NOT NULL,
			`recurring_id` int(11) NOT NULL,
			`customer_group_id` int(11) NOT NULL,
			PRIMARY KEY (`product_id`,`recurring_id`,`customer_group_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix . 'recurring_description', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'recurring_description` (
  		`recurring_id` int(11) NOT NULL,
  		`language_id` int(11) NOT NULL,
  		`name` varchar(255) NOT NULL,
  		PRIMARY KEY (`recurring_id`,`language_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix . 'upload', $this->getTables())) {
            $sql = '
  		CREATE TABLE IF NOT EXISTS `' . $this->prefix . 'upload` (
  		`upload_id` int(11) NOT NULL AUTO_INCREMENT,
  		`name` varchar(255) NOT NULL,
  		`filename` varchar(255) NOT NULL,
  		`code` varchar(255) NOT NULL,
  		`date_added` datetime NOT NULL,
  		PRIMARY KEY (`upload_id`)
  		) ENGINE=MyISAM DEFAULT CHARSET=utf8';

            $this->db->query($sql);


        }

        if (!array_search($this->prefix .'custom_field', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'custom_field` (
                  `custom_field_id` int(11) NOT NULL AUTO_INCREMENT,
                  `type` varchar(32) COLLATE utf8_general_ci NOT NULL,
                  `value` text COLLATE utf8_general_ci NOT NULL,
                  `location` varchar(7) COLLATE utf8_general_ci NOT NULL,
                  `status` tinyint(1) NOT NULL,
                  `sort_order` int(3) NOT NULL,
                  PRIMARY KEY (`custom_field_id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix .'custom_field_customer_group', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'custom_field_customer_group` (
                      `custom_field_id` int(11) NOT NULL,
                      `customer_group_id` int(11) NOT NULL,
                      `required` tinyint(1) NOT NULL,
                      PRIMARY KEY (`custom_field_id`,`customer_group_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix .'custom_field_description', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'custom_field_description` (
              `custom_field_id` int(11) NOT NULL,
              `language_id` int(11) NOT NULL,
              `name` varchar(128) COLLATE utf8_general_ci NOT NULL,
              PRIMARY KEY (`custom_field_id`,`language_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix .'custom_field_value', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'custom_field_value` (
              `custom_field_value_id` int(11) NOT NULL AUTO_INCREMENT,
              `custom_field_id` int(11) NOT NULL,
              `sort_order` int(3) NOT NULL,
              PRIMARY KEY (`custom_field_value_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix .'custom_field_value_description', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'custom_field_value_description` (
              `custom_field_value_id` int(11) NOT NULL,
              `language_id` int(11) NOT NULL,
              `custom_field_id` int(11) NOT NULL,
              `name` varchar(128) COLLATE utf8_general_ci NOT NULL,
              PRIMARY KEY (`custom_field_value_id`,`language_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix .'order_recurring', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'order_recurring` (
              `order_recurring_id` int(11) NOT NULL AUTO_INCREMENT,
              `order_id` int(11) NOT NULL,
              `reference` varchar(255) COLLATE utf8_general_ci NOT NULL,
              `product_id` int(11) NOT NULL,
              `product_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
              `product_quantity` int(11) NOT NULL,
              `recurring_id` int(11) NOT NULL,
              `recurring_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
              `recurring_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
              `recurring_frequency` varchar(25) NOT NULL,
              `recurring_cycle` smallint(6) NOT NULL,
              `recurring_duration` smallint(6) NOT NULL,
              `recurring_price` decimal(10,4) NOT NULL,
              `trial` tinyint(1) NOT NULL,
              `trial_frequency` varchar(25) NOT NULL,
              `trial_cycle` smallint(6) NOT NULL,
              `trial_duration` smallint(6) NOT NULL,
              `trial_price` decimal(10,4) NOT NULL,
              `status` tinyint(4) NOT NULL,
              `date_added` datetime NOT NULL,
              PRIMARY KEY (`order_recurring_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);
        }

        if (!array_search($this->prefix .'order_recurring_transaction', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'order_recurring_transaction` (
              `order_recurring_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
              `order_recurring_id` int(11) NOT NULL,
              `reference` varchar(255) COLLATE utf8_general_ci NOT NULL,
              `type` varchar(255) COLLATE utf8_general_ci NOT NULL,
              `amount` decimal(10,4) NOT NULL,
              `date_added` datetime NOT NULL,
              PRIMARY KEY (`order_recurring_transaction_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
            ';

            $this->db->query($sql);
        }
			
        if (!array_search($this->prefix .'customer_online', $this->getTables())) {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->prefix .'customer_online` (
			  `ip` varchar(40) COLLATE utf8_general_ci NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `url` text COLLATE utf8_general_ci NOT NULL,
			  `referer` text COLLATE utf8_general_ci NOT NULL,
			  `date_added` datetime NOT NULL,
			  PRIMARY KEY (`ip`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

            $this->db->query($sql);
        }

        if (!$this->hasLayout('Compare')) {
            $sql = 'SELECT MAX(layout_id) as maxim FROM `' . $this->prefix . 'layout`';

            $query = $this->db->query($sql);
            $layout_id = $query->row['maxim'] + 1;
            $layout_id2 = $layout_id + 1;


            $sql = '
                     INSERT INTO `' . $this->prefix . 'layout` (`layout_id`, `name`) VALUES
                     (' . $layout_id . ', \'Compare\'),
                     (' . $layout_id2 . ', \'Search\')';

            $this->db->query($sql);


            $sql = 'SELECT MAX(layout_route_id) as layout_route
                       FROM `' . $this->prefix . 'layout_route`';

            $query = $this->db->query($sql);
            $layout_route_id = $query->row['layout_route'] + 1;
            $layout_route_id2 = $layout_route_id + 1;

            $sql = '
                     INSERT INTO
                                `' . $this->prefix . 'layout_route` (`layout_route_id`, `layout_id`, `route`)
                     VALUES
                                (' . $layout_route_id . ', ' . $layout_id . ', \'product/compare\'),
                                (' . $layout_route_id2 . ', ' . $layout_id2 . ', \'product/search\')';

            $this->db->query($sql);

        }
        return $text;
    }

    public function deleteTables($data)
    {

        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        $this->simulate = (!empty($data['simulate']) ? true : false);
        $this->showOps = (!empty($data['showOps']) ? true : false);

        $deletetab = 0;
        $text = '';

        $droptable = array(
            'coupon_description',
            'customer_field',
            'customer_ip_blacklist',
            'order_download',
            'order_field',
            'order_misc',
            'product_featured',
            'product_option_description',
            'product_option_value_description',
            'product_profile',
            'product_tag',
            'product_tags',
            'profile',
            'profile_description',
            'store_description'
        );

        foreach ($droptable as $table) {
            if (array_search($this->prefix . $table, $this->getTables())) {
                $sql = 'DROP TABLE `' . $this->prefix . $table . '`';

                $this->db->query($sql);

                ++$deletetab;

                $this->cache->delete($table);
            }

        }
        if (array_search($this->prefix . 'return_product', $this->getTables())) {

            $sql = '
                    SELECT
                           *
                    FROM  `' . $this->prefix . 'return_product`';

            $query = $this->db->query($sql);

            if (count($query->rows) > 0) {
                /*
                 * Change content from table return_product
                 * to table return
                 */
                foreach ($query->rows as $id) {

                    $sql = '
    		  UPDATE
    		 	   `' . $this->prefix . 'return`
                      SET
                               `product_id`       = \'' . $id['product_id'] . '\',
                               `product`          = \'' . $id['name'] . '\',
                               `model`            = \'' . $id['model'] . '\',
                               `quantity`         = \'' . $id['quantity'] . '\',
                               `opened`           = \'' . $id['opened'] . '\',
                               `return_reason_id` = \'' . $id['return_reason_id'] . '\',
                               `return_action_id` = \'' . $id['return_action_id'] . '\',
                               `comment`          = \'' . $id['comment'] . '\'
                     WHERE
                               `return_id`        = \'' . $id['return_id'] . '\'';


                    $this->db->query($sql);



                }
            }
            $sql = 'DROP TABLE `' . $this->prefix . 'return_product`';

            $this->db->query($sql);


            ++$deletetab;

        }


        $text .= '<div class="header round"> ';
        $text .= ' </div>';

        return $text;

    }

    public function addColumns($data)
    {
        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        $this->simulate = (!empty($data['simulate']) ? true : false);
        $this->showOps = (!empty($data['showOps']) ? true : false);

        $vars = array(
            array(
                'table' => 'address',
                'field' => 'custom_field',
                'column' => ' text NOT NULL'
            ),
            array(
                'table' => 'affiliate',
                'field' => 'salt',
                'column' => ' varchar(9) NOT NULL AFTER password'
            ),
            array(
                'table' => 'banner_image',
                'field' => 'sort_order',
                'column' => ' int(3) NOT NULL'
            ),
            array(
                'table' => 'category',
                'field' => 'column',
                'column' => ' varchar(255) NOT NULL AFTER parent_id'
            ),
            array(
                'table' => 'category',
                'field' => 'top',
                'column' => ' tinyint(1) NOT NULL AFTER parent_id'
            ),
            array(
                'table' => 'category_description',
                'field' => 'meta_title',
                'column' => ' varchar(255) NOT NULL AFTER description'
            ),
            array(
                'table' => 'coupon',
                'field' => 'name',
                'column' => ' varchar(128) NOT NULL AFTER coupon_id'
            ),
            array(
                'table' => 'country',
                'field' => 'postcode_required',
                'column' => ' tinyint(1) NOT NULL AFTER address_format'
            ),
            array(
                'table' => 'custom_field',
                'field' => 'status',
                'column' => ' tinyint(1) NOT NULL AFTER location'
            ),
            array(
                'table' => 'customer',
                'field' => 'custom_field',
                'column' => ' text NOT NULL AFTER address_id'
            ),
            array(
                'table' => 'customer',
                'field' => 'salt',
                'column' => ' varchar(9) NOT NULL AFTER password'
            ),
            array(
                'table' => 'customer',
                'field' => 'safe',
                'column' => ' tinyint(1) NOT NULL'
            ),
            array(
                'table' => 'customer',
                'field' => 'token',
                'column' => ' varchar(255) NOT NULL AFTER approved'
            ),
            array(
                'table' => 'customer',
                'field' => 'wishlist',
                'column' => ' text AFTER cart'
            ),
            array(
                'table' => 'information',
                'field' => 'bottom',
                'column' => ' int(1) NOT NULL AFTER information_id'
            ),
            array(
                'table' => 'information_description',
                'field' => 'meta_title',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'information_description',
                'field' => 'meta_description',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'information_description',
                'field' => 'meta_keyword',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'approval',
                'column' => ' int(1) NOT NULL'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'sort_order',
                'column' => ' int(3) NOT NULL'
            ),
            array(
                'table' => 'option_value',
                'field' => 'image',
                'column' => ' varchar(255) NOT NULL AFTER option_id'
            ),
            array(
                'table' => 'order',
                'field' => 'payment_code',
                'column' => ' varchar(128) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'affiliate_id',
                'column' => ' int(11) NOT NULL AFTER order_status_id'
            ),
            array(
                'table' => 'order',
                'field' => 'custom_field',
                'column' => ' text NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'commission',
                'column' => ' decimal(15,8) NOT NULL AFTER order_status_id'
            ),
            array(
                'table' => 'order',
                'field' => 'payment_custom_field',
                'column' => ' text NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'shipping_custom_field',
                'column' => ' text NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'shipping_code',
                'column' => ' varchar(128) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'forwarded_ip',
                'column' => ' varchar(40) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'user_agent',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'accept_language',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'marketing_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'tracking',
                'column' => ' varchar(64) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'currency_value',
                'column' => ' decimal(15,8) NOT NULL DEFAULT \'1.00000000\''
            ),
            array(
                'table' => 'order_product',
                'field' => 'reward',
                'column' => ' int(8) NOT NULL'
            ),
            array(
                'table' => 'order_recurring_transaction',
                'field' => 'reference',
                'column' => ' varchar(255) NOT NULL AFTER order_recurring_id'
            ),
            array(
                'table' => 'product',
                'field' => 'mpn',
                'column' => ' varchar(64) NOT NULL AFTER sku'
            ),
            array(
                'table' => 'product',
                'field' => 'isbn',
                'column' => ' varchar(17) NOT NULL AFTER sku'
            ),
            array(
                'table' => 'product',
                'field' => 'jan',
                'column' => ' varchar(13) NOT NULL AFTER sku'
            ),
            array(
                'table' => 'product',
                'field' => 'ean',
                'column' => ' varchar(14) NOT NULL AFTER sku'
            ),
            array(
                'table' => 'product',
                'field' => 'upc',
                'column' => ' varchar(12) NOT NULL AFTER sku'
            ),
            array(
                'table' => 'product',
                'field' => 'minimum',
                'column' => ' int(11) NOT NULL AFTER length_class_id'
            ),
            array(
                'table' => 'product',
                'field' => 'points',
                'column' => ' int(8) NOT NULL AFTER price'
            ),
            array(
                'table' => 'product',
                'field' => 'sort_order',
                'column' => ' int(11) NOT NULL AFTER viewed'
            ),
            array(
                'table' => 'product_image',
                'field' => 'sort_order',
                'column' => ' int(3) NOT NULL'
            ),
            array(
                'table' => 'product_description',
                'field' => 'meta_title',
                'column' => ' varchar(255) NOT NULL AFTER description'
            ),
            array(
                'table' => 'product_description',
                'field' => 'tag',
                'column' => ' text NOT NULL AFTER description'
            ),
            array(
                'table' => 'product_option',
                'field' => 'option_id',
                'column' => ' int(11) NOT NULL AFTER product_id'
            ),
            array(
                'table' => 'product_option',
                'field' => 'required',
                'column' => ' tinyint(1) NOT NULL'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'option_value_id',
                'column' => ' int(11) NOT NULL AFTER product_id'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'option_id',
                'column' => ' int(11) NOT NULL AFTER product_id'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'weight_prefix',
                'column' => ' varchar(1) NOT NULL AFTER price'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'weight',
                'column' => ' decimal(15,8) NOT NULL AFTER price'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'points_prefix',
                'column' => ' varchar(1) NOT NULL AFTER price'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'points',
                'column' => ' int(8) NOT NULL AFTER price'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'price_prefix',
                'column' => ' varchar(1) NOT NULL AFTER price'
            ),
            array(
                'table' => 'product_recurring',
                'field' => 'customer_group_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'product_recurring',
                'field' => 'recurring_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'product_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'product',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'model',
                'column' => ' varchar(64) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'quantity',
                'column' => ' int(4) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'opened',
                'column' => ' tinyint(1) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'return_reason_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'return',
                'field' => 'return_action_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'setting',
                'field' => 'serialized',
                'column' => ' tinyint(1) NOT NULL'
            ),
            array(
                'table' => 'setting',
                'field' => 'store_id',
                'column' => ' int(11) NOT NULL AFTER setting_id'
            ),
            array(
                'table' => 'tax_rate',
                'field' => 'type',
                'column' => ' char(1) NOT NULL AFTER rate'
            ),
            array(
                'table' => 'user',
                'field' => 'code',
                'column' => ' varchar(40) NOT NULL AFTER email'
            ),
            array(
                'table' => 'user',
                'field' => 'image',
                'column' => ' varchar(255) NOT NULL AFTER email'
            ),
            array(
                'table' => 'user',
                'field' => 'salt',
                'column' => ' varchar(9) NOT NULL AFTER password'
            )
        );

        $altercounter = 0;
        $text = '';

        foreach ($vars as $k => $v) {

            if (array_search($this->prefix . $v['table'], $this->getTables()) || $v['table'] == 'address') {
                if (!array_search($v['field'], $this->getDbColumns($v['table']))) {

                    $sql = '
                        ALTER TABLE
                            `' . $this->prefix . $v['table'] . '`
                        ADD COLUMN
                            `' . $v['field'] . '`' . $v['column'];

                    $this->db->query($sql);

                    ++$altercounter;
                    if ($v['table'] == 'category' && $v['field'] == 'top') {
                        $sql = '
                            UPDATE
                                `' . $this->prefix . $v['table'] . '`
                            SET
                                `top` = \'1\'';

                        $this->db->query($sql);
                    }
                    $this->cache->delete($v['table']);

                }
            }
        }

        $text .= '<div class="header round"> ';
        $text .= ' </div>';

        return $text;
    }

    public function deleteColumns()
    {
        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        /**
         * Delete Columns
         * */

        $delcols = array(
            array(
                'table' => 'address',
                'field' => 'company_id'
            ),
            array(
                'table' => 'address',
                'field' => 'tax_id'
            ),
            array(
                'table' => 'customer_field',
                'field' => 'position'
            ),
            array(
                'table' => 'customer_field',
                'field' => 'required'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'company_id_display'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'company_id_required'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'name'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'tax_id_display'
            ),
            array(
                'table' => 'customer_group',
                'field' => 'tax_id_required'
            ),
            array(
                'table' => 'download',
                'field' => 'remaining'
            ),
            array(
                'table' => 'order',
                'field' => 'coupon_id'
            ),
            array(
                'table' => 'order',
                'field' => 'coupon_id'
            ),
            array(
                'table' => 'order',
                'field' => 'invoice_date'
            ),
            array(
                'table' => 'order',
                'field' => 'payment_tax_id'
            ),
            array(
                'table' => 'order',
                'field' => 'reward'
            ),
            array(
                'table' => 'order',
                'field' => 'value'
            ),
            array(
                'table' => 'order_product',
                'field' => 'subtract'
            ),
            array(
                'table' => 'order_total',
                'field' => 'text'
            ),
            array(
                'table' => 'product',
                'field' => 'cost'
            ),
            array(
                'table' => 'product',
                'field' => 'maximum'
            ),
            array(
                'table' => 'product_recurring',
                'field' => 'store_id'
            ),
            array(
                'table' => 'product_option',
                'field' => 'sort_order'
            ),
            array(
                'table' => 'tax_rate',
                'field' => 'priority'
            ),
            array(
                'table' => 'tax_rate',
                'field' => 'tax_class_id'
            )
        );

        $deletecol = 0;
        $text = '';
        foreach ($delcols as $k => $v) {

            if (array_search($this->prefix . $v['table'], $this->getTables())) {
                if (array_search($v['field'], $this->getDbColumns($v['table']))) {

                    $sql = '
    			ALTER TABLE
    				`' . $this->prefix . $v['table'] . '`
    			DROP COLUMN
    				`' . $v['field'] . '`';

                    $this->db->query($sql);

                    ++$deletecol;
                    if (!$this->simulate) {
                        $this->cache->delete($v['table']);
                    }
                }
            }
        }

        $text .= '<div class="header round"> ';
        $text .= ' </div>';

        return $text;
    }

    public function changeColumns()
    {
        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        $text = '';
        $changecols = array(
            array(
                'table' => 'category_description',
                'field' => 'meta_keyword',
                'oldfield' => 'meta_keywords',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'extension',
                'field' => 'code',
                'oldfield' => 'key',
                'column' => ' varchar(32) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'invoice_no',
                'oldfield' => 'invoice_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'order',
                'field' => 'currency_code',
                'oldfield' => 'currency',
                'column' => ' varchar(3) NOT NULL'
            ),
            array(
                'table' => 'order_recurring',
                'field' => 'reference',
                'oldfield' => 'profile_reference',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'order_recurring',
                'field' => 'recurring_name',
                'oldfield' => 'profile_name',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'order_recurring',
                'field' => 'recurring_description',
                'oldfield' => 'profile_description',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'order_recurring',
                'field' => 'recurring_id',
                'oldfield' => 'profile_id',
                'column' => ' int(11) NOT NULL'
            ),
            array(
                'table' => 'order_recurring',
                'field' => 'date_added',
                'oldfield' => 'created',
                'column' => ' datetime NOT NULL'
            ),
            array(
                'table' => 'order_recurring_transaction',
                'field' => 'date_added',
                'oldfield' => 'created',
                'column' => ' datetime NOT NULL'
            ),
            array(
                'table' => 'product_description',
                'field' => 'meta_keyword',
                'oldfield' => 'meta_keywords',
                'column' => ' varchar(255) NOT NULL'
            ),
            array(
                'table' => 'product_option',
                'field' => 'value',
                'oldfield' => 'option_value',
                'column' => ' text NOT NULL'
            ),
            array(
                'table' => 'setting',
                'field' => 'code',
                'oldfield' => 'group',
                'column' => ' varchar(32) NOT NULL'
            )
        );


        $changetype = array(
            array(
                'table' => 'affiliate',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'affiliate',
                'field' => 'approved',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'banner',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'category',
                'field' => 'top',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'category',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'country',
                'field' => 'postcode_required',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'country',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 1'
            ),
            array(
                'table' => 'coupon',
                'field' => 'logged',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'coupon',
                'field' => 'shipping',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'coupon',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'currency',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'customer',
                'field' => 'newsletter',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'customer',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'customer',
                'field' => 'approved',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'information',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT \'1\''
            ),
            array(
                'table' => 'language',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'order_history',
                'field' => 'notify',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'customer',
                'field' => 'approved',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'product',
                'field' => 'shipping',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT \'1\''
            ),
            array(
                'table' => 'product',
                'field' => 'subtract',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT \'1\''
            ),
            array(
                'table' => 'product',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'product_option',
                'field' => 'required',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'product_option_value',
                'field' => 'subtract',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'return_history',
                'field' => 'notify',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'review',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'user',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'voucher',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT 0'
            ),
            array(
                'table' => 'zone',
                'field' => 'status',
                'type' => 'inyint(',
                'column' => ' tinyint(1) NOT NULL DEFAULT \'1\''
            )
        );

        $changecounter = 0;

        $keyset = array(
            array(
                'table' => 'category',
                'index' => 'parent_id',
                'field' => 'parent_id'
            ),
            array(
                'table' => 'product_discount',
                'index' => 'product_id',
                'field' => 'product_id'
            ),
            array(
                'table' => 'product_image',
                'index' => 'product_id',
                'field' => 'product_id'
            ),
            array(
                'table' => 'product_special',
                'index' => 'product_id',
                'field' => 'product_id'
            ),
            array(
                'table' => 'review',
                'index' => 'product_id',
                'field' => 'product_id'
            ),
            array(
                'table' => 'url_alias',
                'index' => 'query',
                'field' => 'query'
            ),
            array(
                'table' => 'url_alias',
                'index' => 'keyword',
                'field' => 'keyword'
            )
        );

        foreach ($keyset as $k => $v) {

            if (array_search($this->prefix . $v['table'], $this->getTables())) {
                if (!$this->getColumnKey($v['field'], $v['table'])) {
                    $sql = '
    			CREATE INDEX
    				`' . $v['index'] . '`
                            ON
    			         ' . $this->prefix . $v['table'] . '(' . $v['field'] . ') using
                            BTREE';

                    $this->db->query($sql);

                    ++$changecounter;
                }
            }
        }
        if (array_search('currency_value', $this->getDbColumns('order'))) {
            $sql = '
                     ALTER TABLE
                               `' . $this->prefix . 'order`
                     ALTER
                               `currency_value`
                     SET DEFAULT  \'1.00000000\'';

            $this->db->query($sql);

            ++$changecounter;

        }


        foreach ($changecols as $k => $v) {
            if (array_search($this->prefix . $v['table'], $this->getTables())) {

                if (array_search($this->prefix . $v['table'], $this->getTables()) || $v['table'] == 'address') {

                    if (array_search($v['oldfield'], $this->getDbColumns($v['table'])) && !array_search($v['column'], $this->getDbColumns($v['table']))) {
                        $sql = '
    			ALTER TABLE
    				  `' . $this->prefix . $v['table'] . '`
    			CHANGE
    				  `' . $v['oldfield'] . '` `' . $v['field'] . '` ' . $v['column'];

                        $this->db->query($sql);
                        ++$changecounter;
                        if (!$this->simulate) {
                            $this->cache->delete($v['table']);
                        }
                    }
                    else if (!array_search($v['oldfield'], $this->getDbColumns($v['table'])) &&
                        !array_search($v['field'], $this->getDbColumns($v['table']))
                    ) {
                        $sql = '
    			ALTER TABLE
    				  `' . $this->prefix . $v['table'] . '`
    			ADD COLUMN
    				  `' . $v['field'] . '` ' . $v['column'];

                        $this->db->query($sql);
                    }
                }
            }
        }

        foreach ($changetype as $k => $v) {

            if (array_search($this->prefix . $v['table'], $this->getTables())) {
                if (array_search($v['field'], $this->getDbColumns($v['table'])) && !$this->getColumnType($v['field'], $v['type'], $v['table'])) {
                    $sql = '
    			ALTER TABLE
    				`' . $this->prefix . $v['table'] . '`
    			MODIFY
    				' . $v['field'] . $v['column'];

                    $this->db->query($sql);

                    ++$changecounter;
                    if (!$this->simulate) {
                        $this->cache->delete($v['table']);
                    }
                }
                elseif (!array_search($v['field'], $this->getDbColumns($v['table']))) {
                    $sql = '
    			ALTER TABLE
    				`' . $this->prefix . $v['table'] . '`
    		        ADD COLUMN
    				' . $v['field'] . $v['column'];

                    $this->db->query($sql);

                    ++$changecounter;
                    if (!$this->simulate) {
                        $this->cache->delete($v['table']);
                    }
                }
            }
        }


        $text .= '<div class="header round"> ';
        $text .= ' </div>';

        return $text;
    }

    public function changeImagePaths()
    {
        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        $tables = array(
            'product',
            'banner_image',
            'category',
            'manufacturer',
            'option_value',
            'product_image',
            'voucher_theme'
        );

        foreach ($tables as $table) {
            $sql = "UPDATE `" . $this->prefix . $table . "` SET `image` = REPLACE ( image , 'data', 'catalog' )";
            $this->db->query($sql);
        }
    }

    public function backup($tables) {
        $output = '';
        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        foreach ($tables as $table) {
            $status = true;


            if ($status) {
                $output .= 'TRUNCATE TABLE `' . $this->prefix.$table . '`;' . "\n\n";

                $query = $this->db->query("SELECT * FROM `" . $this->prefix.$table . "`");

                $table_fields = $this->getTableDeafultFields($table);


                foreach ($query->rows as $result) {
                    $fields = '';
                    $values = '';


                    foreach ($result as $key => $value) {
                        if(!in_array($key, $table_fields)) {
                            continue;
                        }

                        $fields .= '`' . $key . '`, ';

                        $value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
                        $value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
                        $value = str_replace('\\', '\\\\',	$value);
                        $value = str_replace('\'', '\\\'',	$value);
                        $value = str_replace('\\\n', '\n',	$value);
                        $value = str_replace('\\\r', '\r',	$value);
                        $value = str_replace('\\\t', '\t',	$value);

                        $values .= '\'' . $value . '\', ';
                    }

                    $output .= 'INSERT IGNORE INTO `' . $this->prefix.$table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
                }

                $output .= "\n\n";
            }
        }

        return $output;
    }

    public function changeSettings() {

        $jdb = MiwoShop::get('db')->getDbo();
        $jprefix = $jdb->getPrefix();
        $this->prefix = $jprefix . 'miwoshop_';

        $this->db->query('TRUNCATE TABLE `'.$this->prefix.'setting`');

        $sql = "INSERT INTO `".$this->prefix."setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
        (1, 0, 'shipping', 'shipping_sort_order', '3', 0),
        (2, 0, 'sub_total', 'sub_total_sort_order', '1', 0),
        (3, 0, 'sub_total', 'sub_total_status', '1', 0),
        (4, 0, 'tax', 'tax_status', '1', 0),
        (5, 0, 'total', 'total_sort_order', '9', 0),
        (6, 0, 'total', 'total_status', '1', 0),
        (7, 0, 'tax', 'tax_sort_order', '5', 0),
        (8, 0, 'free_checkout', 'free_checkout_sort_order', '1', 0),
        (9, 0, 'cod', 'cod_sort_order', '5', 0),
        (10, 0, 'cod', 'cod_total', '0.01', 0),
        (11, 0, 'cod', 'cod_order_status_id', '1', 0),
        (12, 0, 'cod', 'cod_geo_zone_id', '0', 0),
        (13, 0, 'cod', 'cod_status', '1', 0),
        (14, 0, 'shipping', 'shipping_status', '1', 0),
        (15, 0, 'shipping', 'shipping_estimator', '1', 0),
        (27, 0, 'coupon', 'coupon_sort_order', '4', 0),
        (28, 0, 'coupon', 'coupon_status', '1', 0),
        (34, 0, 'flat', 'flat_sort_order', '1', 0),
        (35, 0, 'flat', 'flat_status', '1', 0),
        (36, 0, 'flat', 'flat_geo_zone_id', '0', 0),
        (37, 0, 'flat', 'flat_tax_class_id', '9', 0),
        (41, 0, 'flat', 'flat_cost', '5.00', 0),
        (42, 0, 'credit', 'credit_sort_order', '7', 0),
        (43, 0, 'credit', 'credit_status', '1', 0),
        (53, 0, 'reward', 'reward_sort_order', '2', 0),
        (54, 0, 'reward', 'reward_status', '1', 0),
        (146, 0, 'category', 'category_status', '1', 0),
        (158, 0, 'account', 'account_status', '1', 0),
        (159, 0, 'affiliate', 'affiliate_status', '1', 0),
        (267, 0, 'config', 'config_robots', 'abot\r\ndbot\r\nebot\r\nhbot\r\nkbot\r\nlbot\r\nmbot\r\nnbot\r\nobot\r\npbot\r\nrbot\r\nsbot\r\ntbot\r\nvbot\r\nybot\r\nzbot\r\nbot.\r\nbot/\r\n_bot\r\n.bot\r\n/bot\r\n-bot\r\n:bot\r\n(bot\r\ncrawl\r\nslurp\r\nspider\r\nseek\r\naccoona\r\nacoon\r\nadressendeutschland\r\nah-ha.com\r\nahoy\r\naltavista\r\nananzi\r\nanthill\r\nappie\r\narachnophilia\r\narale\r\naraneo\r\naranha\r\narchitext\r\naretha\r\narks\r\nasterias\r\natlocal\r\natn\r\natomz\r\naugurfind\r\nbackrub\r\nbannana_bot\r\nbaypup\r\nbdfetch\r\nbig brother\r\nbiglotron\r\nbjaaland\r\nblackwidow\r\nblaiz\r\nblog\r\nblo.\r\nbloodhound\r\nboitho\r\nbooch\r\nbradley\r\nbutterfly\r\ncalif\r\ncassandra\r\nccubee\r\ncfetch\r\ncharlotte\r\nchurl\r\ncienciaficcion\r\ncmc\r\ncollective\r\ncomagent\r\ncombine\r\ncomputingsite\r\ncsci\r\ncurl\r\ncusco\r\ndaumoa\r\ndeepindex\r\ndelorie\r\ndepspid\r\ndeweb\r\ndie blinde kuh\r\ndigger\r\nditto\r\ndmoz\r\ndocomo\r\ndownload express\r\ndtaagent\r\ndwcp\r\nebiness\r\nebingbong\r\ne-collector\r\nejupiter\r\nemacs-w3 search engine\r\nesther\r\nevliya celebi\r\nezresult\r\nfalcon\r\nfelix ide\r\nferret\r\nfetchrover\r\nfido\r\nfindlinks\r\nfireball\r\nfish search\r\nfouineur\r\nfunnelweb\r\ngazz\r\ngcreep\r\ngenieknows\r\ngetterroboplus\r\ngeturl\r\nglx\r\ngoforit\r\ngolem\r\ngrabber\r\ngrapnel\r\ngralon\r\ngriffon\r\ngromit\r\ngrub\r\ngulliver\r\nhamahakki\r\nharvest\r\nhavindex\r\nhelix\r\nheritrix\r\nhku www octopus\r\nhomerweb\r\nhtdig\r\nhtml index\r\nhtml_analyzer\r\nhtmlgobble\r\nhubater\r\nhyper-decontextualizer\r\nia_archiver\r\nibm_planetwide\r\nichiro\r\niconsurf\r\niltrovatore\r\nimage.kapsi.net\r\nimagelock\r\nincywincy\r\nindexer\r\ninfobee\r\ninformant\r\ningrid\r\ninktomisearch.com\r\ninspector web\r\nintelliagent\r\ninternet shinchakubin\r\nip3000\r\niron33\r\nisraeli-search\r\nivia\r\njack\r\njakarta\r\njavabee\r\njetbot\r\njumpstation\r\nkatipo\r\nkdd-explorer\r\nkilroy\r\nknowledge\r\nkototoi\r\nkretrieve\r\nlabelgrabber\r\nlachesis\r\nlarbin\r\nlegs\r\nlibwww\r\nlinkalarm\r\nlink validator\r\nlinkscan\r\nlockon\r\nlwp\r\nlycos\r\nmagpie\r\nmantraagent\r\nmapoftheinternet\r\nmarvin/\r\nmattie\r\nmediafox\r\nmediapartners\r\nmercator\r\nmerzscope\r\nmicrosoft url control\r\nminirank\r\nmiva\r\nmj12\r\nmnogosearch\r\nmoget\r\nmonster\r\nmoose\r\nmotor\r\nmultitext\r\nmuncher\r\nmuscatferret\r\nmwd.search\r\nmyweb\r\nnajdi\r\nnameprotect\r\nnationaldirectory\r\nnazilla\r\nncsa beta\r\nnec-meshexplorer\r\nnederland.zoek\r\nnetcarta webmap engine\r\nnetmechanic\r\nnetresearchserver\r\nnetscoop\r\nnewscan-online\r\nnhse\r\nnokia6682/\r\nnomad\r\nnoyona\r\nnutch\r\nnzexplorer\r\nobjectssearch\r\noccam\r\nomni\r\nopen text\r\nopenfind\r\nopenintelligencedata\r\norb search\r\nosis-project\r\npack rat\r\npageboy\r\npagebull\r\npage_verifier\r\npanscient\r\nparasite\r\npartnersite\r\npatric\r\npear.\r\npegasus\r\nperegrinator\r\npgp key agent\r\nphantom\r\nphpdig\r\npicosearch\r\npiltdownman\r\npimptrain\r\npinpoint\r\npioneer\r\npiranha\r\nplumtreewebaccessor\r\npogodak\r\npoirot\r\npompos\r\npoppelsdorf\r\npoppi\r\npopular iconoclast\r\npsycheclone\r\npublisher\r\npython\r\nrambler\r\nraven search\r\nroach\r\nroad runner\r\nroadhouse\r\nrobbie\r\nrobofox\r\nrobozilla\r\nrules\r\nsalty\r\nsbider\r\nscooter\r\nscoutjet\r\nscrubby\r\nsearch.\r\nsearchprocess\r\nsemanticdiscovery\r\nsenrigan\r\nsg-scout\r\nshai''hulud\r\nshark\r\nshopwiki\r\nsidewinder\r\nsift\r\nsilk\r\nsimmany\r\nsite searcher\r\nsite valet\r\nsitetech-rover\r\nskymob.com\r\nsleek\r\nsmartwit\r\nsna-\r\nsnappy\r\nsnooper\r\nsohu\r\nspeedfind\r\nsphere\r\nsphider\r\nspinner\r\nspyder\r\nsteeler/\r\nsuke\r\nsuntek\r\nsupersnooper\r\nsurfnomore\r\nsven\r\nsygol\r\nszukacz\r\ntach black widow\r\ntarantula\r\ntempleton\r\n/teoma\r\nt-h-u-n-d-e-r-s-t-o-n-e\r\ntheophrastus\r\ntitan\r\ntitin\r\ntkwww\r\ntoutatis\r\nt-rex\r\ntutorgig\r\ntwiceler\r\ntwisted\r\nucsd\r\nudmsearch\r\nurl check\r\nupdated\r\nvagabondo\r\nvalkyrie\r\nverticrawl\r\nvictoria\r\nvision-search\r\nvolcano\r\nvoyager/\r\nvoyager-hc\r\nw3c_validator\r\nw3m2\r\nw3mir\r\nwalker\r\nwallpaper\r\nwanderer\r\nwauuu\r\nwavefire\r\nweb core\r\nweb hopper\r\nweb wombat\r\nwebbandit\r\nwebcatcher\r\nwebcopy\r\nwebfoot\r\nweblayers\r\nweblinker\r\nweblog monitor\r\nwebmirror\r\nwebmonkey\r\nwebquest\r\nwebreaper\r\nwebsitepulse\r\nwebsnarf\r\nwebstolperer\r\nwebvac\r\nwebwalk\r\nwebwatch\r\nwebwombat\r\nwebzinger\r\nwhizbang\r\nwhowhere\r\nwild ferret\r\nworldlight\r\nwwwc\r\nwwwster\r\nxenu\r\nxget\r\nxift\r\nxirq\r\nyandex\r\nyanga\r\nyeti\r\nyodao\r\nzao\r\nzippp\r\nzyborg', 0),
        (266, 0, 'config', 'config_shared', '0', 0),
        (265, 0, 'config', 'config_secure', '0', 0),
        (264, 0, 'config', 'config_fraud_status_id', '7', 0),
        (263, 0, 'config', 'config_fraud_score', '', 0),
        (262, 0, 'config', 'config_fraud_key', '', 0),
        (94, 0, 'voucher', 'voucher_sort_order', '8', 0),
        (95, 0, 'voucher', 'voucher_status', '1', 0),
        (261, 0, 'config', 'config_fraud_detection', '0', 0),
        (260, 0, 'config', 'config_mail_alert', '', 0),
        (103, 0, 'free_checkout', 'free_checkout_status', '1', 0),
        (104, 0, 'free_checkout', 'free_checkout_order_status_id', '1', 0),
        (258, 0, 'config', 'config_ftp_status', '0', 0),
        (257, 0, 'config', 'config_ftp_root', '', 0),
        (256, 0, 'config', 'config_ftp_password', '', 0),
        (255, 0, 'config', 'config_ftp_username', '', 0),
        (254, 0, 'config', 'config_ftp_port', '21', 0),
        (253, 0, 'config', 'config_ftp_hostname', '', 0),
        (252, 0, 'config', 'config_image_location_height', '50', 0),
        (251, 0, 'config', 'config_image_location_width', '268', 0),
        (250, 0, 'config', 'config_image_cart_height', '47', 0),
        (249, 0, 'config', 'config_image_cart_width', '47', 0),
        (248, 0, 'config', 'config_image_wishlist_height', '47', 0),
        (181, 0, 'config', 'config_meta_title', 'Your Store', 0),
        (182, 0, 'config', 'config_meta_description', 'My Store', 0),
        (183, 0, 'config', 'config_meta_keyword', '', 0),
        (184, 0, 'config', 'config_template', 'default', 0),
        (185, 0, 'config', 'config_layout_id', '4', 0),
        (186, 0, 'config', 'config_country_id', '222', 0),
        (187, 0, 'config', 'config_zone_id', '3563', 0),
        (188, 0, 'config', 'config_language', 'en', 0),
        (189, 0, 'config', 'config_admin_language', 'en', 0),
        (190, 0, 'config', 'config_currency', 'USD', 0),
        (191, 0, 'config', 'config_currency_auto', '1', 0),
        (192, 0, 'config', 'config_length_class_id', '1', 0),
        (193, 0, 'config', 'config_weight_class_id', '1', 0),
        (194, 0, 'config', 'config_product_count', '1', 0),
        (195, 0, 'config', 'config_product_limit', '15', 0),
        (196, 0, 'config', 'config_product_description_length', '75', 0),
        (197, 0, 'config', 'config_limit_admin', '20', 0),
        (198, 0, 'config', 'config_review_status', '1', 0),
        (199, 0, 'config', 'config_review_guest', '1', 0),
        (200, 0, 'config', 'config_review_mail', '0', 0),
        (201, 0, 'config', 'config_voucher_min', '1', 0),
        (202, 0, 'config', 'config_voucher_max', '1000', 0),
        (203, 0, 'config', 'config_tax', '1', 0),
        (204, 0, 'config', 'config_tax_default', 'shipping', 0),
        (205, 0, 'config', 'config_tax_customer', 'shipping', 0),
        (206, 0, 'config', 'config_customer_online', '0', 0),
        (207, 0, 'config', 'config_customer_group_id', '1', 0),
        (208, 0, 'config', 'config_customer_group_display', 'a:1:{i:0;s:1:\"1\";}', 1),
        (209, 0, 'config', 'config_customer_price', '0', 0),
        (210, 0, 'config', 'config_account_id', '3', 0),
        (211, 0, 'config', 'config_account_mail', '0', 0),
        (212, 0, 'config', 'config_invoice_prefix', 'INV-2013-00', 0),
        (213, 0, 'config', 'config_api_id', '1', 0),
        (214, 0, 'config', 'config_cart_weight', '1', 0),
        (215, 0, 'config', 'config_checkout_guest', '1', 0),
        (216, 0, 'config', 'config_checkout_id', '5', 0),
        (217, 0, 'config', 'config_order_status_id', '1', 0),
        (218, 0, 'config', 'config_processing_status', 'a:1:{i:0;s:1:\"2\";}', 1),
        (219, 0, 'config', 'config_complete_status', 'a:1:{i:0;s:1:\"5\";}', 1),
        (220, 0, 'config', 'config_order_mail', '0', 0),
        (221, 0, 'config', 'config_stock_display', '0', 0),
        (222, 0, 'config', 'config_stock_warning', '0', 0),
        (223, 0, 'config', 'config_stock_checkout', '0', 0),
        (224, 0, 'config', 'config_affiliate_approval', '0', 0),
        (225, 0, 'config', 'config_affiliate_auto', '0', 0),
        (226, 0, 'config', 'config_affiliate_commission', '5', 0),
        (227, 0, 'config', 'config_affiliate_id', '4', 0),
        (228, 0, 'config', 'config_affiliate_mail', '0', 0),
        (229, 0, 'config', 'config_return_id', '0', 0),
        (230, 0, 'config', 'config_return_status_id', '2', 0),
        (231, 0, 'config', 'config_logo', 'catalog/logo.png', 0),
        (232, 0, 'config', 'config_icon', 'catalog/cart.png', 0),
        (233, 0, 'config', 'config_image_category_width', '80', 0),
        (234, 0, 'config', 'config_image_category_height', '80', 0),
        (235, 0, 'config', 'config_image_thumb_width', '228', 0),
        (236, 0, 'config', 'config_image_thumb_height', '228', 0),
        (237, 0, 'config', 'config_image_popup_width', '500', 0),
        (238, 0, 'config', 'config_image_popup_height', '500', 0),
        (239, 0, 'config', 'config_image_product_width', '228', 0),
        (240, 0, 'config', 'config_image_product_height', '228', 0),
        (241, 0, 'config', 'config_image_additional_width', '74', 0),
        (242, 0, 'config', 'config_image_additional_height', '74', 0),
        (243, 0, 'config', 'config_image_related_width', '80', 0),
        (244, 0, 'config', 'config_image_related_height', '80', 0),
        (245, 0, 'config', 'config_image_compare_width', '90', 0),
        (246, 0, 'config', 'config_image_compare_height', '90', 0),
        (247, 0, 'config', 'config_image_wishlist_width', '47', 0),
        (180, 0, 'config', 'config_comment', '', 0),
        (179, 0, 'config', 'config_open', '', 0),
        (178, 0, 'config', 'config_image', '', 0),
        (177, 0, 'config', 'config_fax', '', 0),
        (176, 0, 'config', 'config_telephone', '123456789', 0),
        (175, 0, 'config', 'config_email', 'demo@miwoshop.com', 0),
        (174, 0, 'config', 'config_geocode', '', 0),
        (172, 0, 'config', 'config_owner', 'Your Name', 0),
        (173, 0, 'config', 'config_address', 'Address 1', 0),
        (171, 0, 'config', 'config_name', 'Your Store', 0),
        (268, 0, 'config', 'config_seo_url', '0', 0),
        (269, 0, 'config', 'config_file_max_size', '300000', 0),
        (270, 0, 'config', 'config_file_ext_allowed', 'txt\r\npng\r\njpe\r\njpeg\r\njpg\r\ngif\r\nbmp\r\nico\r\ntiff\r\ntif\r\nsvg\r\nsvgz\r\nzip\r\nrar\r\nmsi\r\ncab\r\nmp3\r\nqt\r\nmov\r\npdf\r\npsd\r\nai\r\neps\r\nps\r\ndoc\r\nrtf\r\nxls\r\nppt\r\nodt\r\nods', 0),
        (271, 0, 'config', 'config_file_mime_allowed', 'text/plain\r\nimage/png\r\nimage/jpeg\r\nimage/gif\r\nimage/bmp\r\nimage/vnd.microsoft.icon\r\nimage/tiff\r\nimage/svg+xml\r\napplication/zip\r\napplication/x-rar-compressed\r\napplication/x-msdownload\r\napplication/vnd.ms-cab-compressed\r\naudio/mpeg\r\nvideo/quicktime\r\napplication/pdf\r\nimage/vnd.adobe.photoshop\r\napplication/postscript\r\napplication/msword\r\napplication/rtf\r\napplication/vnd.ms-excel\r\napplication/vnd.ms-powerpoint\r\napplication/vnd.oasis.opendocument.text\r\napplication/vnd.oasis.opendocument.spreadsheet', 0),
        (272, 0, 'config', 'config_maintenance', '0', 0),
        (273, 0, 'config', 'config_password', '1', 0),
        (274, 0, 'config', 'config_encryption', '87431d38e7edce36d5153707d4cd2bf9', 0),
        (275, 0, 'config', 'config_compression', '0', 0),
        (276, 0, 'config', 'config_error_display', '0', 0),
        (277, 0, 'config', 'config_error_log', '0', 0),
        (278, 0, 'config', 'config_error_filename', 'error.log', 0),
        (279, 0, 'config', 'config_google_analytics', '', 0),
        (280, 0, 'config', 'config_miwoshop', 'a:1:{s:6:\"wizard\";s:1:\"1\";}', 1);";

        $this->db->query($sql);
    }
	
	public function addPermissions() {
		$db = MFactory::getDbo();

		$db->setQuery("SELECT permission FROM `#__miwoshop_user_group` WHERE user_group_id = 1");
		$permission = $db->loadResult();
		$permission = unserialize($permission);

		$permission['access'][] = 'dashboard/activity';
		$permission['modify'][] = 'dashboard/activity';

		$permission['access'][] = 'dashboard/chart';
		$permission['modify'][] = 'dashboard/chart';

		$permission['access'][] = 'dashboard/charts';
		$permission['modify'][] = 'dashboard/charts';

		$permission['access'][] = 'dashboard/customer';
		$permission['modify'][] = 'dashboard/customer';

		$permission['access'][] = 'dashboard/map';
		$permission['modify'][] = 'dashboard/map';

		$permission['access'][] = 'dashboard/online';
		$permission['modify'][] = 'dashboard/online';

		$permission['access'][] = 'dashboard/order';
		$permission['modify'][] = 'dashboard/order';

		$permission['access'][] = 'dashboard/recent';
		$permission['modify'][] = 'dashboard/recent';

		$permission['access'][] = 'dashboard/recenttabs';
		$permission['modify'][] = 'dashboard/recenttabs';

		$permission['access'][] = 'dashboard/sale';
		$permission['modify'][] = 'dashboard/sale';

		$permission = serialize($permission);

		$db->setQuery("UPDATE `#__miwoshop_user_group` SET permission = '".$permission."' WHERE user_group_id = 1");
		$db->query();
	}

    /* Not using directly */

    private function getTableDeafultFields($table) {
        $address = array('address_id', 'customer_id', 'firstname', 'lastname', 'company', 'address_1', 'address_2', 'city', 'postcode', 'country_id', 'zone_id', 'custom_field');

        $affiliate = array( 'affiliate_id', 'firstname', 'lastname', 'email', 'telephone', 'fax', 'password', 'salt', 'company', 'website', 'address_1', 'address_2', 'city', 'postcode', 'country_id', 'zone_id', 	 'code', 'commission', 'tax', 'payment',	 'cheque', 'paypal', 'bank_name', 'bank_branch_number', 'bank_swift_code', 'bank_account_name', 'bank_account_number', 'ip', 'status', 'approved', 'date_added');

        $affiliate_activity = array( 'activity_id', 'affiliate_id', 'key', 'data', 'ip', 'date_added');

        $affiliate_login = array( 'affiliate_login_id', 'email', 'ip', 'total', 'date_added', 'date_modified');

        $affiliate_transaction = array( 'affiliate_transaction_id' , 'affiliate_id' , 'order_id' , 'description' , 'amount' , 'date_added' );

        $api = array( 'api_id' , 'username' , 'firstname' , 'lastname' , 'password' , 'status' , 'date_added' , 'date_modified' );

        $attribute = array( 'attribute_id', 'attribute_group_id', 'sort_order' );

        $attribute_description = array( 'attribute_id', 'language_id', 'name');

        $attribute_group = array( 'attribute_group_id', 'sort_order');

        $attribute_group_description = array( 'attribute_group_id', 'language_id', 'name');

        $banner = array( 'banner_id', 'name', 'status');

        $banner_image = array( 'banner_image_id', 'banner_id', 'link', 'image', 'sort_order');

        $banner_image_description = array( 'banner_image_id', 'language_id', 'banner_id', 'title');

        $category = array( 'category_id', 'image', 'parent_id', 'top', 'column', 'sort_order', 'status', 'date_added', 'date_modified');

        $category_description = array( 'category_id', 'language_id', 'name', 'description', 'meta_title', 'meta_description', 'meta_keyword');

        $category_filter = array( 'category_id' , 'filter_id');

        $category_path = array( 'category_id', 'path_id', 'level');

        $category_to_layout = array( 'category_id', 'store_id', 'layout_id');

        $category_to_store = array( 'category_id', 'store_id');

        $country = array( 'country_id', 'name', 'iso_code_2', 'iso_code_3', 'address_format', 'postcode_required', 'status');

        $coupon = array( 'coupon_id', 'name', 'code', 'type', 'discount', 'logged', 'shipping', 'total', 'date_start', 'date_end', 'uses_total', 'uses_customer', 'status', 'date_added');

        $coupon_category = array( 'coupon_id', 'category_id');

        $coupon_history = array( 'coupon_history_id', 'coupon_id', 'order_id', 'customer_id', 'amount', 'date_added');

        $coupon_product = array( 'coupon_product_id', 'coupon_id', 'product_id');

        $currency = array( 'currency_id', 'title', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'status', 'date_modified');

        $customer = array( 'customer_id', 'store_id', 'firstname', 'lastname', 'email', 'telephone', 'fax', 'password', 'salt', 'cart', 'wishlist', 'newsletter', 'address_id', 'custom_field', 'customer_group_id', 'ip', 'status', 'approved', 'token', 'date_added', 'safe');

        $customer_activity = array( 'activity_id', 'customer_id', 'key', 'data', 'ip', 'date_added');

        $customer_ban_ip = array( 'customer_ban_ip_id', 'ip');

        $customer_group = array( 'customer_group_id', 'approval', 'sort_order');

        $customer_group_description = array( 'customer_group_id', 'language_id', 'name', 'description');

        $customer_history = array( 'customer_history_id', 'customer_id', 'comment', 'date_added');

        $customer_ip = array( 'customer_ip_id', 'customer_id', 'ip', 'date_added');

        $customer_login = array( 'customer_login_id', 'email', 'ip', 'total', 'date_added', 'date_modified');

        $customer_online = array('ip', 'customer_id', 'url', 'referer', 'date_added');

        $customer_reward = array('customer_reward_id', 'customer_id', 'order_id', 'description', 'points', 'date_added');

        $customer_transaction = array('customer_transaction_id', 'customer_id', 'order_id', 'description', 'amount', 'date_added');

        $download = array('download_id', 'filename', 'mask', 'date_added');

        $download_description = array('download_id', 'language_id', 'name');

        $event = array('event_id', 'code', 'trigger', 'action');

        $extension = array('extension_id', 'type', 'code');

        $filter = array('filter_id', 'filter_group_id', 'sort_order');

        $filter_description = array('filter_id', 'language_id', 'filter_group_id', 'name');

        $filter_group = array('filter_group_id', 'sort_order');

        $filter_group_description = array('filter_group_id', 'language_id', 'name');

        $geo_zone = array('geo_zone_id', 'name', 'description', 'date_modified', 'date_added');

        $information = array('information_id', 'bottom', 'sort_order', 'status');

        $information_description = array('information_id', 'language_id', 'title', 'description', 'meta_title', 'meta_description', 'meta_keyword');

        $information_to_layout = array('information_id', 'store_id', 'layout_id');

        $information_to_store = array('information_id', 'store_id');

        $j_integrations = array('product_id', 'content');

        $jgroup_cgroup_map = array('jgroup_id', 'cgroup_id');

        $jgroup_ugroup_map = array('jgroup_id', 'ugroup_id');

        $juser_ocustomer_map = array('juser_id', 'ocustomer_id');

        $juser_ouser_map = array('juser_id', 'ouser_id');

        $language = array('language_id', 'name', 'code', 'locale', 'image', 'directory', 'filename', 'sort_order', 'status');

        $layout = array('layout_id', 'name');

        $layout_module = array('layout_module_id', 'layout_id', 'code', 'position', 'sort_order');

        $layout_route = array('layout_route_id', 'layout_id', 'store_id', 'route');

        $length_class = array('length_class_id', 'value');

        $length_class_description = array('length_class_id', 'language_id', 'title', 'unit');

        $location = array('location_id', 'name', 'address', 'telephone', 'fax', 'geocode', 'image', 'open', 'comment');

        $manufacturer = array('manufacturer_id', 'name', 'image', 'sort_order');

        $manufacturer_to_store = array('manufacturer_id', 'store_id');

        $marketing = array('marketing_id', 'name', 'description', 'code', 'clicks', 'date_added');

        $modification = array('modification_id', 'name', 'code', 'author', 'version', 'link', 'xml', 'status', 'date_added');

        $module = array('module_id', 'name', 'code', 'setting');

        $option = array('option_id', 'type', 'sort_order');

        $option_description = array('option_id', 'language_id', 'name');

        $option_value = array('option_value_id', 'option_id', 'image', 'sort_order');

        $option_value_description = array('option_value_id', 'language_id', 'option_id', 'name');

        $order = array('order_id', 'invoice_no', 'invoice_prefix', 'store_id', 'store_name', 'store_url', 'customer_id', 'customer_group_id', 'firstname', 'lastname', 'email', 'telephone', 'fax', 'payment_firstname', 'payment_lastname', 'payment_company', 'payment_company_id', 'payment_address_1', 'payment_address_2', 'payment_city', 'payment_postcode', 'payment_country', 'payment_country_id', 'payment_zone', 'payment_zone_id', 'payment_address_format', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_company', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_postcode', 'shipping_country', 'shipping_country_id', 'shipping_zone', 'shipping_zone_id', 'shipping_address_format', 'shipping_method', 'shipping_code', 'comment', 'total', 'order_status_id', 'affiliate_id', 'commission', 'language_id', 'currency_id', 'currency_code', 'currency_value', 'ip', 'forwarded_ip', 'user_agent', 'accept_language', 'date_added', 'date_modified', 'custom_field', 'payment_custom_field', 'shipping_custom_field', 'marketing_id', 'tracking');

        $order_custom_field = array('order_custom_field_id', 'order_id', 'custom_field_id', 'custom_field_value_id', 'name', 'value', 'type', 'location');

        $order_fraud = array('order_id', 'customer_id', 'country_match', 'country_code', 'high_risk_country', 'distance', 'ip_region', 'ip_city', 'ip_latitude', 'ip_longitude', 'ip_isp', 'ip_org', 'ip_asnum', 'ip_user_type', 'ip_country_confidence', 'ip_region_confidence', 'ip_city_confidence', 'ip_postal_confidence', 'ip_postal_code', 'ip_accuracy_radius', 'ip_net_speed_cell', 'ip_metro_code', 'ip_area_code', 'ip_time_zone', 'ip_region_name', 'ip_domain', 'ip_country_name', 'ip_continent_code', 'ip_corporate_proxy', 'anonymous_proxy', 'proxy_score', 'is_trans_proxy', 'free_mail', 'carder_email', 'high_risk_username', 'high_risk_password', 'bin_match', 'bin_country', 'bin_name_match', 'bin_name', 'bin_phone_match', 'bin_phone', 'customer_phone_in_billing_location', 'ship_forward', 'city_postal_match', 'ship_city_postal_match', 'score', 'explanation', 'risk_score', 'queries_remaining', 'maxmind_id', 'error', 'date_added');

        $order_history = array('order_history_id', 'order_id', 'order_status_id', 'notify', 'comment', 'date_added');

        $order_option = array('order_option_id', 'order_id', 'order_product_id', 'product_option_id', 'product_option_value_id', 'name', 'value', 'type');

        $order_product = array('order_product_id', 'order_id', 'product_id', 'name', 'model', 'quantity', 'price', 'total', 'tax', 'reward');

        $order_status = array('order_status_id', 'language_id', 'name');

        $order_total = array('order_total_id', 'order_id', 'code', 'title', 'value', 'sort_order');

        $order_voucher = array('order_voucher_id', 'order_id', 'voucher_id', 'description', 'code', 'from_name', 'from_email', 'to_name', 'to_email', 'voucher_theme_id', 'message', 'amount');

        $product = array('product_id', 'model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location', 'quantity', 'stock_status_id', 'image', 'manufacturer_id', 'shipping', 'price', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id', 'subtract', 'minimum', 'sort_order', 'status', 'date_added', 'date_modified', 'viewed');

        $product_attribute = array('product_id', 'attribute_id', 'language_id', 'text');

        $product_description = array('product_id', 'language_id', 'name', 'description', 'meta_title', 'meta_description', 'meta_keyword', 'tag');

        $product_discount = array('product_discount_id', 'product_id', 'customer_group_id', 'quantity', 'priority', 'price', 'date_start', 'date_end');

        $product_filter = array('product_id', 'filter_id');

        $product_image = array('product_image_id', 'product_id', 'image', 'sort_order');

        $product_option = array('product_option_id', 'product_id', 'option_id', 'value', 'required');

        $product_option_value = array('product_option_value_id', 'product_option_id', 'product_id', 'option_id', 'option_value_id', 'quantity', 'subtract', 'price', 'price_prefix', 'points', 'points_prefix', 'weight', 'weight_prefix');

        $product_related = array('product_id', 'related_id');

        $product_reward = array('product_reward_id', 'product_id', 'customer_group_id', 'points');

        $product_special = array('product_special_id', 'product_id', 'customer_group_id', 'priority', 'price', 'date_start', 'date_end');

        $product_to_category = array('product_id', 'category_id');

        $product_to_download = array('product_id', 'download_id');

        $product_to_layout = array('product_id', 'store_id', 'layout_id');

        $product_to_store = array('product_id', 'store_id');

        $recurring = array('recurring_id', 'price', 'frequency', 'duration', 'cycle', 'trial_status', 'trial_price', 'trial_frequency', 'trial_duration', 'trial_cycle', 'status', 'sort_order');

        $recurring_description = array('recurring_id', 'language_id', 'name');

        $return = array('return_id', 'order_id', 'product_id', 'customer_id', 'firstname', 'lastname', 'email', 'telephone', 'product', 'model', 'quantity', 'opened', 'return_reason_id', 'return_action_id', 'return_status_id', 'comment', 'date_ordered', 'date_added', 'date_modified');

        $return_action = array('return_action_id', 'language_id', 'name');

        $return_history = array('return_history_id', 'return_id', 'return_status_id', 'notify', 'comment', 'date_added');

        $return_reason = array('return_reason_id', 'language_id', 'name');

        $return_status = array('return_status_id', 'language_id', 'name');

        $review = array('review_id', 'product_id', 'customer_id', 'author', 'text', 'rating', 'status', 'date_added', 'date_modified');

        $stock_status = array('stock_status_id', 'language_id', 'name');

        $store = array('store_id', 'name', 'url', 'ssl');

        $tax_class = array('tax_class_id', 'title', 'description', 'date_added', 'date_modified');

        $tax_rate = array('tax_rate_id', 'geo_zone_id', 'name', 'rate', 'type', 'date_added', 'date_modified');

        $tax_rate_to_customer_group = array('tax_rate_id', 'customer_group_id');

        $tax_rule = array('tax_rule_id', 'tax_class_id', 'tax_rate_id', 'based', 'priority');

        $upload = array('upload_id', 'name', 'filename', 'code');

        $url_alias = array('url_alias_id', 'query', 'keyword', 'language_id');

        $user = array('user_id', 'user_group_id', 'username', 'password', 'salt', 'firstname', 'lastname', 'email', 'image', 'code', 'ip', 'status', 'date_added');

        $user_group = array('user_group_id', 'name', 'permission');

        $voucher = array('voucher_id', 'order_id', 'code', 'from_name', 'from_email', 'to_name', 'to_email', 'voucher_theme_id', 'message', 'amount', 'status', 'date_added');

        $voucher_history = array('voucher_history_id', 'voucher_id', 'order_id', 'amount', 'date_added');

        $voucher_theme = array('voucher_theme_id', 'image');

        $voucher_theme_description = array('voucher_theme_id', 'language_id', 'name');

        $weight_class = array('weight_class_id', 'value');

        $weight_class_description = array('weight_class_id', 'language_id', 'title', 'unit');

        $zone = array('zone_id', 'country_id', 'code', 'name', 'status');

        $zone_to_geo_zone = array('zone_to_geo_zone_id', 'country_id', 'zone_id', 'geo_zone_id', 'date_added', 'date_modified');

        $tables = array(
        	'address' 					 => $address,
        	'affiliate' 				 => $affiliate,
        	'affiliate_activity' 		 => $affiliate_activity,
        	'affiliate_login' 			 => $affiliate_login,
        	'affiliate_transaction' 	 => $affiliate_transaction,
        	'api' 						 => $api,
        	'attribute' 				 => $attribute,
        	'attribute_description' 	 => $attribute_description,
        	'attribute_group' 			 => $attribute_group,
        	'attribute_group_description'=> $attribute_group_description,
        	'banner' 					 => $banner,
        	'banner_image' 				 => $banner_image,
        	'banner_image_description' 	 => $banner_image_description,
        	'category' 					 => $category,
        	'category_description' 		 => $category_description,
        	'category_filter' 			 => $category_filter,
        	'category_path' 			 => $category_path,
        	'category_to_layout' 		 => $category_to_layout,
        	'category_to_store' 		 => $category_to_store,
        	'country' 					 => $country,
        	'coupon' 					 => $coupon,
        	'coupon_category' 			 => $coupon_category,
        	'coupon_history' 			 => $coupon_history,
        	'coupon_product' 			 => $coupon_product,
        	'currency' 					 => $currency,
        	'customer' 					 => $customer,
        	'customer_activity' 		 => $customer_activity,
        	'customer_ban_ip' 			 => $customer_ban_ip,
        	'customer_group' 			 => $customer_group,
        	'customer_group_description' => $customer_group_description,
        	'customer_history' 			 => $customer_history,
        	'customer_ip' 				 => $customer_ip,
        	'customer_login' 			 => $customer_login,
        	'customer_online' 			 => $customer_online,
        	'customer_reward' 			 => $customer_reward,
        	'customer_transaction' 		 => $customer_transaction,
        	'download' 					 => $download,
        	'download_description' 		 => $download_description,
        	'event' 					 => $event,
        	'extension' 				 => $extension,
        	'filter' 					 => $filter,
        	'filter_description' 		 => $filter_description,
        	'filter_group' 			     => $filter_group,
        	'filter_group_description' 	 => $filter_group_description,
        	'geo_zone' 					 => $geo_zone,
        	'information' 				 => $information,
        	'information_description'    => $information_description,
        	'information_to_layout' 	 => $information_to_layout,
        	'information_to_store' 		 => $information_to_store,
        	'j_integrations' 			 => $j_integrations,
        	'jgroup_cgroup_map' 		 => $jgroup_cgroup_map,
        	'jgroup_ugroup_map' 		 => $jgroup_ugroup_map,
        	'juser_ocustomer_map' 		 => $juser_ocustomer_map,
        	'juser_ouser_map' 			 => $juser_ouser_map,
        	'language' 					 => $language,
        	'layout' 					 => $layout,
        	'layout_module' 			 => $layout_module,
        	'layout_route' 				 => $layout_route,
        	'length_class' 				 => $length_class,
        	'length_class_description' 	 => $length_class_description,
        	'location' 					 => $location,
        	'manufacturer' 				 => $manufacturer,
        	'manufacturer_to_store' 	 => $manufacturer_to_store,
        	'marketing'                  => $marketing,
        	'modification'               => $modification,
        	'module'                     => $module,
        	'option'                     => $option,
        	'option_description'         => $option_description,
        	'option_value'               => $option_value,
        	'option_value_description'   => $option_value_description,
        	'order'                      => $order,
        	'order_custom_field'         => $order_custom_field,
        	'order_fraud'                => $order_fraud,
        	'order_history' 			 => $order_history,
        	'order_option' 				 => $order_option,
        	'order_product' 			 => $order_product,
        	'order_status' 				 => $order_status,
        	'order_total' 				 => $order_total,
        	'order_voucher' 			 => $order_voucher,
        	'product' 					 => $product,
        	'product_attribute' 		 => $product_attribute,
        	'product_description' 		 => $product_description,
        	'product_discount' 			 => $product_discount,
        	'product_filter' 			 => $product_filter,
        	'product_image' 			 => $product_image,
        	'product_option' 			 => $product_option,
        	'product_option_value' 		 => $product_option_value,
        	'product_related' 			 => $product_related,
        	'product_reward' 			 => $product_reward,
        	'product_special' 			 => $product_special,
        	'product_to_category' 		 => $product_to_category,
        	'product_to_download' 		 => $product_to_download,
        	'product_to_layout' 		 => $product_to_layout,
        	'product_to_store' 			 => $product_to_store,
        	'recurring' 				 => $recurring,
        	'recurring_description' 	 => $recurring_description,
        	'return' 					 => $return,
        	'return_action' 			 => $return_action,
        	'return_history' 			 => $return_history,
        	'return_reason' 			 => $return_reason,
        	'return_status' 			 => $return_status,
        	'review' 					 => $review,
        	'stock_status' 				 => $stock_status,
        	'store' 					 => $store,
        	'tax_class'                  => $tax_class,
        	'tax_rate'                   => $tax_rate,
        	'tax_rate_to_customer_group' => $tax_rate_to_customer_group,
        	'tax_rule'                   => $tax_rule,
        	'upload'                     => $upload,
        	'url_alias'                  => $url_alias,
        	'user'                       => $user,
        	'user_group'                 => $user_group,
        	'voucher'                    => $voucher,
        	'voucher_history'            => $voucher_history,
        	'voucher_theme'              => $voucher_theme,
        	'voucher_theme_description'  => $voucher_theme_description,
        	'weight_class'               => $weight_class,
        	'weight_class_description'   => $weight_class_description,
        	'zone'                       => $zone,
        	'zone_to_geo_zone'           => $zone_to_geo_zone
        );

        if(isset($tables[$table])) {
            return $tables[$table];
        }
        else{
            return false;
        }
    }

    public function changeTaxRate($data)
    {

        $this->simulate = (!empty($data['simulate']) ? true : false);
        $this->showOps = (!empty($data['showOps']) ? true : false);
        $text = '';

        if (array_search('tax_class_id', $this->getDbColumns('tax_rate')) != false) {

            $sql = '
    		SELECT
    			*
    		FROM
    			`' . $this->prefix . 'tax_class` AS tc
    		LEFT JOIN
    			`' . $this->prefix . 'tax_rate` AS tr
    			ON(tc.tax_class_id = tr.tax_class_id)';

            $taxes = $this->db->query($sql);

            $sql = '
    		SELECT
    			*
    		FROM
    			`' . $this->prefix . 'tax_rate`
    		ORDER BY
    			`tax_rate_id` ASC';
            $rates = $this->db->query($sql);

            foreach ($taxes->rows as $tax) {
                $sql = '
    			SELECT
    				*
    			FROM
    				`' . $this->prefix . 'tax_rate`
    			WHERE
    				`tax_class_id` = \'' . $tax['tax_class_id'] . '\'';

                $result = $this->db->query($sql);

                if (!isset($result->row['tax_class_id'])) {
                    $sql = '
    				INSERT INTO
    					`' . $this->prefix . 'tax_rule`
    				SET
    					`tax_class_id` = \'' . $tax['tax_class_id'] . '\',
    					`tax_rate_id` = \'' . $tax['tax_rate_id'] . '\',
    					`based` = \'shipping\',
    					`priority` = \'' . $tax['priority'] . '\'';

                    $this->db->query($sql);

                }
            }

            foreach ($rates->rows as $rate) {
                $sql = '
    			SELECT
    				*
    			FROM
    				`' . $this->prefix . 'tax_rate_to_customer_group`
    			WHERE
    				`tax_rate_id` = \'' . $rate['tax_rate_id'] . '\'';

                if (array_search($this->prefix . 'tax_rate_to_customer_group', $this->getTables())) {
                    $result = $this->db->query($sql);

                    if (!isset($result->row['tax_rate_id'])) {
                        $sql = '
    				INSERT INTO
    					`' . $this->prefix . 'tax_rate_to_customer_group`
    				SET
    					`tax_rate_id` = \'' . $rate['tax_rate_id'] . '\',
    					`customer_group_id` = \'1\'';

                        $this->db->query($sql);
                    }
                }
            }

            /* Change Column 1:*/
            $sql = '
    		ALTER TABLE
    			`' . $this->prefix . 'tax_rate`
    		CHANGE
    			`description` `name` varchar(255) NOT NULL';

            if (array_search('description', $this->getDbColumns('tax_rate'))) {

                $this->db->query($sql);


            }
            $sql = '
    		UPDATE
    			`' . $this->prefix . 'tax_rate`
    		SET
    			`type` = \'P\'';

            if (array_search('type', $this->getDbColumns('tax_rate'))) {

                $this->db->query($sql);


            }
        }
        return $text;

    }

    public function getDbColumns($table)
    {
        global $link;

        if (array_search($this->prefix . $table, $this->getTables()) || $table == 'address') {
            $colums = $this->db->query("SHOW COLUMNS FROM `" . $this->prefix . $table . "`");

            $ret = array();

            foreach ($colums->rows as $field) {
                $ret[] = $field['Field'];
            }
            return $ret;
        }
    }

    private function getColumnKey($column, $table)
    {

        if (array_search($this->prefix . $table, $this->getTables()) || $table == 'address') {
            $fields = $this->db->query("SHOW COLUMNS FROM `" . $this->prefix . $table . "`");

            if (array_search($column, $this->getDbColumns($table))) {
                foreach ($fields->rows as $field) {
                    if ($field['Field'] == $column) {

                        return (!empty($field['Key']) ? true : false);

                    }
                }
            }
        }
    }

    private function getColumnType($column, $type, $table)
    {

        if (array_search($this->prefix . $table, $this->getTables()) || $table == 'address') {
            $fields = $this->db->query("SHOW COLUMNS FROM `" . $this->prefix . $table . "`");

            if (array_search($column, $this->getDbColumns($table))) {
                foreach ($fields->rows as $field) {
                    if ($field['Field'] == $column) {

                        return strpos($field['Type'], $type);

                    }
                }
            }
        }
    }

    public function getTables()
    {
        $query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

        $table_list = array();
        foreach ($query->rows as $table) {
            $table_list[] = $table['Tables_in_' . DB_DATABASE];
        }
        return $table_list;
    }

    public function fixEngineOfTableCustomerOnline()
    {
        $text = '';
        $schema = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die (mysql_error());
        $db_selected = mysql_select_db('information_schema', $schema);
        if (!$db_selected) {
            die ('Can\'t use foo : ' . mysql_error());
        }

        $sql = "
                SELECT * FROM
                             TABLES
                WHERE
                             TABLE_SCHEMA = '" . DB_DATABASE . "'
                AND
                             TABLE_NAME = '" . $this->prefix . "customer_online'
                AND
                             ENGINE ='innoDB'";
        $info = mysql_query($sql, $schema);


        if (!empty($info->row)) {

            $sql = '
                     ALTER TABLE
                               ' . $this->prefix . 'customer_online
                     ENGINE = \'MyISAM\'';

            $this->db->query($sql);

        }

        return $text;
    }

    public function hasLayout($val)
    {
        $sql = 'SELECT * FROM `' . $this->prefix . 'layout` WHERE `name` = \'' . $val . '\'';

        if (array_search($this->prefix . 'layout', $this->getTables())) {
            $result = $this->db->query($sql);

            if (count($result->row) == 0) {
                return false;
            }
        }
        else {
            return false;
        }
        return true;
    }

    public function hasSetting($val)
    {
        $sql = 'SELECT * FROM `' . $this->prefix . 'setting` WHERE `key` = \'' . $val . '\'';

        $result = $this->db->query($sql);

        if (count($result->row) == 0) {
            return false;
        }

        return true;
    }
}