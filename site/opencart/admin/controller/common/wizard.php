<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerCommonWizard extends Controller {
	public function index() {
        $this->language->load('common/wizard');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_skip'] = $this->language->get('text_skip');
        $this->data['text_message'] = $this->language->get('text_message');
        $this->data['text_personal_id'] = $this->language->get('text_personal_id');
        $this->data['text_logo'] = $this->language->get('text_logo');
        $this->data['text_name'] = $this->language->get('text_name');
        $this->data['text_mail'] = $this->language->get('text_mail');
        $this->data['text_telephone'] = $this->language->get('text_telephone');
        $this->data['text_address'] = $this->language->get('text_address');
        $this->data['text_country'] = $this->language->get('text_country');
        $this->data['text_zone'] = $this->language->get('text_zone');
        $this->data['text_currency'] = $this->language->get('text_currency');
        $this->data['text_step_1'] = $this->language->get('text_step_1');
        $this->data['text_step_2'] = $this->language->get('text_step_2');
        $this->data['text_step_3'] = $this->language->get('text_step_3');
        $this->data['text_step_4'] = $this->language->get('text_step_4');
        $this->data['text_step_5'] = $this->language->get('text_step_5');
        $this->data['text_step_6'] = $this->language->get('text_step_6');
        $this->data['text_step_7'] = $this->language->get('text_step_7');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
       	$this->data['text_browse'] = $this->language->get('text_browse');
       	$this->data['text_select'] = $this->language->get('text_select');
       	$this->data['text_none'] = $this->language->get('text_none');
       	$this->data['text_save_and_new_product'] = $this->language->get('text_save_and_new_product');
       	$this->data['text_save_and_migration'] = $this->language->get('text_save_and_migration');
       	$this->data['text_grid'] = $this->language->get('text_grid');
       	$this->data['text_list'] = $this->language->get('text_list');
       	$this->data['text_yes'] = $this->language->get('text_yes');
       	$this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_product_display'] = $this->language->get('text_product_display');
        $this->data['text_add_home_menu'] = $this->language->get('text_add_home_menu');
        $this->data['text_migration'] = $this->language->get('text_migration');
        $this->data['text_language_info'] = $this->language->get('text_language_info');

        $this->load->model('tool/image');
        $this->data['logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        $this->load->model('localisation/country');
        $this->data['countries'] = $this->model_localisation_country->getCountries();
        $this->data['country_id'] = $this->config->get('config_country_id');
        $this->data['zone_id'] = $this->config->get('config_zone_id');

        $this->load->model('localisation/currency');
      	$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
        $this->data['config_currency'] = $this->config->get('config_currency');

        $this->data['lang'] = $this->_checkLang();
        $this->data['mig_coms'] = $this->_checkMigrateComponents();

        # links
        $this->data['link_home'] =  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_skip'] =  $this->url->link('common/wizard/skip', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_new_product'] =  $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_action'] =  $this->url->link('common/wizard/save', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link'] =  $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&sort=r.status&order=ASC', 'SSL');

        $this->template = 'common/wizard.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
	}

    public function save(){

        if(!empty($this->request->post['pid'])) {
            $data['pid'] =  $this->request->post['pid'];
        }

        if(isset($this->request->post['miwoshop_display'])) {
            $data['miwoshop_display'] =  $this->request->post['miwoshop_display'];
        }

        if(!empty($this->request->post['logo'])) {
            $data['config']['config_logo'] =  $this->request->post['logo'];
        }

        if(!empty($this->request->post['name'])) {
            $data['config']['config_name'] =  $this->request->post['name'];
            $data['config']['config_owner'] =  $this->request->post['name'];
            $data['config']['config_title'] =  $this->request->post['name'];
        }

        if(!empty($this->request->post['mail'])) {
            $data['config']['config_email'] =  $this->request->post['mail'];
        }

        if(!empty($this->request->post['telephone'])) {
            $data['config']['config_telephone'] =  $this->request->post['telephone'];
        }

        if(!empty($this->request->post['address'])) {
            $data['config']['config_address'] =  $this->request->post['address'];
        }

        if(!empty($this->request->post['country_id'])) {
            $data['config']['config_country_id'] =  $this->request->post['country_id'];
        }

        if(!empty($this->request->post['zone_id'])) {
            $data['config']['config_zone_id'] =  $this->request->post['zone_id'];
        }

        if(!empty($this->request->post['currency'])) {
            $data['config']['config_currency'] =  $this->request->post['currency'];
        }

        if(!empty($this->request->post['currency'])) {
            $data['config']['config_currency'] =  $this->request->post['currency'];
        }

        $this->load->model('common/wizard');
        $result = $this->model_common_wizard->save($data);

        if(!empty($this->request->post['redirect'])) {
            $this->redirect($this->request->post['redirect']);
        }

        echo json_encode($result);
        exit;
    }

    public function skip() {
        MiwoShop::get('base')->setConfig('wizard', 1);
        $this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
    }

    private function  _checkMigrateComponents() {
        $components = array ('ecommerceprodcat', 'jigoshop', 'readyecommerce', 'woocart', 'woocommerce', 'wpecommerce');
        $installed  = array();

        $this->load->model('common/wizard');
        $_installed = $this->model_common_wizard->getInstalledComponents($components);

        if(empty($_installed)) {
            return $installed;
        }

        foreach($_installed as $tmp) {
            $com['name'] = $tmp;
            $com['link'] = $this->url->link('tool/'.$tmp, 'token=' . $this->session->data['token'], 'SSL');;

            $installed[] = $com;
        }

        return $installed;
    }
	
    private function _checkLang(){
	
		return false;

        $this->load->model('common/wizard');
        $lang_count = $this->model_common_wizard->getLanguageCount();

        if($lang_count > 1) {
            return true;
        }

        $def_lang = MFactory::getLanguage()->getDefault();

        if($def_lang != 'en-GB') {
            return true;
        }

        return false;

    }

}
