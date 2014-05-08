<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerCommonEditorbutton extends Controller {
	public function index() {
		$this->load->model('catalog/product');


        $results = $this->model_catalog_product->getProducts();

        $name  = MRequest::getString('name');
		
		$this->data['products'] = $results;
		$this->data['name'] = $name;

		$this->template = 'common/editorbutton.tpl';
	
        $this->response->setOutput($this->render());
  	}

    public function getProductOptions() {
		$this->load->model('catalog/product');

        $product_id= MRequest::getInt('product_id');

        $this->data['text_select'] = '- Select -';


        $options = $this->getProductOptionsData($product_id);

        $this->data['options'] = $options;
        $this->template = 'common/editorproductoptions.tpl';
        $html = $this->render();

        $this->response->setOutput($html);
  	}

    public function getProductOptionsData($product_id){

        $this->load->model('catalog/product');
        $this->load->model('common/editorbutton');
        $product_info = $this->model_catalog_product->getProduct($product_id);
        $options = $this->model_common_editorbutton->getProductOptions($product_id);

        $this->load->model('tool/image');

        foreach ($options as $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $option_value_data = array();

                foreach ($option['option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        $price = false;

                        $option_value_data[] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id'         => $option_value['option_value_id'],
                            'name'                    => $option_value['name'],
                            'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
                            'price'                   => $price,
                            'price_prefix'            => $option_value['price_prefix']
                        );
                    }
                }

                $product_options[] = array(
                    'product_option_id' => $option['product_option_id'],
                    'option_id'         => $option['option_id'],
                    'name'              => $option['name'],
                    'type'              => $option['type'],
                    'option_value'      => $option_value_data,
                    'required'          => $option['required']
                );
            } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                $product_options[] = array(
                    'product_option_id' => $option['product_option_id'],
                    'option_id'         => $option['option_id'],
                    'name'              => $option['name'],
                    'type'              => $option['type'],
                    'option_value'      => $option['option_value'],
                    'required'          => $option['required']
                );
            }
        }

        return $product_options;
    }

}
?>