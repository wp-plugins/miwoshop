<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU GPL, based on AceShop, www.joomace.net
*/

// no direct access
defined('MIWI') or die('Restricted access');

mimport('framework.plugin.plugin');
mimport('framework.environment.browser');
mimport('framework.application.module.helper');

class plgMiwoshopJs extends MPlugin {

	public $p_params = null;

	public function __construct(&$subject, $config) {
		parent::__construct($subject, $config);

        $miwoshop = MPATH_WP_PLG .'/miwoshop/site/miwoshop/miwoshop.php';
        $library = MPATH_WP_PLG .'/miwoshop/site/opencart/config.php';
        if (!file_exists($miwoshop) or !file_exists($library)) {
            return;
        }

		require_once($miwoshop);

        $plugin = MPluginHelper::getPlugin('miwoshop', 'miwoshopjs');
		
		if (!is_object($plugin)) {
			$plugin = new stdClass();
			$plugin->params = '';
		}
		
        $this->p_params = new MRegistry($plugin->params);
	}

    public function onInit(){
        $app        = MFactory::getApplication();
        $route      = MRequest::getString('route');
        $browser    = MBrowser::getInstance()->getBrowser();
        $document   = MFactory::getDocument();

        $lib_folder = MURL_WP_CNT.'/miwi/plugins/plg_miwoshop_js/js';
        $ui_folder  = MURL_WP_CNT.'/miwi/media/jui';


        //ui stylesheets
        $document->addStyleSheet($ui_folder.'/css/jquery-ui-1.10.4.custom.min.css');

        /*
        * Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.position.js,
        * jquery.ui.draggable.js, jquery.ui.droppable.js, jquery.ui.resizable.js, jquery.ui.selectable.js,
        * jquery.ui.sortable.js, jquery.ui.accordion.js, jquery.ui.autocomplete.js, jquery.ui.button.js,
        * jquery.ui.datepicker.js, jquery.ui.dialog.js, jquery.ui.menu.js, jquery.ui.progressbar.js, jquery.ui.slider.js,
        * jquery.ui.spinner.js, jquery.ui.tabs.js, jquery.ui.tooltip.js, jquery.ui.effect.js, jquery.ui.effect-*
        *  jquery.ui.effect-bounce.js, jquery.ui.effect-clip.js, jquery.ui.effect-drop.js,
        */

        //wp_enqueue_script('jquery');
        $document->addScript($ui_folder.'/js/jquery-ui-1.10.4.custom.min.js');

        if ($app->isSite()) {

            $document->addScript($lib_folder.'/tabs_site.js');
            $document->addScript($lib_folder.'/jquery.total-storage.min.js');

            if ($route == 'product/product' or MRequest::getInt('product_id', 0) > 0 ) {
                $document->addScript($lib_folder.'/ajaxupload.js');
                $document->addScript($lib_folder.'/ui/jquery-ui-timepicker-addon.js');
            }

            if ($this->p_params->get('load_cookie', '0') == '1') {
                $document->addScript($lib_folder.'/ui/external/jquery.cookie.js');
            }

            if ($this->p_params->get('load_colorbox', '1') == '1') {
                $document->addScript($lib_folder.'/colorbox/jquery.colorbox.js');
                $document->addStyleSheet($lib_folder.'/colorbox/colorbox.css');
            }

            if ($route == 'product/product' or MRequest::getInt('product_id', 0) > 0 ) {
                $document->addScript($lib_folder.'/ajaxupload.js');
                $document->addScript($lib_folder.'/ui/jquery-ui-timepicker-addon.js');
            }

            if ($this->p_params->get('load_cycle', '1') == '1') {
                $document->addScript($lib_folder.'/jquery.cycle.js');
            }

            if ($this->p_params->get('load_jcarousel', '1') == '1') {
                $document->addScript($lib_folder.'/jquery.jcarousel.min.js');
            }

            if ($this->p_params->get('load_nivo_slider', '1') == '1') {
                $document->addScript($lib_folder.'/nivo-slider/jquery.nivo.slider.pack.js');
            }
        }


        if (MiwoShop::get()->isAdmin('miwoshop') || MiwoShop::get()->isAdmin('joomla')) {
            $document->addScript($lib_folder.'/tabs_admin.js');
            $document->addScript($lib_folder.'/ui/external/jquery.bgiframe-2.1.2.js');
            $document->addScript($lib_folder.'/superfish/js/superfish.js');

            if (empty($route) || $route == 'common/home') {
                if ($browser == 'msie') {
                    $document->addScript($lib_folder.'/flot/excanvas.js'); // Only IE
                }

                $document->addScript($lib_folder.'/flot/jquery.flot.js');
            }

            if ($route == 'catalog/product/insert' || $route == 'catalog/product/update' || strpos($route, 'order')) {
                $document->addScript($lib_folder.'/ui/jquery-ui-timepicker-addon.js');
            }
        }
    }
}