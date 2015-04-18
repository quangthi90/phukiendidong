<?php  
class ControllerCheckoutStep2 extends Controller { 
	public function index() {
		$this->language->load('checkout/checkout');
		
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_back'] = $this->language->get('text_back');
		$this->data['text_continue'] = $this->language->get('text_continue');
		$this->data['text_total_and_shipping_method'] = $this->language->get('text_total_and_shipping_method');

		$this->data['text_payment_method_1'] = $this->language->get('text_payment_method_1');
		$this->data['text_payment_method_1_description'] = $this->language->get('text_payment_method_1_description');
		$this->data['text_payment_method_2'] = $this->language->get('text_payment_method_2');
		$this->data['text_payment_method_2_description'] = $this->language->get('text_payment_method_2_description');

		// Shipping Methods
		if (isset($this->session->data['address'])) {
			$quote_data = array();
			
			$this->load->model('setting/extension');
			
			$results = $this->model_setting_extension->getExtensions('shipping');
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);
					
					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($this->session->data['address']); 
		
					if ($quote) {
						$quote_data[$result['code']] = array( 
							'title'      => $quote['title'],
							'quote'      => $quote['quote'][$result['code']], 
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}
	
			$sort_order = array();
		  
			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $quote_data);

			$this->session->data['shipping_methods'] = $quote_data;
		}

		if (isset($this->session->data['shipping_methods'])) {
			$this->data['shipping_methods'] = $this->session->data['shipping_methods'];
		}else {
			$this->data['shipping_methods'] = array();
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/step2.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/step2.tpl';
		} else {
			$this->template = 'default/template/checkout/step2.tpl';
		}
				
		$this->response->setOutput($this->render());
	}
	
	public function validate() {
		$this->language->load('checkout/checkout');
		
		$json = array();

		if (!isset($this->request->post['shipping-method'])) {
			$json['error']['shipping-method'] = $this->language->get('error_shipping_method');
		}

		if (!isset($this->request->post['payment-method'])) {
			$json['error']['payment-method'] = $this->language->get('error_payment_method');
		}

		if (!$json) {
			$this->session->data['shipping-method'] = $this->request->post['shipping-method'];
			$this->session->data['payment-method'] = $this->request->post['payment-method'];
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>