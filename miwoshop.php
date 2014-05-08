<?php
/*
Plugin Name: MiwoShop
Plugin URI: http://miwisoft.com
Description: MiwoShop is a powerful shopping cart that is designed user friendly and extremely powerful out of the box with tons of built-in features.
Author: Miwisoft LLC
Version: 1.0.0
Author URI: http://miwisoft.com
Plugin URI: http://miwisoft.com/miwoshop
*/

defined('ABSPATH') or die('MIWI');

if (!class_exists('MWordpress')) {
    require_once(dirname(__FILE__) . '/wordpress.php');
}

final class MShop extends MWordpress {

    public function __construct() {
	    if (!defined('MURL_MIWOSHOP')) {
			define('MURL_MIWOSHOP', plugins_url('', __FILE__));
		}
        
		parent::__construct('miwoshop', '33.0001', false);
        
        if (!defined('MID_PATH')) {
            $url = str_replace(str_replace('\\', '/', ABSPATH), '', str_replace('\\', '/', MPATH_WP_PLG));
            define('MID_PATH', $url);
        }
    }
	
    public function initialise() {
        $miwi = MPATH_WP_CNT.'/miwi/initialise.php';

        if (!file_exists($miwi)) {
            return false;
        }

        require_once($miwi);

        $this->app = MFactory::getApplication();

        $this->app->initialise();

        mimport('framework.plugin.helper');
        mimport('framework.application.component.helper');
        MPluginHelper::importPlugin('miwoshop');

        require_once(MPATH_WP_PLG.'/miwoshop/site/miwoshop/miwoshop.php');
        $m_user = MiwoShop::get('user');

        # wordpress user hooks
        add_action('profile_update', array($m_user, 'user_update'));
        add_action('user_register', array($m_user, 'user_register'));
        add_action('wp_logout', array($m_user, 'user_logout'));
        add_action('deleted_user', array($m_user, 'delete_miwouser'));
        add_action('reset_password', array($m_user, 'reset_password_wp'));
        ##############################################

        $dispatcher = MDispatcher::getInstance();
        $dispatcher->trigger('onInit', array());
    }
}

$mshop = new MShop();

register_activation_hook(__FILE__, array($mshop, 'activate'));
register_deactivation_hook(__FILE__, array($mshop, 'deactivate'));


