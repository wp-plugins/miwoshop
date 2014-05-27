<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die ('Restricted access');

require_once(MPATH_WP_PLG .'/miwoshop/site/miwoshop/miwoshop.php');

class MiwoShopBase {

	private static $data = array();
	
	public function get($name, $default = null) {
        if (!is_array(self::$data) || !isset(self::$data[$name])) {
            return $default;
        }
        
        return self::$data[$name];
    }
    
    public function set($name, $value) {
        if (!is_array(self::$data)) {
            self::$data = array();
        }
        
        $previous = self::get($name);
		
        self::$data[$name] = $value;
        
        return $previous;
    }
	
	public function getMiwoshopVersion() {
        static $version;

        if (!isset($version)) {
            //$version = $this->getXmlText(MPATH_MIWOSHOP_ADMIN.'/miwoshop.xml', 'version');
            $version = $this->getXmlText(MPATH_WP_PLG .'/miwoshop/miwoshop.xml', 'version'); #miwo
        }

		return $version;
	}


	public function getLatestMiwoshopVersion() {
        static $version;

        if (!isset($version)) {
            $cache = MFactory::getCache('com_miwoshop', 'output');
            $cache->setCaching(1);

            $version = $cache->get('ms_version', 'com_miwoshop');

            if (empty($version)) {
                $version = MiwoShop::get('utility')->getRemoteVersion();
                $cache->store($version, 'ms_version', 'com_miwoshop');
            }
        }

		return $version;
	}

	public function getOcVersion() {
        $version = '1.5.5.1';

		return $version;
	}
	
	public function is15() {
		static $status;
		
		if (!isset($status)) {
			if (version_compare(MVERSION, '1.6.0', 'ge')) {
				$status = false;
			}
			else {
				$status = true;
			}
		}
		
		return $status;
	}

	public function is30() {
		static $status;

		if (!isset($status)) {
			if (version_compare(MVERSION, '3.0.0', 'ge')) {
				$status = true;
			}
			else {
				$status = false;
			}
		}

		return $status;
	}
	
	public function is32() {
		static $status;

		if (!isset($status)) {
			if (version_compare(MVERSION, '3.2.0', 'ge')) {
				$status = true;
			}
			else {
				$status = false;
			}
		}

		return $status;
	}

    public function is321() {
		static $status;

		if (!isset($status)) {
			if (version_compare(MVERSION, '3.2.1', 'ge')) {
				$status = true;
			}
			else {
				$status = false;
			}
		}

		return $status;
	}

	public function getConfig() {
		static $config;

		if (!isset($config)) {
			$settings = '';
			
            $db = MFactory::getDbo();
			$tables	= $db->getTableList();
			$miwoshop_setting = $db->getPrefix().'miwoshop_setting';
			if (in_array($miwoshop_setting, $tables)) {
				$db->setQuery("SELECT `value` FROM `#__miwoshop_setting` WHERE `key` = 'config_miwoshop'");
				$settings = unserialize($db->loadResult());
            }
			
			$config = new MRegistry($settings);
		}
		
		return $config;
	}

	public function setConfig($var, $value) {
		$config = $this->getConfig();
		
		$config->set($var, $value);
		
		$settings = serialize($config->toArray());
		
		MiwoShop::get('db')->run("UPDATE `#__miwoshop_setting` SET `value` = '{$settings}' WHERE `key` = 'config_miwoshop'", 'query');
	}

	public function getMConfig() {
		static $config;

		if (!isset($config)) {
			require_once(MPATH_CONFIGURATION.'/config.php');

			$config = new MConfig();
		}

		return $config;
	}
	
	public function editor() {
		static $editor;
		
		if (!isset($editor)) {
            if ($this->is30()) {
                mimport('cms.editor.editor');

                $j_editor = MFactory::getConfig()->get('editor');
                $editor = MEditor::getInstance($j_editor);
            }
            else {
                $editor = MFactory::getEditor();
            }
		}
		
		return $editor;
	}

	public function getFullUrl($path_only = false, $host_only = false) {
        if (MFactory::isJ() and MFactory::getApplication()->isSite()) { #miwo
            $url = '';
			
			$live_site = $this->getMConfig()->live_site;
			
			if (trim($live_site) != '') {
				$uri = MURI::getInstance($live_site);
				
				if ($host_only == false) {
					$url = rtrim($uri->toString(array('path')), '/\\');
				}
				
				if ($path_only == false) {
					$url = $uri->toString(array('scheme', 'host', 'port')) . $url;
				}
			}
			else {
				if ($host_only == false) {
					if (strpos(php_sapi_name(), 'cgi') !== false && !ini_get('cgi.fix_pathinfo') && !empty($_SERVER['REQUEST_URI'])) {
						$script_name = $_SERVER['PHP_SELF'];
					}
					else {
						$script_name = $_SERVER['SCRIPT_NAME'];
					}
					
					$url = rtrim(dirname($script_name), '/.\\');
				}
				
				if ($path_only == false) {
					$port = 'http://';
					if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
						$port = 'https://';
					}
				
					$url = $port . $_SERVER['HTTP_HOST'] . $url;
				}
			}
		}
		else {
			$url = MURI::root($path_only);
		}


        if (substr($url, -1) != '/') {
            $url .= '/';
        }

        if(defined('DOING_AJAX')){ #miwo
            $url = str_replace('wp-content/miwi/', '', $url);
        }
		
		return $url;
	}

	public function getDomain() {
		static $domain;
		
		if (!isset($domain)) {
            $domain = $this->getFullUrl(false, true);
		}
		
		return $domain;
	}

	public function getSubdomain() {
		static $sub_domain;
		
		if (!isset($sub_domain)) {
            $sub_domain = $this->getFullUrl(true);
		}
		
		return $sub_domain;
	}
	
	public function getXmlText($file, $variable) {
        mimport('framework.filesystem.file');
        
		$value = '';
		
		if (MFile::exists($file)) {
            $xml = simplexml_load_file($file, 'SimpleXMLElement');

            if (is_null($xml) || !($xml instanceof SimpleXMLElement)) {
                return $value;
            }

            $value = $xml->$variable;
		}
		
		return $value;
    }

    public function trigger($function, $args = array(), $folder = 'miwoshop') {
        mimport('framework.plugin.helper');

        MPluginHelper::importPlugin($folder);
        $dispatcher = MDispatcher::getInstance();
        $result = $dispatcher->trigger($function, $args);

        return $result;
    }

    public function triggerContentPlg($text) {
        $config = $this->getConfig();

        if ($config->get('trigger_content_plg', 0) == 0) {
            return $text;
        }

        $item = new stdClass();
        $item->id = null;
        $item->rating = null;
        $item->rating_count = null;
        $item->text = $text;

        $params = $config;
        $limitstart = MRequest::getInt('limitstart');

        $this->trigger('onContentPrepare', array('com_miwoshop.product', &$item, &$params, $limitstart), 'content');

        return $item->text;
    }


    public function loadPathway($route) {
        $view = MRequest::getWord('view');
        if (!empty($view) and !MiwoShop::get('base')->is30()) {
            return;
        }

        if (empty($route)) {
             $route = MRequest::getString('route');
        }

        if (empty($route)) {
            return;
        }

        $mainframe = MFactory::getApplication(0);

        $a_menu = $mainframe->getMenu()->getActive();
        $pathway = $mainframe->getPathway();
        $pathway_names = $pathway->getPathwayNames();

        switch($route) {
            case 'product/product':
                $c_id = MRequest::getCmd('path');
                $p_id = MRequest::getInt('product_id');

                if (is_object($a_menu) and ($a_menu->query['view'] == 'category')  and isset($a_menu->query['path']) and (empty($c_id) or $c_id == $a_menu->query['path'])){
                    $pathway->addItem(MiwoShop::get('db')->getRecordName($p_id));
                    break;
                }

                if (is_object($a_menu) and ($a_menu->query['view'] == 'product') and ($a_menu->query['product_id'] == $p_id)){
                    break;
                }

                if (strpos($c_id, '_')) {
                    $c_id = end(explode('_', $c_id));
                }

                if (empty($c_id)) {
                    $c_id = MiwoShop::get('db')->getProductCategoryId($p_id);
                }

                $cats = MiwoShop::get('db')->getCategoryNames($c_id);
                if (!empty($cats)) {
                    foreach ($cats as $cat) {
                        if (is_object($a_menu) and ($a_menu->query['view'] == 'category') and ($a_menu->query['path'] == $cat->id)){
                            continue;
                        }

                        if (in_array($cat->name, $pathway_names)){
                            continue;
                        }

                        $pathway->addItem($cat->name, MiwoShop::get('router')->route('index.php?route=product/category&path='.$cat->id));
                    }
                }

                $pathway->addItem(MiwoShop::get('db')->getRecordName($p_id));

                break;
            case 'product/category':
                $c_id = MRequest::getCmd('path');
                if (empty($c_id)) {
                    break;
                }

                if (strpos($c_id, '_')) {
                    $c_id = end(explode('_', $c_id));
                }

                if (is_object($a_menu) and ($a_menu->query['view'] == 'category') and ($a_menu->query['path'] == $c_id)){
                    break;
                }

                $cats = MiwoShop::get('db')->getCategoryNames($c_id);

                if (!empty($cats)) {
                    foreach ($cats as $cat) {
                        if (is_object($a_menu) and ($a_menu->query['view'] == 'category') and ($a_menu->query['path'] == $cat->id)){
                            continue;
                        }

                        if (in_array($cat->name, $pathway_names)){
                            continue;
                        }

                        if ($cat->id == $c_id) {
                            $pathway->addItem($cat->name);
                        }
                        else {
                            $pathway->addItem($cat->name, MiwoShop::get('router')->route('index.php?route=product/category&path='.$cat->id));
                        }
                    }
                }

                break;
            case 'product/manufacturer':
                $pathway->addItem(MText::_('COM_MIWOSHOP_PRODUCT_MANUFACTURER_TEXT_BRAND'));

                break;
            case 'product/manufacturer/info':
                $m_id = MRequest::getInt('manufacturer_id');
                if (empty($m_id)) {
                    break;
                }

                if (is_object($a_menu) and ($a_menu->query['view'] == 'manufacturer') and ($a_menu->query['manufacturer_id'] == $m_id)){
                    break;
                }

                $pathway->addItem(MText::_('COM_MIWOSHOP_PRODUCT_MANUFACTURER_TEXT_BRAND'), MiwoShop::get('router')->route('index.php?route=product/manufacturer'));
                $pathway->addItem(MiwoShop::get('db')->getRecordName($m_id, 'manufacturer'));

                break;
            case 'information/information':
                $i_id = MRequest::getInt('information_id');
                if (empty($i_id)) {
                    break;
                }

                if (is_object($a_menu) and $a_menu->query['view'] == 'information' and $a_menu->query['information_id'] == $i_id){
                    break;
                }

                $pathway->addItem(MiwoShop::get('db')->getRecordName($i_id, 'information'));

                break;
            default:
                if ($route == 'common/home') {
                    break;
                }

                if (is_object($a_menu) and $a_menu->query['view'] == 'cart') {
                    break;
                }

                MiwoShop::get('opencart')->get('language')->load($route);

                $pathway->addItem(MiwoShop::get('opencart')->get('language')->get('heading_title'));

                break;
        }
    }
	
	public function addHeader($path, $css = true, $only_ie = false) {
		static $headers = array();
		
		if (isset($headers[$path])) {
			return;
		}
		
		mimport('framework.environment.browser');
		$browser = MBrowser::getInstance();

		if (($only_ie == true) or strpos($path, 'ie6.css') or strpos($path, 'ie7.css') or strpos($path, 'ie8.css')) {
            if ($browser->getBrowser() != 'msie') {
                return;
            }

            if (strpos($path, 'ie6.css') and ($browser->getMajor() != '6')) {
                return;
            }

            if (strpos($path, 'ie7.css') and ($browser->getMajor() != '7')) {
                return;
            }

            if (strpos($path, 'ie8.css') and ($browser->getMajor() != '8')) {
                return;
            }
		}
		
		global $vqmod;
		
		if (!is_object($vqmod)) {
			require_once(MPATH_MIWOSHOP_OC.'/vqmod/vqmod.php');
			$vqmod = new VQMod();
		}
		
		$doc = MFactory::getDocument();
		
		$f = 'addStylesheet';
		if ($css == false) {
			$f = 'addScript';
		}
		
		$doc->$f(self::clearPath($vqmod->modCheck($path)));
		
		$headers[$path] = 'added';
	}
	
	public function clearPath($path) {
        $abspath = str_replace('\\', '/', ABSPATH);
        $path = str_replace('\\', '/', $path);
    
        $clear_path = str_replace($abspath, '/', $path);

		$clear_path = str_replace('/\\', '/', $clear_path);
		$clear_path = str_replace('\\', '/', $clear_path);
		$clear_path = str_replace('//', '/', $clear_path);
		$clear_path = str_replace('com_miwoshop/opencartadmin', 'com_miwoshop/opencart/admin', $clear_path);
		$clear_path = str_replace('com_miwoshop/opencartcatalog', 'com_miwoshop/opencart/catalog', $clear_path);

		return $clear_path;
	}

    public function buildIndentTree($id, $indent, $list, &$children) {
        if (@$children[$id]) {
            foreach ($children[$id] as $ch) {
                $id = $ch->id;

                $pre 	= '|_&nbsp;';
                $spacer = '.&nbsp;&nbsp;&nbsp;';

                if ($ch->parent == 0) {
                    $txt = $ch->name;
                } else {
                    $txt = $pre . $ch->name;
                }

                $list[$id] = $ch;
                $list[$id]->name = "$indent$txt";
                $list[$id]->children = count(@$children[$id]);
                $list = self::buildIndentTree($id, $indent . $spacer, $list, $children);
            }
        }

        return $list;
    }

    public function getStoreId() {
        static $store_id;

   		if (!isset($store_id)) {
   			$db = MiwoShop::get('db')->getDbo();

   			if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
   				$field = 'ssl';
   			}
   			else {
   				$field = 'url';
   			}

   			$db->setQuery("SELECT store_id FROM #__miwoshop_store WHERE REPLACE(`{$field}`, 'www.', '') = ".$db->Quote(str_replace('www.', '', $this->getFullUrl())));
            $store_id = $db->loadResult();

   			if (empty($store_id)) {
                $store_id = 0;
   			}
   		}

   		return $store_id;
   	}

    public function plgEnabled($folder, $name) {
        static $status = array();

        if (!isset($status[$folder][$name])) {
            mimport('framework.plugin.helper');
            $status[$folder][$name] = MPluginHelper::isEnabled($folder, $name);
        }

        return $status[$folder][$name];
    }

    public function isAdmin($type = 'miwoshop') {
        static $is_admin = array();

        if (!isset($is_admin[$type])) {
            $mainframe = MFactory::getApplication();

            if ($type == 'miwoshop') {
                $state = false;

                if ($mainframe->isSite()) {
                    $state = (MRequest::getCmd('view') == 'admin');

                    if (!$state) {
                        $home_menu_id = MiwoShop::get('router')->getItemid('home', 0);
                        $admin_menu_id = MiwoShop::get('router')->getItemid('admin', 0);

                        if (($admin_menu_id != $home_menu_id) and (MRequest::getInt('Itemid') == $admin_menu_id)) {
                            $state = true;
                        }
                    }
                }
            }
            else {
                $state = $mainframe->isAdmin();
            }

            if ($state) {
                $is_admin[$type] = true;
            }
            else {
                $is_admin[$type] = false;
            }
        }

        return $is_admin[$type];
   	}

    public function isExternal() {
        static $is_external;

        if (!isset($is_external)) {
            $is_external = false;

            $view = MRequest::getString('view');

            if (substr($view, 0, 7) == 'install' or substr($view, 0, 8) == 'external') {
                $is_external = true;
            }
        }

        return $is_external;
   	}

    public function isAjax($output = '') {
        $is_ajax = false;
        $app = MFactory::getApplication();

        $tmpl = MRequest::getWord('tmpl');
        $format = MRequest::getWord('format');

        if ($app->isSite() and MiwoShop::get('base')->is30()) {
            $ret = false;
            $j_config = MiwoShop::get('base')->getMConfig();

            if ($j_config->sef == '0') {
                $route = MFactory::getURI()->getVar('route');

                if (($route == 'account/register') or ($route == 'affiliate/register')) {
                    $ret = true;
                }
            }
            else {
                $path = MFactory::getURI()->toString(array('path'));

                if ($j_config->sef_suffix == '0') {
                    if ((substr($path, -16) == 'account/register') or (substr($path, -18) == 'affiliate/register')) {
                        $ret = true;
                    }
                }
                else {
                    if ((substr($path, -21) == 'account/register.html') or (substr($path, -23) == 'affiliate/register.html')) {
                        $ret = true;
                    }
                }

                if ($ret === false) {
                    $active = $app->getMenu()->getActive();

                    if (is_object($active) and ($active->id == MiwoShop::get('router')->getItemid('registration'))) {
                        $ret = true;
                    }
                }
            }

            if ($ret === true) {
                unset($_GET['format']);
                unset($_GET['tmpl']);
                unset($_REQUEST['format']);
                unset($_REQUEST['tmpl']);

                return false;
            }
        }

        if (($tmpl == 'component') or ($format == 'raw')) {
            $is_ajax = true;
        }
        else if (!empty($output)) {
			if ($this->isJson($output)) {
				$is_ajax = true;

				MRequest::setVar('format', 'raw');
				MRequest::setVar('tmpl', 'component');
			}
        }

        return $is_ajax;
    }

    public function isJson($string) {
		$status = false;
		
		if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
			$a = json_decode($string, false, 1);
			if(json_last_error() == JSON_ERROR_NONE && !is_null($a)) {
				$status = true;
			}
		}
		else {
			if (substr($string, 0, 11) == '{"success":' or
					substr($string, 0, 12) == '{"redirect":' or
					substr($string, 0, 9) == '{"error":' or
					substr($string, 0, 11) == '{"warning":' or
					substr($string, 0, 15) == '{"information":' or
					substr($string, 0, 13) == '{"attention":') {

					$status = true;
				}
		}
		
		return $status;
    }

    public function isMiwosefInstalled() {
        static $status;

        if (!isset($status)) {
            $status = true;

            if (MiwoShop::get('base')->getConfig()->get('miwosef_integration', 1) == 0) {
                $status = false;

                return $status;
            }

            $file = MPATH_WP_PLG.'/miwosef/admin/library/miwosef.php';
            if (!file_exists($file)) {
                $status = false;

                return $status;
            }

            require_once($file);

            if (Miwosef::getConfig()->mode == 0) {
                $status = false;
            }
        }

        return $status;
    }
	
	public function isMiwoEventInstalled() {
        static $status;

        if (!isset($status)) {
            $file = MPATH_WP_PLG.'/miwoevents/admin/library/miwoevents.php';
            if (!file_exists($file)) {
                $status = false;

                return $status;
            }

            require_once($file);

            if(MComponentHelper::isEnabled('com_miwoevents')){
                $status = true;
            }
        }

        return $status;
    }

    public function checkIsEvent($product_id){
        $isIns = MiwoShop::get('base')->isMiwoEventInstalled();
        $result = false;

        if($isIns) {
            $query = "SELECT id FROM #__miwoevents_events WHERE product_id = ". $product_id." LIMIT 1" ;
            $db = MFactory::getDbo();
            $db->setQuery($query);
            $event_id = $db->loadResult();

            if($event_id){
                $result = $event_id;
            }
        }

        return $result;
    }

    public function isSh404sefInstalled() {
        static $status;

        if (!isset($status)) {
            $status = true;

            $file = ABSPATH.'/components/com_sh404sef/sh404sef.class.php';
            if (!file_exists($file)) {
                $status = false;

                return $status;
            }

            require_once($file);

            if (Sh404sefFactory::getConfig()->Enabled == 0) {
                $status = false;
            }
        }

        return $status;
    }

    public function isJoomsefInstalled() {
        static $status;

        if (!isset($status)) {
            $status = true;

            $file = ABSPATH.'/components/com_sef/classes/config.php';
            if (!file_exists($file)) {
                $status = false;

                return $status;
            }

            require_once($file);

            if (!SEFConfig::getConfig()->enabled) {
                $status = false;
            }
        }

        return $status;
    }
	
    public function isAcymaillingInstalled() {
        static $status;

        if (!isset($status)) {
            $status = true;

            $file = ABSPATH.'/components/com_acymailing/acymailing.php';
            if (!file_exists($file)) {
                $status = false;

                return $status;
            }

            if ( MComponentHelper::isEnabled('com_acymailing') == 0 ) {
                $status = false;
            }
        }

        return $status;
    }

    public function getMailList($id = null) {
        $where = '';
        if(!empty($id)){
            $where = 'WHERE listid = {$id}';
        }

        return MiwoShop::get('db')->run('SELECT listid, name FROM #__acymailing_list '.$where, 'loadAssocList');
    }

    public function getMailListHtml($name, $value) {
        $list = $this->getMailList();

        if(!empty($list)){
            $html = '<select name="'.$name.'" >';

            foreach($list as $item){
                $selected = '';
                if($item['listid'] == $value){
                    $selected = 'selected="selected"';
                }

                $html .= '<option '.$selected.' value="'.$item['listid'].'">'.$item['name'].'</option>';
            }
            $html .= '</select>';
        }

        return $html;
    }

    public function isActiveSubMenu($src, $is_route = true) {
        $state = false;
        $view = MRequest::getString('view');
        $route = MRequest::getString('route');

        if ($is_route == true) {
            switch ($src) {
                case 'dashboard':
                    if ((empty($route) && empty($view)) or ($route == 'common/home')) {
                        $state = true;
                    }
                    break;
                case 'settings':
                    if (substr($route, 0, 8) == 'setting/') {
                        $state = true;
                    }
                    break;
                case 'categories':
                    if (substr($route, 0, 16) == 'catalog/category') {
                        $state = true;
                    }
                    break;
                case 'products':
                    if (substr($route, 0, 15) == 'catalog/product') {
                        $state = true;
                    }
                    break;
                case 'coupons':
                    if (substr($route, 0, 11) == 'sale/coupon') {
                        $state = true;
                    }
                    break;
                case 'customers':
                    if (substr($route, 0, 13) == 'sale/customer') {
                        $state = true;
                    }
                    break;
                case 'orders':
                    if (substr($route, 0, 10) == 'sale/order') {
                        $state = true;
                    }
                    break;
                case 'affiliates':
                    if (substr($route, 0, 14) == 'sale/affiliate') {
                        $state = true;
                    }
                    break;
                case 'mailing':
                    if (substr($route, 0, 12) == 'sale/contact') {
                        $state = true;
                    }
                    break;
            }
        }
        else {
            $state = ($view == $src);
        }

        return $state;
    }

    public function checkRequirements($src) {
        $base = MiwoShop::get('base');

        if (($src == 'admin' || $src == 'admin2') && !MFactory::getUser()->authorise('core.manage', 'com_miwoshop')) {
        	MError::raiseWarning(404, MText::_('MERROR_ALERTNOAUTHOR'));
            return false;
        }

        





        if (!file_exists(MPATH_WP_PLG.'/miwoshop/site/opencart/index.php')) {
            MError::raiseWarning(404, MText::_('COM_MIWOSHOP_MISSING_LIBRARY'));
            return false;
        }

        if ($base->plgEnabled('system', 'legacy')) {
            MError::raiseWarning(404, MText::_('COM_MIWOSHOP_LEGACY_PLUGIN'));
            return false;
        }

        if (!function_exists('mcrypt_create_iv')) {
            MError::raiseWarning(404, MText::_('COM_MIWOSHOP_NO_MCRYPT'));
            return false;
        }

        if (!is_writable(MPATH_MIWOSHOP_OC.'/vqmod/vqcache')) {
            MError::raiseWarning(404, MText::_('COM_MIWOSHOP_VQCACHE_NOT_WRITABLE'));
            return false;
        }

        return true;
    }

    public function replaceOutput($output, $source) {
		if(MRequest::getString('route') == 'tool/themeeditor/edit'){
            return $output;
        }

		$http_catalog="/";
        $constants = get_defined_constants();
		if(isset($constants['HTTP_CATALOG'])){
			$http_catalog = $constants['HTTP_CATALOG'];
		}

        $replace_output = array(
            '$.' 					=> 'jQuery.',
            '$(' 					=> 'jQuery(',
            '<div id="container">' 	=> '<div id="container_oc">',
            '"header"' 				=> '"header_oc"',
            '"content"' 			=> '"content_oc"',
            'class="button"' 		=> 'class="button_oc"',
            'id="button"' 			=> 'id="button_oc"',
            '"search"' 				=> '"search_oc"',
            'class="button-search"' => 'class="button_oc-search"',
            '"menu"' 				=> '"menu_oc"',
            '"banner"' 				=> '"banner_oc"',
            '"footer"' 				=> '"footer_oc"',
            '#header' 				=> '#header_oc',
            '#content' 				=> '#content_oc',
            '.button '				=> '.button_oc ',
            '.button:'				=> '.button_oc:',
            '#content'				=> '#content_oc',
            '#container' 			=> '#container_oc',
            '#menu' 				=> '#menu_oc'
        );
    
        if ($source == 'admin' || $source == 'admin2' || $source == 'site' || $source == 'module') {
            $replace_output["index.php?option=com_miwoshop&route=catalog/product/autocomplete"] 	= MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=catalog/product/autocomplete";
            $replace_output["index.php?route=catalog/product/autocomplete"] 						= MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=catalog/product/autocomplete";
            $replace_output["jQuery.post('index.php?route="] 										= "jQuery.post('".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
            $replace_output["jQuery.post('index.php?option=com_miwoshop&route="] 					= "jQuery.post('".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
        }
    
        if ($source == 'admin') {
            $replace_output['admin.php?page=miwoshop&option=com_miwoshop&route=sale/order/invoice&'] 				= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=sale/order/invoice&';
            $replace_output['admin.php?page=miwoshop&amp;option=com_miwoshop&amp;route=sale/order/invoice'] 		= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=sale/order/invoice';
            $replace_output['admin.php?page=miwoshop&option=com_miwoshop&route=tool/backup/backup&'] 			    = MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=tool/backup/backup&';
            $replace_output['admin.php?page=miwoshop&amp;option=com_miwoshop&amp;route=tool/backup/backup'] 	    = MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=tool/backup/backup';
            $replace_output['<link rel="stylesheet" type="text/css" href="index.php?option=com_miwoshop&'] 			= '<link rel="stylesheet" type="text/css" href="'.MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&';
        }
    
        if ($source == 'admin2') {
            $replace_output['index.php?route=common/filemanager'] 													= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component&route=common/filemanager';
            $replace_output['index.php?option=com_miwoshop&format=raw&tmpl=component&route=common/filemanager'] 	= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component&route=common/filemanager';
            $replace_output['index.php?option=com_miwoshop&tmpl=component&format=raw&route=common/filemanager'] 	= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component&route=common/filemanager';
            $replace_output["load('index.php?option=com_miwoshop&"]													= "load('".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&view=admin&";
            $replace_output["load('index.php?route="] 																= "load('".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&view=admin&route=";
            $replace_output[": 'index.php?option=com_miwoshop"] 													= ": '".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component";
            $replace_output['index.php?option=com_miwoshop&route=sale/order/invoice&'] 								= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component&route=sale/order/invoice&';
            $replace_output['index.php?option=com_miwoshop&route=tool/backup/backup&'] 								= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component&route=tool/backup/backup&';
            $replace_output['<select name="filter_category" style="width: 18em;" >'] 								= '<select name="filter_category" style="width: 120px;" >';
            $replace_output['<link rel="stylesheet" type="text/css" href="index.php?option=com_miwoshop&'] 			= '<link rel="stylesheet" type="text/css" href="'.MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&view=admin&format=raw&tmpl=component&';
            $replace_output['<input type="text" name="filter_model" value="" />'] 									= '<input type="text" name="filter_model" value="" style="width: 60px;" />';
            $replace_output['<input type="text" name="filter_price" value="" size="8"/>'] 							= '<input type="text" name="filter_price" value="" size="8" style="width: 50px;" />';
            $replace_output['<input type="text" name="filter_quantity" value="" style="text-align: right;" />'] 	= '<input type="text" name="filter_quantity" value="" style="text-align: right; width: 40px;" />';
        }
    
        if ($source == 'admin' || $source == 'admin2') {
            $replace_output['index.php?token=']            							= 'index.php?option=com_miwoshop&token=';
            $replace_output['view/javascript/jquery/']          					= MURL_WP_CNT.'/miwi/plugins/plg_miwoshop_js/js/';
			$replace_output['admin/view']               							= MURL_MIWOSHOP . '/site/opencart/admin/view';
			$replace_output['src="view/']               							= 'src="'.MURL_MIWOSHOP . '/site/opencart/admin/view/';
            $replace_output["HTTP_SERVER . 'admin/"]          						= "HTTP_SERVER . '".MID_PATH."miwoshop/site/opencart/admin/";
            $replace_output['index.php?option=com_miwoshop&route=checkout/manual']	= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=checkout/manual';
            $replace_output['src="index.php?option=com_miwoshop&format=raw']      	= 'src="'.MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw';
			$replace_output["url = 'index.php?route"]      							= "url = '".MURL_ADMIN."/admin.php?page=miwoshop&option=com_miwoshop&route";
        }
    
        if ($source == 'admin' || $source == 'site' || $source == 'module') {
            $replace_output['index.php?option=com_miwoshop&route=common/filemanager'] 	= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=common/filemanager';
            $replace_output['index.php?route=common/filemanager'] 						= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=common/filemanager';
            $replace_output[".load('index.php?option=com_miwoshop&route="] 				= ".load('".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
            $replace_output[".load('index.php?route="] 									= ".load('".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
            $replace_output[": 'index.php?option=com_miwoshop&route="] 					= ": '".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
            $replace_output[': "index.php?option=com_miwoshop&route='] 					= ': "'.MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=';
            $replace_output[": 'index.php?route="] 										= ": '".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=";
            $replace_output[': "index.php?route='] 										= ': "'.MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=';
            $replace_output[": 'index.php?option=com_miwoshop&format=raw"] 				= ": '".MURL_ADMIN."/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw";
            $replace_output[': "index.php?option=com_miwoshop&format=raw'] 				= ': "'.MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw';
        }
    
        if ($source == 'admin2' || $source == 'site' || $source == 'module') {
            $replace_output["HTTP_SERVER . 'catalog/"] = "HTTP_SERVER . '".MID_PATH."miwoshop/site/opencart/catalog/";
        }
    
        if ($source == 'site' || $source == 'module') {
            $replace_output['class="box"'] 												= 'class="box_oc"';
            $replace_output['class="button_oc"'] 										= 'class="'.MiwoShop::getButton().'"';
            $replace_output['class="button"'] 											= 'class="'.MiwoShop::getButton().'"';
            $replace_output['id="button"'] 												= 'class="'.MiwoShop::getButton().'"';
            $replace_output[' src="catalog/'] 											= ' src="'.MURL_MIWOSHOP.'/site/opencart/catalog/';
            $replace_output[' src="image/'] 											= ' src="'.MURL_MIWOSHOP.'/site/opencart/image/';
            $replace_output['index.php?route=product/product/captcha'] 					= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=product/product/captcha';
            $replace_output['index.php?route=information/contact/captcha'] 				= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=information/contact/captcha';
            $replace_output['index.php?route=account/return/captcha'] 					= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=account/return/captcha';
            $replace_output['index.php?route='] 										= 'index.php?option=com_miwoshop'.MiwoShop::get('router')->getItemid('home', 0, true).'&route=';
            $replace_output['index.php?token=']											= 'index.php?option=com_miwoshop'.MiwoShop::get('router')->getItemid('home', 0, true).'&token=';
            $replace_output['index.php?option=com_miwoshop&route=facebook_store'] 		= MURL_ADMIN.'/admin-ajax.php?action=miwoshop&option=com_miwoshop&format=raw&tmpl=component&route=facebook_store';
        }
    
        if ($source == 'module') {
            $replace_output['class="box-content"'] 				= '';
            $replace_output['<div class="bottom">&nbsp;</div>'] = '';
            $replace_output['class="box_oc"'] 					= 'class="box_oc" style="margin-bottom: 0px !important;"';
        }
        
        $replace_output['"breadcrumb"'] = '"breadcrumb_oc"';
        
        #miwo
        $replace_output['focus: function(event, ui) {'] = 'focus: function(event, ui) {';
        $replace_output['$jQuery']                      = '$$';
        $replace_output['.catcomplete({']               = '.autocomplete({';

        if ($source == 'admin' || $source == 'admin2') {
		    $replace_output[MURL_ADMIN.'/admin-ajax.php?action=miwoshop&'] = MURL_ADMIN.'/admin-ajax.php?action=miwoshop&client=admin&';
            $replace_output['index.php?option=com_miwoshop&route='] = 'admin.php?page=miwoshop&option=com_miwoshop&route=';
        }

        foreach($replace_output as $key => $value) {
        	$output = str_replace($key, $value, $output);
        }

        return $output;
    }
    public function getIntegrations($product_id) {
        $integrations = '';
        $db = MiwoShop::get('db')->getDbo();
        $db->setQuery("SELECT content FROM #__miwoshop_j_integrations p  WHERE p.product_id = '" . (int)$product_id . "'");
        $result = $db->loadResult();
        if(!empty($result)){
            $integrations = json_decode(html_entity_decode($result));
        }
        return $integrations;
    }
	
	public function getIntegrationViews($integrations){
        $html = '';

        mimport('framework.plugin.helper');
        MPluginHelper::importPlugin('miwoshop');
        $dispatcher = MDispatcher::getInstance();
        $result = $dispatcher->trigger('getViewHtml',  array($integrations));

        if(!empty($result)) {
            $html = implode('',$result);
        }

        return $html;
    }
	
}