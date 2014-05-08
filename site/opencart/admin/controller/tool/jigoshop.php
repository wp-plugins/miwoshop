<?php 
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, www.miwisoft.com
* @license		http://www.miwisoft.com/company/license
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerToolJigoshop extends Controller {

	private $error = array(); 
    
  	public function index() {
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'MiwoShop Migration Tools',
			'href'      => '',
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Jigoshop',
			'href'      => $this->url->link('tool/jigoshop', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		//$this->data['virtuemart_link'] = $this->url->link('tool/jigoshop', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->template = 'tool/jigoshop.tpl';
		$this->children = array(
			'common/header'
		);
		
		$this->response->setOutput($this->render());
  	} 
  	
  	public function importCategories(){
		if (!$this->validate()) {
			return $this->forward('error/permission');
		}

		$this->load->model('tool/jigoshop');
		
		$this->model_tool_jigoshop->importCategories($this->request->post['jigoshop']);
	}
  	
  	public function importProducts() {
		if (!$this->validate()) {
			return $this->forward('error/permission');
		}

		$this->load->model('tool/jigoshop');
		
		$this->model_tool_jigoshop->importProducts($this->request->post['jigoshop']);
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/jigoshop')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		}
		else {
			return false;
		}		
	}
}