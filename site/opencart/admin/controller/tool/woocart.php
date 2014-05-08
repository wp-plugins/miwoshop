<?php 
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, www.miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerToolWoocart extends Controller {

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
       		'text'      => 'WooCart',
			'href'      => $this->url->link('tool/woocart', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'tool/woocart.tpl';
		$this->children = array(
			'common/header'
		);
		
		$this->response->setOutput($this->render());
  	} 
  	
  	public function migrateDatabase(){
		$this->load->model('tool/woocart');
        $post = $this->request->post['opencart'];
        $post['component'] = 'opencart';
		
		$this->model_tool_woocart->migrateDatabase($post);
	}
  	
  	public function migrateFiles() {
		$this->load->model('tool/woocart');
        $post = $this->request->post['woocart'];
        $post['component'] = 'woocart';
		
		$this->model_tool_woocart->migrateFiles($post);
	}
	
	public function fixMenus() {
		$this->load->model('tool/woocart');
        $post = $this->request->post['woocart'];
        $post['component'] = 'woocart';
		
		$this->model_tool_woocart->fixMenus($post);
	}
	
	public function fixModules() {
		$this->load->model('tool/woocart');
        $post = $this->request->post['woocart'];
        $post['component'] = 'woocart';
		
		$this->model_tool_woocart->fixModules($post);
	}
}