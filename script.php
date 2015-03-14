<?php
/**
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('MIWI') or die('Restricted access');

// Import Libraries
mimport('framework.application.helper');
mimport('framework.filesystem.file');
mimport('framework.filesystem.archive');
mimport('framework.installer.installer');

class com_MiwoshopInstallerScript {

    private $_current_version = null;
    private $_is_new_installation = true;

    public function preflight($type, $parent) {
		
		$this->upgrade30();
	
        if($type == 'upgrade') {
            $old = dirname(__FILE__);
            $upg = MPATH_WP_CNT . '/upgrade';
            $tmp = $upg.'/miwitmp';
            $new = $upg.'/miwoshop.tmp/miwoshop';

            if(MFolder::exists(MPath::clean($tmp))) {
                MFolder::delete(MPath::clean($tmp));
            }

            # copy old files to tmp
            MFolder::copy(MPath::clean($old), MPath::clean($tmp));

            # combine old and new filed in tmp
            MFolder::copy(MPath::clean($new), MPath::clean($tmp));

            # copy tpm files to new
            MFolder::copy(MPath::clean($tmp), MPath::clean($new));

            #delete tmp
            MFolder::delete(MPath::clean($tmp));
        }

        $db = MFactory::getDBO();
        $db->setQuery('SELECT option_value FROM #__options WHERE option_name = "miwoshop"');
        $config = $db->loadResult();

        if (!empty($config)) {
            $this->_is_new_installation = false;

            $miwoshop_xml = MPATH_WP_PLG . '/miwoshop/site/miwoshop/miwoshop.xml';

            if (MFile::exists($miwoshop_xml)) {
                $xml = simplexml_load_file($miwoshop_xml, 'SimpleXMLElement');
                $this->_current_version = (string)$xml->version;
            }
        }
    }
	
	public function postflight($type, $parent) {
        $src = MPATH_WP_PLG . '/miwoshop/site';
		
        require_once($src . '/miwoshop/miwoshop.php');
			
		if (MFolder::exists(MPath::clean(MPATH_WP_PLG.'/miwoshop/languages'))) {
			MFolder::copy(MPath::clean(MPATH_WP_PLG.'/miwoshop/languages'), MPath::clean(MPATH_MIWI.'/languages'), null, true);
			MFolder::delete(MPath::clean(MPATH_WP_PLG.'/miwoshop/languages'));
		}
		if (MFolder::exists(MPath::clean(MPATH_WP_PLG.'/miwoshop/modules'))) {
			MFolder::copy(MPath::clean(MPATH_WP_PLG.'/miwoshop/modules'), MPath::clean(MPATH_MIWI.'/modules'), null, true);
			MFolder::delete(MPath::clean(MPATH_WP_PLG.'/miwoshop/modules'));
		}
		if (MFolder::exists(MPath::clean(MPATH_WP_PLG.'/miwoshop/plugins'))) {
			MFolder::copy(MPath::clean(MPATH_WP_PLG.'/miwoshop/plugins'), MPath::clean(MPATH_MIWI.'/plugins'), null, true);
			MFolder::delete(MPath::clean(MPATH_WP_PLG.'/miwoshop/plugins'));
		}

		#todo delete this part next version
		if ($type == 'upgrade') {
			return;
		}
		##################################
		##################################

        if ($this->_is_new_installation) {
            $this->_installMiwoshop();
        }
        else {
            $this->_updateMiwoshop();
        }
	}

    protected function _installMiwoshop() {
		/***********************************************************************************************
		* ---------------------------------------------------------------------------------------------
		* DATABASE INSTALLATION SECTION
		* ---------------------------------------------------------------------------------------------
		***********************************************************************************************/
        $config = new stdClass();

        $config->pid = '';
        $config->enable_vqmod_cache = '1';
        $config->show_header = '1';
        $config->show_footer = '1';
        $config->show_cats_menu = '0';
        $config->trigger_content_plg = '0';
        $config->fix_ie_cache = '0';
        $config->miwoshop_display = '0';
        $config->button_class = 'button_oc';
        $config->comments = '0';
        $config->mijosef_integration = '0';
        $config->account_sync_done = '0';
        $config->alias_sync_done = '1';

        $reg = new MRegistry($config);
        $config = $reg->toString();

		$db = MFactory::getDbo();
        $db->setQuery('INSERT INTO `#__options` (option_name, option_value) VALUES ("miwoshop", '.$db->Quote($config).')');
        $db->query();

        $settings = serialize($reg->toArray());
        $db->setQuery("INSERT INTO `#__miwoshop_setting` SET store_id = 0, `code` = 'config', `key` = 'config_miwoshop', `value` = ".$db->Quote($settings).", `serialized` = 1");
        $db->query();

		MiwoShop::get('install')->createTables();
		MiwoShop::get('install')->createUserTables();
		MiwoShop::get('install')->createApiUser();
		MiwoShop::get('install')->createGroupTables();
        MiwoShop::get('install')->createIntegrationTables();
		MiwoShop::get('install')->addPage();

        if (empty($this->_current_version)) {
            return;
        }

        if ($this->_current_version = '1.0.0') {
            return;
        }		
    }

    protected function _updateMiwoshop() {
        if (empty($this->_current_version)) {
            return;
        }

		if (version_compare($this->_current_version, '3.0.0') == -1) {
            MiwoShop::get('install')->upgrade300();
        }
    }

    public function uninstall($parent) {
		$db  = MFactory::getDBO();
		$src = __FILE__;
	}
	
# Removes MiwoShop25 Missing File.
	public function upgrade30(){
		$miwoshop = MPATH_WP_PLG . '/miwoshop/site/';
		
		$files = $this->_getDeleteFile();
		
		foreach( $files as $file) {
			if (file_exists( $miwoshop . $file)) {
				@unlink($miwoshop . $file);
				@rmdir($miwoshop . $file);
			}
		}
	}
	
	public function _getDeleteFile(){
		$files = array();
		
		#vqmod manager
		$files[] = 'opencart/system/xmls/miwoshop_remove_miwoshop25_file.xml';
		$files[] = 'opencart/vqmod/xml/xx_miwoshop_wordpress.xml';
		$files[] = 'opencart/vqmod/xml/x_miwoshop_finish.xml';
		$files[] = 'opencart/vqmod/xml/vqmod_opencart.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_system.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_wishlist.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_wishlist.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_rewardpoints.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_rewardpoints.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_compare.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_compare.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_affiliates.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_remove_affiliates.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_j_integration.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_custom_theme_js.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_custom_theme_js.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_custom_theme_html.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_custom_theme_html.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_custom_theme_css.xml_';
		$files[] = 'opencart/vqmod/xml/miwoshop_custom_theme_css.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_catalog_js.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_catalog.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_admin_panel.xml';
		$files[] = 'opencart/vqmod/xml/miwoshop_admin.xml';
		$files[] = 'opencart/vqmod/xml/mijoshop_db_migration.xml';
		$files[] = 'opencart/vqmod/vqmod.php';
		$files[] = 'opencart/vqmod/vqcache/index.html';
		$files[] = 'opencart/vqmod/vqcache';
		$files[] = 'opencart/vqmod/pathReplaces.php';
		$files[] = 'opencart/vqmod/logs/index.html';
		$files[] = 'opencart/vqmod/logs';
		
		#system
		$files[] = 'opencart/system/logs/error.txt';
		$files[] = 'opencart/system/library/captcha.php';
		$files[] = 'opencart/system/library/template.php';
		$files[] = 'opencart/system/database/mmsql.php';
		$files[] = 'opencart/system/database/mysql.php';
		$files[] = 'opencart/system/database/mysqli.php';
		$files[] = 'opencart/system/database/odbc.php';
		$files[] = 'opencart/system/database/pdo.php';
		$files[] = 'opencart/system/database/postgre.php';
		$files[] = 'opencart/system/database/sqlite.php';
		
		#admin controllers
		$files[] = 'opencart/admin/controller/common/dbfix.php';
		$files[] = 'opencart/admin/controller/common/home.php';
		$files[] = 'opencart/admin/controller/module/amazon_checkout_layout.php';
		$files[] = 'opencart/admin/controller/module/categoryhome.php';
		$files[] = 'opencart/admin/controller/module/google_talk.php';
		$files[] = 'opencart/admin/controller/module/login.php';
		$files[] = 'opencart/admin/controller/module/manufacturer.php';
		$files[] = 'opencart/admin/controller/module/miwoshopcart.php';
		$files[] = 'opencart/admin/controller/module/miwoshopcurrency.php';
		$files[] = 'opencart/admin/controller/module/miwoshopminicart.php';
		$files[] = 'opencart/admin/controller/module/pp_layout.php';
		$files[] = 'opencart/admin/controller/module/vqmod_manager.php';
		$files[] = 'opencart/admin/controller/module/welcome.php';
		$files[] = 'opencart/admin/controller/payment/bluepay_hosted_form.php';
		$files[] = 'opencart/admin/controller/payment/mercadopago2.php';
		$files[] = 'opencart/admin/controller/payment/moneybookers.php';
		$files[] = 'opencart/admin/controller/payment/pin.php';
		$files[] = 'opencart/admin/controller/payment/pp_pro_pf.php';
		$files[] = 'opencart/admin/controller/payment/pp_pro_uk.php';
		$files[] = 'opencart/admin/controller/payment/sagepay.php';
		$files[] = 'opencart/admin/controller/report/affiliate_commission.php';
		$files[] = 'opencart/admin/controller/sale/affiliate.php';
		$files[] = 'opencart/admin/controller/sale/contact.php';
		$files[] = 'opencart/admin/controller/sale/coupon.php';

		#admin languages
		$files[] = 'opencart/admin/language/english/common/home.php';
		$files[] = 'opencart/admin/language/english/english.php';
		$files[] = 'opencart/admin/language/english/mail/order.php';
		$files[] = 'opencart/admin/language/english/module/amazon_checkout_layout.php';
		$files[] = 'opencart/admin/language/english/module/cart.php';
		$files[] = 'opencart/admin/language/english/module/categoryhome.php';
		$files[] = 'opencart/admin/language/english/module/google_talk.php';
		$files[] = 'opencart/admin/language/english/module/login.php';
		$files[] = 'opencart/admin/language/english/module/manufacturer.php';
		$files[] = 'opencart/admin/language/english/module/miwoshopcart.php';
		$files[] = 'opencart/admin/language/english/module/miwoshopcurrency.php';
		$files[] = 'opencart/admin/language/english/module/miwoshopminicart.php';
		$files[] = 'opencart/admin/language/english/module/pp_layout.php';
		$files[] = 'opencart/admin/language/english/module/vqmod_manager.php';
		$files[] = 'opencart/admin/language/english/module/welcome.php';
		$files[] = 'opencart/admin/language/english/payment/bluepay_hosted_form.php';
		$files[] = 'opencart/admin/language/english/payment/klarna_pp.php';
		$files[] = 'opencart/admin/language/english/payment/mercadopago2.php';
		$files[] = 'opencart/admin/language/english/payment/moneybookers.php';
		$files[] = 'opencart/admin/language/english/payment/pin.php';
		$files[] = 'opencart/admin/language/english/payment/pp_pro_pf.php';
		$files[] = 'opencart/admin/language/english/payment/pp_pro_uk.php';
		$files[] = 'opencart/admin/language/english/payment/psigate.php';
		$files[] = 'opencart/admin/language/english/payment/sagepay.php';
		$files[] = 'opencart/admin/language/english/report/affiliate_commission.php';
		$files[] = 'opencart/admin/language/english/sale/affiliate.php';
		$files[] = 'opencart/admin/language/english/sale/contact.php';
		$files[] = 'opencart/admin/language/english/sale/coupon.php';
		$files[] = 'opencart/admin/language/english/sale/customer_blacklist.php';

		#admin models
		$files[] = 'opencart/admin/model/common/dbfix.php';
		$files[] = 'opencart/admin/model/common/home.php';
		$files[] = 'opencart/admin/model/payment/bluepay_hosted_form.php';
		$files[] = 'opencart/admin/model/report/online.php';
		$files[] = 'opencart/admin/model/sale/affiliate.php';
		$files[] = 'opencart/admin/model/sale/coupon.php';
		$files[] = 'opencart/admin/model/setting/extension.php';

		#admin image
		$files[] = 'opencart/admin/view/image/add.png';
		$files[] = 'opencart/admin/view/image/arrow-right-hover.png';
		$files[] = 'opencart/admin/view/image/arrow-right.png';
		$files[] = 'opencart/admin/view/image/asc.png';
		$files[] = 'opencart/admin/view/image/attention.png';
		$files[] = 'opencart/admin/view/image/background.png';
		$files[] = 'opencart/admin/view/image/backup.png';
		$files[] = 'opencart/admin/view/image/banner.png';
		$files[] = 'opencart/admin/view/image/box.png';
		$files[] = 'opencart/admin/view/image/button-left.png';
		$files[] = 'opencart/admin/view/image/button-right.png';
		$files[] = 'opencart/admin/view/image/category.png';
		$files[] = 'opencart/admin/view/image/country.png';
		$files[] = 'opencart/admin/view/image/customer.png';
		$files[] = 'opencart/admin/view/image/delete.png';
		$files[] = 'opencart/admin/view/image/desc.png';
		$files[] = 'opencart/admin/view/image/download.png';
		$files[] = 'opencart/admin/view/image/error.png';
		$files[] = 'opencart/admin/view/image/feed.png';
		$files[] = 'opencart/admin/view/image/field.png';
		#$files[] = 'opencart/admin/view/image/filemanager ALL IMAGE DELETE
		#$files[] = 'opencart/admin/view/image/flags/ALL IMAGE.png';
		$files[] = 'opencart/admin/view/image/footer.png';
		$files[] = 'opencart/admin/view/image/header.png';
		$files[] = 'opencart/admin/view/image/home.png';
		$files[] = 'opencart/admin/view/image/image.png';
		$files[] = 'opencart/admin/view/image/information.png';
		$files[] = 'opencart/admin/view/image/language.png';
		$files[] = 'opencart/admin/view/image/layout.png';
		$files[] = 'opencart/admin/view/image/length.png';
		$files[] = 'opencart/admin/view/image/lock-open.png';
		$files[] = 'opencart/admin/view/image/lock.png';
		$files[] = 'opencart/admin/view/image/lock_open.png';
		$files[] = 'opencart/admin/view/image/lockscreen.png';
		$files[] = 'opencart/admin/view/image/log.png';
		$files[] = 'opencart/admin/view/image/login.png';
		$files[] = 'opencart/admin/view/image/mail.png';
		$files[] = 'opencart/admin/view/image/measurement.png';
		$files[] = 'opencart/admin/view/image/menu.png';
		$files[] = 'opencart/admin/view/image/module.png';
		$files[] = 'opencart/admin/view/image/order.png';
		$files[] = 'opencart/admin/view/image/payment.png';
		$files[] = 'opencart/admin/view/image/payment/klarna.png';
		$files[] = 'opencart/admin/view/image/payment/mercadopago2.png';
		$files[] = 'opencart/admin/view/image/payment/securetrading.png';
		$files[] = 'opencart/admin/view/image/product.png';
		$files[] = 'opencart/admin/view/image/report.png';
		$files[] = 'opencart/admin/view/image/review.png';
		$files[] = 'opencart/admin/view/image/selected.png';
		$files[] = 'opencart/admin/view/image/setting.png';
		$files[] = 'opencart/admin/view/image/shipping.png';
		$files[] = 'opencart/admin/view/image/split.png';
		$files[] = 'opencart/admin/view/image/stock-status.png';
		$files[] = 'opencart/admin/view/image/stock_status.png';
		$files[] = 'opencart/admin/view/image/success.png';
		$files[] = 'opencart/admin/view/image/tab.png';
		$files[] = 'opencart/admin/view/image/tax.png';
		$files[] = 'opencart/admin/view/image/total.png';
		$files[] = 'opencart/admin/view/image/transparent.png';
		$files[] = 'opencart/admin/view/image/upgrade.png';
		$files[] = 'opencart/admin/view/image/user-group.png';
		$files[] = 'opencart/admin/view/image/user.png';
		$files[] = 'opencart/admin/view/image/warning.png';
		
		#admin css
		$files[] = 'opencart/admin/view/stylesheet/home.css';
		$files[] = 'opencart/admin/view/stylesheet/invoice.css';
		$files[] = 'opencart/admin/view/stylesheet/progress.css';
		$files[] = 'opencart/admin/view/stylesheet/vqmod_manager.css';
		
		#admin view
		$files[] = 'opencart/admin/view/template/common/dbfix.tpl';
		$files[] = 'opencart/admin/view/template/common/home.tpl';
		$files[] = 'opencart/admin/view/template/module/amazon_checkout_layout.tpl';
		$files[] = 'opencart/admin/view/template/module/categoryhome.tpl';
		$files[] = 'opencart/admin/view/template/module/google_talk.tpl';
		$files[] = 'opencart/admin/view/template/module/login.tpl';
		$files[] = 'opencart/admin/view/template/module/manufacturer.tpl';
		$files[] = 'opencart/admin/view/template/module/miwoshopcart.tpl';
		$files[] = 'opencart/admin/view/template/module/miwoshopcurrency.tpl';
		$files[] = 'opencart/admin/view/template/module/miwoshopminicart.tpl';
		$files[] = 'opencart/admin/view/template/module/pp_layout.tpl';
		$files[] = 'opencart/admin/view/template/module/vqmod_manager.tpl';
		$files[] = 'opencart/admin/view/template/module/welcome.tpl';
		$files[] = 'opencart/admin/view/template/payment/bluepay_hosted_form.tpl';
		$files[] = 'opencart/admin/view/template/payment/bluepay_hosted_form_order.tpl';
		$files[] = 'opencart/admin/view/template/payment/klarna_pp.tpl';
		$files[] = 'opencart/admin/view/template/payment/mercadopago2.tpl';
		$files[] = 'opencart/admin/view/template/payment/moneybookers.tpl';
		$files[] = 'opencart/admin/view/template/payment/pin.tpl';
		$files[] = 'opencart/admin/view/template/payment/pp_pro_pf.tpl';
		$files[] = 'opencart/admin/view/template/payment/pp_pro_uk.tpl';
		$files[] = 'opencart/admin/view/template/payment/sagepay.tpl';
		$files[] = 'opencart/admin/view/template/report/affiliate_commission.tpl';
		$files[] = 'opencart/admin/view/template/sale/affiliate_form.tpl';
		$files[] = 'opencart/admin/view/template/sale/affiliate_list.tpl';
		$files[] = 'opencart/admin/view/template/sale/affiliate_transaction.tpl';
		$files[] = 'opencart/admin/view/template/sale/contact.tpl';
		$files[] = 'opencart/admin/view/template/sale/coupon_form.tpl';
		$files[] = 'opencart/admin/view/template/sale/coupon_history.tpl';
		$files[] = 'opencart/admin/view/template/sale/coupon_list.tpl';
		$files[] = 'opencart/admin/view/template/sale/return_info.tpl';
		
		#catalog controller
		$files[] = 'opencart/catalog/controller/checkout/manual.php';
		$files[] = 'opencart/catalog/controller/module/cart.php';
		$files[] = 'opencart/catalog/controller/module/categoryhome.php';
		$files[] = 'opencart/catalog/controller/module/currency.php';
		$files[] = 'opencart/catalog/controller/module/google_talk.php';
		$files[] = 'opencart/catalog/controller/module/language.php';
		$files[] = 'opencart/catalog/controller/module/login.php';
		$files[] = 'opencart/catalog/controller/module/manufacturer.php';
		$files[] = 'opencart/catalog/controller/module/miwoshopcart.php';
		$files[] = 'opencart/catalog/controller/module/miwoshopcurrency.php';
		$files[] = 'opencart/catalog/controller/module/miwoshopminicart.php';
		$files[] = 'opencart/catalog/controller/module/pp_layout.php';
		$files[] = 'opencart/catalog/controller/module/welcome.php';
		$files[] = 'opencart/catalog/controller/payment/bluepay_hosted_form.php';
		$files[] = 'opencart/catalog/controller/payment/klarna_pp.php';
		$files[] = 'opencart/catalog/controller/payment/mercadopago2.php';
		$files[] = 'opencart/catalog/controller/payment/moneybookers.php';
		$files[] = 'opencart/catalog/controller/payment/payjunction.php';
		$files[] = 'opencart/catalog/controller/payment/pin.php';
		$files[] = 'opencart/catalog/controller/payment/pp_pro_pf.php';
		$files[] = 'opencart/catalog/controller/payment/pp_pro_uk.php';
		$files[] = 'opencart/catalog/controller/payment/sagepay.php';
		
		#catalog languages
		$files[] = 'opencart/catalog/language/english/checkout/manual.php';
		$files[] = 'opencart/catalog/language/english/english.php';
		$files[] = 'opencart/catalog/language/english/module/cart.php';
		$files[] = 'opencart/catalog/language/english/module/categoryhome.php';
		$files[] = 'opencart/catalog/language/english/module/currency.php';
		$files[] = 'opencart/catalog/language/english/module/google_talk.php';
		$files[] = 'opencart/catalog/language/english/module/language.php';
		$files[] = 'opencart/catalog/language/english/module/login.php';
		$files[] = 'opencart/catalog/language/english/module/manufacturer.php';
		$files[] = 'opencart/catalog/language/english/module/miwoshopcart.php';
		$files[] = 'opencart/catalog/language/english/module/product.php';
		$files[] = 'opencart/catalog/language/english/module/welcome.php';
		$files[] = 'opencart/catalog/language/english/payment/asiapay.php';
		$files[] = 'opencart/catalog/language/english/payment/bluepay.php';
		$files[] = 'opencart/catalog/language/english/payment/bluepay_hosted_form.php';
		$files[] = 'opencart/catalog/language/english/payment/ccavenue.php';
		$files[] = 'opencart/catalog/language/english/payment/ccnow.php';
		$files[] = 'opencart/catalog/language/english/payment/chronopay.php';
		$files[] = 'opencart/catalog/language/english/payment/egold.php';
		$files[] = 'opencart/catalog/language/english/payment/eway.php';
		$files[] = 'opencart/catalog/language/english/payment/hsbc.php';
		$files[] = 'opencart/catalog/language/english/payment/klarna_pp.php';
		$files[] = 'opencart/catalog/language/english/payment/linkpoint.php';
		$files[] = 'opencart/catalog/language/english/payment/malse.php';
		$files[] = 'opencart/catalog/language/english/payment/mercadopago2.php';
		$files[] = 'opencart/catalog/language/english/payment/moneybookers.php';
		$files[] = 'opencart/catalog/language/english/payment/payjunction.php';
		$files[] = 'opencart/catalog/language/english/payment/pin.php';
		$files[] = 'opencart/catalog/language/english/payment/pp_pro_pf.php';
		$files[] = 'opencart/catalog/language/english/payment/pp_pro_uk.php';
		$files[] = 'opencart/catalog/language/english/payment/psigate.php';
		$files[] = 'opencart/catalog/language/english/payment/sagepay.php';
		$files[] = 'opencart/catalog/language/english/payment/secpay.php';
		$files[] = 'opencart/catalog/language/english/payment/verisign.php';
		$files[] = 'opencart/catalog/language/english/total/shipping.php';
		
		#catalog models
		$files[] = 'opencart/catalog/model/catalog/filter.php';
		$files[] = 'opencart/catalog/model/payment/asiapay.php';
		$files[] = 'opencart/catalog/model/payment/bluepay.php';
		$files[] = 'opencart/catalog/model/payment/bluepay_hosted_form.php';
		$files[] = 'opencart/catalog/model/payment/ccavenue.php';
		$files[] = 'opencart/catalog/model/payment/ccnow.php';
		$files[] = 'opencart/catalog/model/payment/chronopay.php';
		$files[] = 'opencart/catalog/model/payment/egold.php';
		$files[] = 'opencart/catalog/model/payment/eway.php';
		$files[] = 'opencart/catalog/model/payment/hsbc.php';
		$files[] = 'opencart/catalog/model/payment/klarna_pp.php';
		$files[] = 'opencart/catalog/model/payment/linkpoint.php';
		$files[] = 'opencart/catalog/model/payment/malse.php';
		$files[] = 'opencart/catalog/model/payment/mercadopago2.php';
		$files[] = 'opencart/catalog/model/payment/money_order.php';
		$files[] = 'opencart/catalog/model/payment/moneybookers.php';
		$files[] = 'opencart/catalog/model/payment/payjunction.php';
		$files[] = 'opencart/catalog/model/payment/pin.php';
		$files[] = 'opencart/catalog/model/payment/pp_express_uk.php';
		$files[] = 'opencart/catalog/model/payment/pp_pro_pf.php';
		$files[] = 'opencart/catalog/model/payment/pp_pro_uk.php';
		$files[] = 'opencart/catalog/model/payment/psigate.php';
		$files[] = 'opencart/catalog/model/payment/sagepay.php';
		$files[] = 'opencart/catalog/model/payment/verisign.php';
		$files[] = 'opencart/catalog/model/setting/extension.php';
		
		#catalog JS
		#$files[] = 'opencart/catalog/view/javascript/amazon_payment  ALL FİLES
		$files[] = 'opencart/catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js';
		#$files[] = 'opencart/catalog/view/javascript/unitpngfix ALL FİLES
		
		#catalog image
		$files[] = 'opencart/catalog/view/theme/default/image/add.png';
		$files[] = 'opencart/catalog/view/theme/default/image/arrow-down.png';
		$files[] = 'opencart/catalog/view/theme/default/image/arrow-right.png';
		$files[] = 'opencart/catalog/view/theme/default/image/arrows.png';
		$files[] = 'opencart/catalog/view/theme/default/image/attention.png';
		$files[] = 'opencart/catalog/view/theme/default/image/background.png';
		$files[] = 'opencart/catalog/view/theme/default/image/bullet-1.png';
		$files[] = 'opencart/catalog/view/theme/default/image/bullets.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-active.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-left-active.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-left.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-next.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-previous.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-right-active.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-right.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button-search.png';
		$files[] = 'opencart/catalog/view/theme/default/image/button.png';
		$files[] = 'opencart/catalog/view/theme/default/image/cart-add.png';
		$files[] = 'opencart/catalog/view/theme/default/image/close.png';
		$files[] = 'opencart/catalog/view/theme/default/image/download.png';
		$files[] = 'opencart/catalog/view/theme/default/image/info.png';
		$files[] = 'opencart/catalog/view/theme/default/image/loading.gif';
		$files[] = 'opencart/catalog/view/theme/default/image/menu.png';
		$files[] = 'opencart/catalog/view/theme/default/image/payment.png';
		$files[] = 'opencart/catalog/view/theme/default/image/remove-small.png';
		$files[] = 'opencart/catalog/view/theme/default/image/remove.png';
		$files[] = 'opencart/catalog/view/theme/default/image/reorder.png';
		$files[] = 'opencart/catalog/view/theme/default/image/return.png';
		$files[] = 'opencart/catalog/view/theme/default/image/split.png';
		$files[] = 'opencart/catalog/view/theme/default/image/stars-0.png';
		$files[] = 'opencart/catalog/view/theme/default/image/stars-1.png';
		$files[] = 'opencart/catalog/view/theme/default/image/stars-2.png';
		$files[] = 'opencart/catalog/view/theme/default/image/stars-3.png';
		$files[] = 'opencart/catalog/view/theme/default/image/stars-4.png';
		$files[] = 'opencart/catalog/view/theme/default/image/stars-5.png';
		$files[] = 'opencart/catalog/view/theme/default/image/success.png';
		$files[] = 'opencart/catalog/view/theme/default/image/tab.png';
		$files[] = 'opencart/catalog/view/theme/default/image/update.png';
		$files[] = 'opencart/catalog/view/theme/default/image/warning.png';
		
		#catalog css
		$files[] = 'opencart/catalog/view/theme/default/stylesheet/carousel.css';
		$files[] = 'opencart/catalog/view/theme/default/stylesheet/ie6.css';
		$files[] = 'opencart/catalog/view/theme/default/stylesheet/ie7.css';
		$files[] = 'opencart/catalog/view/theme/default/stylesheet/slideshow.css';
		
		#catalog view
		$files[] = 'opencart/catalog/view/theme/default/template/module/cart.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/categoryhome.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/currency.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/google_talk.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/language.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/login.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/manufacturer.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/miwoshopcart.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/miwoshopcurrency.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/miwoshopminicart.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/pp_layout.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/product.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/module/welcome.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/amazon_checkout_cart.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/authorizenet_sim_callback.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/bluepay_hosted_form.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/klarna_pp.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/mercadopago2.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/moneybookers.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/pin.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/pp_payflow_iframe_cancel.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/pp_payflow_iframe_error.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/pp_pro_pf.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/pp_pro_uk.tpl';
		$files[] = 'opencart/catalog/view/theme/default/template/payment/sagepay.tpl';

		return $files;
	}
}