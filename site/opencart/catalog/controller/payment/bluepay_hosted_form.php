<?php
class ControllerPaymentBluePayHostedForm extends Controller {
	public function index() {
		$this->load->language('payment/bluepay_hosted_form');
		$this->load->model('checkout/order');
		$this->load->model('payment/bluepay_hosted_form');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$this->data['ORDER_ID'] = $this->session->data['order_id'];
		$this->data['NAME1'] = $order_info['payment_firstname'];
		$this->data['NAME2'] = $order_info['payment_lastname'];
		$this->data['ADDR1'] = $order_info['payment_address_1'];
		$this->data['ADDR2'] = $order_info['payment_address_2'];
		$this->data['CITY'] = $order_info['payment_city'];
		$this->data['STATE'] = $order_info['payment_zone'];
		$this->data['ZIPCODE'] = $order_info['payment_postcode'];
		$this->data['COUNTRY'] = $order_info['payment_country'];
		$this->data['PHONE'] = $order_info['telephone'];
		$this->data['EMAIL'] = $order_info['email'];

		$this->data['SHPF_FORM_ID'] = 'opencart01';
		$this->data['DBA'] = $this->config->get('bluepay_hosted_form_account_name');
		$this->data['MERCHANT'] = $this->config->get('bluepay_hosted_form_account_id');
		$this->data['SHPF_ACCOUNT_ID'] = $this->config->get('bluepay_hosted_form_account_id');
		$this->data["TRANSACTION_TYPE"] = $this->config->get('bluepay_hosted_form_transaction');
		$this->data["MODE"] = strtoupper($this->config->get('bluepay_hosted_form_test'));

		$this->data['CARD_TYPES'] = 'vi-mc';

		if ($this->config->get('bluepay_hosted_form_discover') == 1) {
			$this->data['CARD_TYPES'] .= '-di';
		}

		if ($this->config->get('bluepay_hosted_form_amex') == 1) {
			$this->data['CARD_TYPES'] .= '-am';
		}

		$this->data["AMOUNT"] = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
		$this->data['APPROVED_URL'] = $this->url->link('payment/bluepay_hosted_form/callback', 'format=raw&tmpl=component', 'SSL');
		$this->data['DECLINED_URL'] = $this->url->link('payment/bluepay_hosted_form/callback', 'format=raw&tmpl=component', 'SSL');
		$this->data['MISSING_URL'] = $this->url->link('payment/bluepay_hosted_form/callback', 'format=raw&tmpl=component', 'SSL');
		$this->data['REDIRECT_URL'] = $this->url->link('payment/bluepay_hosted_form/callback', 'format=raw&tmpl=component', 'SSL');

		$this->data['TPS_DEF'] = "MERCHANT APPROVED_URL DECLINED_URL MISSING_URL MODE TRANSACTION_TYPE TPS_DEF AMOUNT";
		$this->data['TAMPER_PROOF_SEAL'] = md5($this->config->get('bluepay_hosted_form_secret_key') . $this->data['MERCHANT'] . $this->data['APPROVED_URL'] . $this->data['DECLINED_URL'] . $this->data['MISSING_URL'] . $this->data['MODE'] . $this->data['TRANSACTION_TYPE'] . $this->data['TPS_DEF'] . $this->data['AMOUNT']);

		$this->data['SHPF_TPS_DEF'] = "SHPF_FORM_ID SHPF_ACCOUNT_ID DBA TAMPER_PROOF_SEAL CARD_TYPES TPS_DEF SHPF_TPS_DEF AMOUNT";
		$this->data['SHPF_TPS'] = md5($this->config->get('bluepay_hosted_form_secret_key') . $this->data['SHPF_FORM_ID'] . $this->data['SHPF_ACCOUNT_ID'] . $this->data['DBA'] . $this->data['TAMPER_PROOF_SEAL'] . $this->data['CARD_TYPES'] . $this->data['TPS_DEF'] . $this->data['SHPF_TPS_DEF'] . $this->data['AMOUNT']);

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['text_loading'] = $this->language->get('text_loading');


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bluepay_hosted_form.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/bluepay_hosted_form.tpl';
        } else {
            $this->template = 'default/template/payment/bluepay_hosted_form.tpl';
        }

        $this->render();
	}

	public function callback() {
		$this->load->language('payment/bluepay_hosted_form');

		$this->load->model('checkout/order');

		$this->load->model('payment/bluepay_hosted_form');

		$response_data = $this->request->get;

		if (isset($this->session->data['order_id'])) {
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			if ($response_data['Result'] == 'APPROVED') {
				$bluepay_hosted_form_order_id = $this->model_payment_bluepay_hosted_form->addOrder($order_info, $response_data);

				$this->model_payment_bluepay_hosted_form->addTransaction($bluepay_hosted_form_order_id, $this->config->get('bluepay_hosted_form_transaction'), $order_info);

				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('bluepay_hosted_form_order_status_id'));

				$this->response->redirect($this->url->link('checkout/success', '', 'SSL'));
			} else {
				$this->session->data['error'] = $response_data['Result'] . ' : ' . $response_data['MESSAGE'];

				$this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
			}
		} else {
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
	}

	public function adminCallback() {
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($this->request->get));
	}
}