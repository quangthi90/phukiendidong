<?php  
class ControllerCheckoutStep1 extends Controller { 
	public function index() {
		$this->language->load('checkout/checkout');
		
		$this->data['text_order_detail'] = $this->language->get('text_order_detail');
		$this->data['text_billing_infor'] = $this->language->get('text_billing_infor');
		$this->data['text_billing_infor2'] = $this->language->get('text_billing_infor2');
		$this->data['text_fullname'] = $this->language->get('text_fullname');
		$this->data['text_firstname'] = $this->language->get('text_firstname');
		$this->data['text_lastname'] = $this->language->get('text_lastname');
		$this->data['text_mobilephone'] = $this->language->get('text_mobilephone');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_street'] = $this->language->get('text_street');
		$this->data['text_ward'] = $this->language->get('text_ward');
		$this->data['text_district'] = $this->language->get('text_district');
		$this->data['text_province'] = $this->language->get('text_province');
		$this->data['text_choose_province'] = $this->language->get('text_choose_province');
		$this->data['text_note'] = $this->language->get('text_note');
		$this->data['text_continue'] = $this->language->get('text_continue');

		/*if (isset($this->session->data['fullname'])) {
			$this->data['fullname'] = $this->session->data['fullname'];
		}elseif ($this->customer->isLogged()) {
			$this->data['fullname'] = $this->customer->getLastName() . ' ' . $this->customer->getFirstName();
		}else {
			$this->data['fullname'] = '';
		}*/
		
		if (isset($this->session->data['firstname'])) {
			$this->data['firstname'] = $this->session->data['firstname'];
		}elseif ($this->customer->isLogged()) {
			$this->data['firstname'] = $this->customer->getFirstName();
		}else {
			$this->data['firstname'] = '';
		}
		
		if (isset($this->session->data['lastname'])) {
			$this->data['lastname'] = $this->session->data['lastname'];
		}elseif ($this->customer->isLogged()) {
			$this->data['lastname'] = $this->customer->getLastName();
		}else {
			$this->data['lastname'] = '';
		}

		if (isset($this->session->data['email'])) {
			$this->data['email'] = $this->session->data['email'];
		}elseif ($this->customer->isLogged()) {
			$this->data['email'] = $this->customer->getEmail();
		}else {
			$this->data['email'] = '';
		}

		if (isset($this->session->data['tel'])) {
			$this->data['tel'] = $this->session->data['tel'];
		}elseif ($this->customer->isLogged()) {
			$this->data['tel'] = $this->customer->getTelephone();
		}else {
			$this->data['tel'] = '';
		}

		if ( $this->customer->isLogged() ) {
			$this->load->model('account/address');
			$address = $this->model_account_address->getAddress( $this->customer->getAddressId() );
		}

		if (isset($this->session->data['address']['address'])) {
			$this->data['address'] = $this->session->data['address']['address'];
		}elseif ( $this->customer->isLogged() && !empty( $address ) ) {
			$this->data['address'] = $address['address_1'];
		}else {
			$this->data['address'] = '';
		}
		/*
		if (isset($this->session->data['street'])) {
			$this->data['street'] = $this->session->data['street'];
		}else {
			$this->data['street'] = '';
		}

		if (isset($this->session->data['district'])) {
			$this->data['district'] = $this->session->data['district'];
		}else {
			$this->data['district'] = '';
		}

		if (isset($this->session->data['ward'])) {
			$this->data['ward'] = $this->session->data['ward'];
		}else {
			$this->data['ward'] = '';
		}*/

		if (isset($this->session->data['address']['zone_id'])) {
			$this->data['city'] = $this->session->data['address']['zone_id'];
		}elseif ( $this->customer->isLogged() && !empty( $address ) ) {
			$this->data['city'] = (int)$address['zone_id'];
		}else {
			$this->data['city'] = 0;
		}

		if (isset($this->session->data['checkout_note'])) {
			$this->data['checkout_note'] = $this->session->data['checkout_note'];
		}else {
			$this->data['checkout_note'] = '';
		}

		// zone
		$this->load->model('localisation/zone');
		$this->data['zones'] = $this->model_localisation_zone->getZonesByCountryId(230);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/step1.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/step1.tpl';
		} else {
			$this->template = 'default/template/checkout/step1.tpl';
		}
				
		$this->response->setOutput($this->render());
	}
	
	public function validate() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}	
		
		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts();
				
		foreach ($products as $product) {
			$product_total = 0;
				
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}		
			
			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');
				
				break;
			}				
		}
				
		if (!$json) {
			// fullname
			/*if ((utf8_strlen($this->request->post['fullname']) < 1) || (utf8_strlen($this->request->post['fullname']) > 100)) {
				$json['error']['fullname'] = $this->language->get('error_fullname');
			}*/
			
			// firstname
			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 100)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}
			
			// lastname
			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 100)) {
				$json['error']['lastname'] = $this->language->get('error_lastname');
			}

			// tel
			if ((utf8_strlen($this->request->post['tel']) < 6) || (utf8_strlen($this->request->post['tel']) > 15)) {
				$json['error']['tel'] = $this->language->get('error_tel');
			}

			// email
			if (utf8_strlen($this->request->post['email']) < 6) {
				$json['error']['email'] = $this->language->get('error_email');
			}
				
			// address
			if (utf8_strlen($this->request->post['address']) < 3) {
				$json['error']['address'] = $this->language->get('error_address');
			}	
			
			// city
			if ($this->request->post['city'] == 0) {
				$json['error']['city'] = $this->language->get('error_zone');
			}
				
				if (!$json) {
					// Validate if customer is logged in.
					if (!$this->customer->isLogged()) {
						$json['error']['warning'] = $this->language->get('error_login_required');
					}

					//$this->session->data['fullname'] = $this->request->post['fullname'];
					$this->session->data['firstname'] = $this->request->post['firstname'];
					$this->session->data['lastname'] = $this->request->post['lastname'];
					$this->session->data['tel'] = $this->request->post['tel'];
					$this->session->data['email'] = $this->request->post['email'];
					$this->session->data['address']['address'] = $this->request->post['address'];
					$this->session->data['address']['zone_id'] = $this->request->post['city'];
					$this->session->data['address']['country_id'] = 230;

					$this->session->data['address']['fulladdress'] = $this->request->post['address'];
/*
					if (isset($this->request->post['street'])) {
						$this->session->data['street'] = $this->request->post['street'];
					}else {
						$this->session->data['street'] = '';
					}

					if ($this->session->data['street']) {
						$this->session->data['address']['fulladdress'] .= ', ' . $this->session->data['street'];
					}

					if (isset($this->request->post['ward'])) {
						$this->session->data['ward'] = $this->request->post['ward'];
					}else {
						$this->session->data['ward'] = '';
					}

					if ($this->session->data['ward']) {
						$this->session->data['address']['fulladdress'] .= ', ' . $this->session->data['ward'];
					}

					if (isset($this->request->post['district'])) {
						$this->session->data['district'] = $this->request->post['district'];
					}else {
						$this->session->data['district'] = '';
					}

					if ($this->session->data['district']) {
						$this->session->data['address']['fulladdress'] .= ', ' . $this->session->data['district'];
					}
*/
					if (isset($this->request->post['checkout_note'])) {
						$this->session->data['checkout_note'] = $this->request->post['checkout_note'];
					}else {
						$this->session->data['checkout_note'] = '';
					}

					//$this->session->data['payment_country_id'] = '230';
					//$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
				}				
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>