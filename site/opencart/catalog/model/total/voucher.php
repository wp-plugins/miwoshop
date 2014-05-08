<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ModelTotalVoucher extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if (isset($this->session->data['voucher'])) {
			$this->language->load('total/voucher');
			
			$this->load->model('checkout/voucher');
			 
			$voucher_info = $this->model_checkout_voucher->getVoucher($this->session->data['voucher']);
			
			if ($voucher_info) {
				if ($voucher_info['amount'] > $total) {
					$amount = $total;	
				} else {
					$amount = $voucher_info['amount'];	
				}				
      			
				$total_data[] = array(
					'code'       => 'voucher',
        			'title'      => sprintf($this->language->get('text_voucher'), $this->session->data['voucher']),
	    			'text'       => $this->currency->format(-$amount),
        			'value'      => -$amount,
					'sort_order' => $this->config->get('voucher_sort_order')
      			);

				$total -= $amount;
			} 
		}
	}
	
	public function confirm($order_info, $order_total) {
		$code = '';
		
		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');
		
		if ($start && $end) {  
			$code = substr($order_total['title'], $start, $end - $start);
		}	
		
		$this->load->model('checkout/voucher');
		
		$voucher_info = $this->model_checkout_voucher->getVoucher($code);
		
		if ($voucher_info) {
			$this->model_checkout_voucher->redeem($voucher_info['voucher_id'], $order_info['order_id'], $order_total['value']);	
		}						
	}	
}
?>