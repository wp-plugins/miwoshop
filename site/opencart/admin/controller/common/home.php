<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

class ControllerCommonHome extends Controller {
	public function index() {
        $this->language->load('common/home');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->user->getUsername());
		$this->data['text_new_order'] = $this->language->get('text_new_order');
		$this->data['text_new_customer'] = $this->language->get('text_new_customer');
		$this->data['text_total_sale'] = $this->language->get('text_total_sale');
		$this->data['text_marketing'] = $this->language->get('text_marketing');
		$this->data['text_analytics'] = $this->language->get('text_analytics');
		$this->data['text_online'] = $this->language->get('text_online');
		$this->data['text_activity'] = $this->language->get('text_activity');
		$this->data['text_last_order'] = $this->language->get('text_last_order');
		$this->data['text_day'] = $this->language->get('text_day_home');
		$this->data['text_week'] = $this->language->get('text_week_home');
		$this->data['text_month'] = $this->language->get('text_month_home');
		$this->data['text_year'] = $this->language->get('text_year_home');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_event_summary'] = $this->language->get('text_event_summary');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_affiliates'] = $this->language->get('text_affiliates');
		$this->data['text_reviews'] = $this->language->get('text_reviews');
		$this->data['text_rewards'] = $this->language->get('text_rewards');
		$this->data['text_miwoshop_info'] = $this->language->get('text_miwoshop_info');
		$this->data['text_products_and_sales'] = $this->language->get('text_products_and_sales');
		$this->data['text_best_sellers'] = $this->language->get('text_best_sellers');
		$this->data['text_less_sellers'] = $this->language->get('text_less_sellers');
		$this->data['text_most_viewed'] = $this->language->get('text_most_viewed');

        $this->data['text_total_sale'] = $this->language->get('text_total_sale');
        $this->data['text_total_sale_year'] = $this->language->get('text_total_sale_year');
        $this->data['text_total_order'] = $this->language->get('text_total_order');
        $this->data['text_total_customer'] = $this->language->get('text_total_customer');
        $this->data['text_total_customer_approval'] = $this->language->get('text_total_customer_approval');
        $this->data['text_total_review_approval'] = $this->language->get('text_total_review_approval');
        $this->data['text_total_affiliate'] = $this->language->get('text_total_affiliate');
        $this->data['text_total_affiliate_approval'] = $this->language->get('text_total_affiliate_approval');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_product_name'] = $this->language->get('column_product_name');
		$this->data['column_product_id'] = $this->language->get('column_product_id');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_edit'] = $this->language->get('button_edit');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['token'] = $this->session->data['token'];

        $this->load->model('common/home');
        $results = $this->model_common_home->getBestSellers();
        $bestseller = array();
        foreach($results as $product) {
            $bestseller[] = array(
                'product_id'   => $product['product_id'],
                'name'   => $product['name'],
                'total'   => $product['total'],
                'edit'   => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id='.$product['product_id'], 'SSL')
            );
        }

        $this->data['bestseller'] = $bestseller;

        $results = $this->model_common_home->getLessSellers();
        $lessseller = array();
        foreach($results as $product) {
            $lessseller[] = array(
                'product_id'   => $product['product_id'],
                'name'   => $product['name'],
                'total'   => $product['total'],
                'edit'   => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id='.$product['product_id'], 'SSL')
            );
        }

        $this->data['lessseller'] = $lessseller;

        $results = $this->model_common_home->getMostViewed();
        $viewed = array();
        foreach($results as $product) {
            $viewed[] = array(
                'product_id'   => $product['product_id'],
                'name'   => $product['name'],
                'total'   => $product['viewed'],
                'edit'   => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id='.$product['product_id'], 'SSL')
            );
        }

        $this->data['viewed'] = $viewed;

        $this->load->model('localisation/currency');

        $currency = $this->model_localisation_currency->getCurrencyByCode($this->config->get('config_currency'));
        $this->data['symbol_left'] = $currency['symbol_left'];
        $this->data['symbol_right'] = $currency['symbol_right'];

        $this->load->model('sale/customer');

        $this->data['total_customer'] = $this->model_sale_customer->getTotalCustomers();
        $this->data['total_customer_approval'] = $this->model_sale_customer->getTotalCustomersAwaitingApproval();

        $this->load->model('catalog/review');

        $this->data['total_review'] = $this->model_catalog_review->getTotalReviews();
        $this->data['total_review_approval'] = $this->model_catalog_review->getTotalReviewsAwaitingApproval();

        $this->load->model('sale/affiliate');

        $this->data['total_affiliate'] = $this->model_sale_affiliate->getTotalAffiliates();
        $this->data['total_affiliate_approval'] = $this->model_sale_affiliate->getTotalAffiliatesAwaitingApproval();

        $this->load->model('sale/order');

        $this->data['total_sale'] = $this->currency->format($this->model_sale_order->getTotalSales(), $this->config->get('config_currency'));
        $this->data['total_sale_year'] = $this->currency->format($this->model_sale_order->getTotalSalesByYear(date('Y')), $this->config->get('config_currency'));
        $this->data['total_order'] = $this->model_sale_order->getTotalOrders();

        // Last 5 Orders
		$this->data['orders'] = array();

		$filter_data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);

		$results = $this->model_sale_order->getOrders($filter_data);

		foreach ($results as $result) {
			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'view'       => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL'),
			);
		}


        # links
        $this->data['link_review_waiting'] =  $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&sort=r.status&order=ASC', 'SSL');
        $this->data['link_customer_waiting'] =  $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');
        $this->data['link_customers'] =  $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_sales'] =  $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_orders'] =  $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_affiliates'] =  $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['link_affiliate_waiting'] =  $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');

        $this->template = 'common/home.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
	}

    public function login() {
   		$route = '';

   		if (isset($this->request->get['route'])) {
   			$part = explode('/', $this->request->get['route']);

   			if (isset($part[0])) {
   				$route .= $part[0];
   			}

   			if (isset($part[1])) {
   				$route .= '/' . $part[1];
   			}
   		}

   		$ignore = array(
   			'common/login',
   			'common/forgotten',
   			'common/reset'
   		);

   		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
   			return $this->forward('common/login');
   		}

   		if (isset($this->request->get['route'])) {
   			$ignore = array(
   				'common/login',
   				'common/logout',
   				'common/forgotten',
   				'common/reset',
   				'error/not_found',
   				'error/permission'
   			);

   			$config_ignore = array();

   			if ($this->config->get('config_token_ignore')) {
   				$config_ignore = unserialize($this->config->get('config_token_ignore'));
   			}

   			$ignore = array_merge($ignore, $config_ignore);

   			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
   				return $this->forward('common/login');
   			}
   		} else {
   			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
   				return $this->forward('common/login');
   			}
   		}
   	}

   	public function permission() {
   		if (isset($this->request->get['route'])) {
   			$route = '';

   			$part = explode('/', $this->request->get['route']);

   			if (isset($part[0])) {
   				$route .= $part[0];
   			}

   			if (isset($part[1])) {
   				$route .= '/' . $part[1];
   			}

   			$ignore = array(
   				'common/home',
   				'common/login',
   				'common/logout',
   				'common/forgotten',
   				'common/reset',
   				'error/not_found',
   				'error/permission'
   			);

   			if (!in_array($route, $ignore) && !$this->user->hasPermission('access', $route)) {
   				return $this->forward('error/permission');
   			}
   		}
   	}

    # Ajax Functions
    /**********************************************************************************************************************/

    public function orders() {
    	$this->load->language('common/home');

        $json = $this->getChartData('getOrders');
        $json['order']['label'] = $this->language->get('text_order');

        $this->response->setOutput(json_encode($json));
    }

    public function customers() {
        $this->load->language('common/home');
        $this->load->model('common/home');

        $json = $this->getChartData('getCustomers');
        $json['order']['label'] = $this->language->get('text_customer');

        $this->response->setOutput(json_encode($json));
    }

    public function sales() {
        $this->load->language('common/home');
        $this->load->model('common/home');

        $json = $this->getChartData('getSales', true);
        $json['order']['label'] = $this->language->get('text_sale');

        $this->response->setOutput(json_encode($json));
    }

    public function affiliates() {
        $this->load->language('common/home');
        $this->load->model('common/home');

        $json = $this->getChartData('getAffiliates');
        $json['order']['label'] = $this->language->get('text_affiliates');

        $this->response->setOutput(json_encode($json));
    }

    public function reviews() {
        $this->load->language('common/home');
        $this->load->model('common/home');

        $json = $this->getChartData('getReviews');
        $json['order']['label'] = $this->language->get('text_reviews');

        $this->response->setOutput(json_encode($json));
    }

    public function rewards() {
        $this->load->language('common/home');
        $this->load->model('common/home');

        $json = $this->getChartData('getRewards');
        $json['order']['label'] = $this->language->get('text_rewards');

        $this->response->setOutput(json_encode($json));
    }

    public function getChartData($modelFunction, $currency_format = false ) {
        $this->load->model('common/home');

        $json   = array();
        $start  = MRequest::getCmd('start', '');
        $end    = MRequest::getCmd('end', '');

        $date_start = date_create($start)->format('Y-m-d H:i:s');
        $date_end   = date_create($end)->format('Y-m-d H:i:s');

        $diff_str   = strtotime($end) - strtotime($start);
        $diff       = floor($diff_str/3600/24) + 1;

        $range = $this->getRange($diff);

        switch ($range) {
            case 'hour':
                $results    = $this->model_common_home->{$modelFunction}($date_start, $date_end, 'HOUR');
                $order_data = array();

                for ($i = 0; $i < 24; $i++) {
                    $order_data[$i] = array(
                        'hour' => $i,
                        'total' => 0
                    );

                    $json['xaxis'][] = array($i, $i . ':00');
                }

                foreach ($results->rows as $result) {
                    $order_data[$result['hour']] = array(
                        'hour' => $result['hour'],
                        'total' => $result['total']
                    );
                }

                foreach ($order_data as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }

                break;
            default:
            case 'day':
                $results    = $this->model_common_home->{$modelFunction}($date_start, $date_end, 'DAY');
                $str_date   = substr($date_start, 0, 10);
                $order_data = array();

                for ($i = 0; $i < $diff; $i++) {
                    $date = date_create($str_date)->modify('+'.$i.' day')->format('Y-m-d');

                    $order_data[$date] = array(
                        'day' => $date,
                        'total' => 0
                    );

                    $json['xaxis'][] = array($i, $date);
                }

                foreach ($results->rows as $result) {
                    $total = $result['total'];
                    if($currency_format) {
                        $total = $this->currency->format($result['total'], $this->config->get('config_currency'), '', false);
                    }

                    $order_data[$result['date']] = array(
                        'day' => $result['date'],
                        'total' => $total
                    );
                }

                $i = 0;
                foreach ($order_data as $key => $value) {
                    $json['order']['data'][] = array($i++, $value['total']);
                }

                break;
            case 'month':
                $results    = $this->model_common_home->{$modelFunction}($date_start, $date_end, 'MONTH');
                $months     = $this->getMonths($date_start,$date_end);
                $order_data = array();

                for ($i = 0; $i < count($months); $i++) {
                    $order_data[$months[$i]] = array(
                        'month' => $months[$i],
                        'total' => 0
                    );

                    $json['xaxis'][] = array($i, $months[$i]);
                }

                foreach ($results->rows as $result) {
                    $order_data[$result['month']] = array(
                        'month' => $result['month'],
                        'total' => $result['total']
                    );
                }

                $i = 0;
                foreach ($order_data as $key => $value) {
                    $json['order']['data'][] = array($i++, $value['total']);
                }
                break;
            case 'year':
                $results    = $this->model_common_home->{$modelFunction}($date_start, $date_end, 'YEAR');
                $str_date   = substr($date_start, 0, 10);
                $order_data = array();
                $diff       = floor($diff/365)+1;

                for ($i = 0; $i < $diff; $i++) {
                    $date = date_create($str_date)->modify('+'.$i.' year')->format('Y');

                    $order_data[$date] = array(
                        'year' => $date,
                        'total' => 0
                    );

                    $json['xaxis'][] = array($i, $date);
                }

                foreach ($results->rows as $result) {
                    $order_data[$result['year']] = array(
                        'year' => $result['year'],
                        'total' => $result['total']
                    );
                }

                $i = 0;
                foreach ($order_data as $key => $value) {
                    $json['order']['data'][] = array($i++, $value['total']);
                }
                break;
        }

        $modelFunction  = str_replace('get', 'getTotal', $modelFunction);
        $result         = $this->model_common_home->{$modelFunction}($date_start, $date_end);

        $total = $result['total'];
        if($currency_format) {
            $total = $this->currency->format($result['total'], $this->config->get('config_currency'));
        }

        $json['order']['total'] = $total;

        return $json;
    }

    # extra functions
    ######################################################################################################################################################
    function getMonths($date1, $date2) {
       $time1  = strtotime($date1);
       $time2  = strtotime($date2);
       $my     = date('n-Y', $time2);
       $mesi = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
       //$mesi = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');

       $months = array();
       $f      = '';

       while($time1 < $time2) {
          if(date('n-Y', $time1) != $f) {
             $f = date('n-Y', $time1);
             if(date('n-Y', $time1) != $my && ($time1 < $time2)) {
                 $str_mese=$mesi[(date('n', $time1)-1)];
                $months[] = $str_mese." ".date('Y', $time1);
             }
          }
          $time1 = strtotime((date('Y-n-d', $time1).' +15days'));
       }

       $str_mese=$mesi[(date('n', $time2)-1)];
       $months[] = $str_mese." ".date('Y', $time2);
       return $months;
    }

    public function getRange($diff){
        if (isset($this->request->get['range']) and !empty($this->request->get['range']) and $this->request->get['range'] != 'undefined' ){
            $range = $this->request->get['range'];
        }
        else {
            $range = 'day';
        }

        if($diff < 365 and $range == 'year') {
            $range = 'month';
        }

        if( $diff < 28 ) {
            $range = 'day';
        }

        if($diff == 1) {
            $range = 'hour';
        }

        return $range;
    }

}
