<?php  
class ControllerCheckoutStep3 extends Controller { 
	public function index() {
		$this->language->load('checkout/checkout');

		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_user_infor'] = $this->language->get('text_user_infor');
		$this->data['text_fullname'] = $this->language->get('text_fullname');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_mobilephone'] = $this->language->get('text_mobilephone');
		$this->data['text_shipping_addr'] = $this->language->get('text_shipping_addr');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_cart_infor'] = $this->language->get('text_cart_infor');
		$this->data['text_cart_edit'] = $this->language->get('text_cart_edit');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_total_all'] = $this->language->get('text_total_all');
		$this->data['text_back'] = $this->language->get('text_back');
		$this->data['text_done'] = $this->language->get('text_done');
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_continue_checkout'] = $this->language->get('text_continue_checkout');
		
		$this->data['link_cart'] = $this->url->link( 'checkout/cart' );
		$this->data['link_product'] = $this->url->link( 'product/product' );

		if (isset($this->session->data['firstname']) && isset($this->session->data['lastname'])) {
			$this->data['fullname'] = $this->session->data['firstname'] . ' ' . $this->session->data['lastname'];
		}else {
			$this->data['fullname'] = '';
		}

		if (isset($this->session->data['tel'])) {
			$this->data['tel'] = $this->session->data['tel'];
		}else {
			$this->data['tel'] = '';
		}

		if (isset($this->session->data['email'])) {
			$this->data['email'] = $this->session->data['email'];
		}else {
			$this->data['email'] = '';
		}

		if (isset($this->session->data['address']['fulladdress'])) {
			$this->data['address'] = $this->session->data['address']['fulladdress'];
		}else {
			$this->data['address'] = '';
		}

		if (isset($this->session->data['shipping-method'])) {
			foreach ($this->session->data['shipping_methods'] as $key => $value) {
				if ($this->session->data['shipping-method'] == $key) {
					$this->data['shipping_method'] = $this->session->data['shipping_methods'][$key];
					break;
				}
			}
		}else {
			$this->data['shipping_method'] = array();
		}

		if (isset($this->session->data['payment-method'])) {
			$this->data['payment_method'] = $this->session->data['payment-method'];
		}else {
			$this->data['payment_method'] = '';
		}

		// products
		$this->load->model('tool/image');
		$this->data['products'] = array();
		foreach ($this->cart->getProducts() as $product) {
			if ($product['image'] && file_exists(DIR_IMAGE . $product['image'])) {
				$image = $this->model_tool_image->resize($product['image'], 80, 80);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 80, 80);
			}
			$this->data['products'][] = array(
				'product_id' => $product['product_id'],
				'price' => $this->currency->format($product['price']),
				'image' => $image,
				'name' => $product['name'],
				'quantity' => $product['quantity'],
				'subtotal' => $this->currency->format($product['price']*$product['quantity']),
				'model' => $product['model']
				);
		}
		$this->data['total'] = $this->currency->format($this->cart->getTotal());

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/step3.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/step3.tpl';
		} else {
			$this->template = 'default/template/checkout/step3.tpl';
		}
				
		$this->response->setOutput($this->render());
	}
	
	public function confirm() {
		$json = array();

  		$data = array();

		if (!$this->customer->isLogged()) {
			$json['redirect'] = 'index.php?route=account/login';
		}else {
			$data['customer_id'] = $this->customer->getId();
			$data['customer_group_id'] = $this->customer->getCustomerGroupId();
			$data['firstname'] = $this->customer->getFirstName();
			$data['lastname'] = $this->customer->getLastName();
			$data['email'] = $this->customer->getEmail();
			$data['telephone'] = $this->customer->getTelephone();
			$data['fax'] = $this->customer->getFax();
		}

		if (!$this->cart->hasProducts()) {
			$json['redirect'] = 'index.php?route=checkout/cart';
		}else {
			$product_data = array();
		
				foreach ($this->cart->getProducts() as $product) {
					$option_data = array();
	
					foreach ($product['option'] as $option) {
						if ($option['type'] != 'file') {
							$value = $option['option_value'];	
						} else {
							$value = $this->encryption->decrypt($option['option_value']);
						}	
					
						$option_data[] = array(
							'product_option_id'       => $option['product_option_id'],
							'product_option_value_id' => $option['product_option_value_id'],
							'option_id'               => $option['option_id'],
							'option_value_id'         => $option['option_value_id'],								   
							'name'                    => $option['name'],
							'value'                   => $value,
							'type'                    => $option['type']
						);					
					}
	 
					$product_data[] = array(
						'product_id' => $product['product_id'],
						'name'       => $product['name'],
						'model'      => $product['model'],
						'option'     => $option_data,
						'download'   => $product['download'],
						'quantity'   => $product['quantity'],
						'subtract'   => $product['subtract'],
						'price'      => $product['price'],
						'total'      => $product['total'],
						'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
						'reward'     => $product['reward']
					); 
				}
		}

		if (!isset($this->session->data['firstname'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}
		
		if (!isset($this->session->data['lastname'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}

  		if (!isset($this->session->data['tel'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}
  		
  		if (!isset($this->session->data['email'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}
  		
  		if (!isset($this->session->data['address']['address'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}
  		
  		if (!isset($this->session->data['address']['zone_id'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}else {
  			$this->load->model('localisation/zone');
  			$zone_data = $this->model_localisation_zone->getZone($this->session->data['address']['zone_id']);
  		}

  		if (!isset($this->session->data['shipping-method'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}else {
  			foreach ($this->session->data['shipping_methods'] as $key => $value) {
				if ($this->session->data['shipping-method'] == $key) {
					$shipping_method = $this->session->data['shipping_methods'][$key];
					break;
				}
			}
  		}

  		if (!isset($this->session->data['payment-method'])) {
  			$json['redirect'] = 'index.php?route=checkout/checkout';
  		}

		if (!$json) {
			$this->load->model('localisation/country');
  			$country_data = $this->model_localisation_country->getCountry(230);

  			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
  			$data['store_id'] = $this->config->get('config_store_id');
  			$data['store_name'] = $this->config->get('config_name');
  			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTP_SERVER;	
			}

			$data['payment_firstname'] = $this->customer->getFirstName();
  			$data['payment_lastname'] = $this->customer->getLastName();
  			$data['payment_company'] = '';
  			$data['payment_company_id'] = '';
  			$data['payment_tax_id'] = $this->customer->getFax();
  			$data['payment_address_1'] = $this->session->data['address']['fulladdress'];
  			$data['payment_address_2'] = '';
  			$data['payment_city'] = $zone_data['name'];
  			$data['payment_postcode'] = '';
  			$data['payment_country'] = $country_data['name'];
  			$data['payment_country_id'] = $country_data['country_id'];
  			$data['payment_zone'] = $zone_data['name'];
  			$data['payment_zone_id'] = $zone_data['zone_id'];
  			$data['payment_address_format'] = '';
  			$data['payment_method'] = $this->session->data['payment-method'];
  			$data['payment_code'] = '';

  			$data['shipping_firstname'] = $this->session->data['firstname'];
  			$data['shipping_lastname'] = $this->session->data['lastname'];
  			$data['shipping_company'] = '';
  			$data['shipping_address_1'] = $this->session->data['address']['fulladdress'];
  			$data['shipping_address_2'] = '';
  			$data['shipping_city'] = $zone_data['name'];
  			$data['shipping_postcode'] = '';
  			$data['shipping_country'] = $country_data['name'];
  			$data['shipping_country_id'] = $country_data['country_id'];
  			$data['shipping_zone_id'] = $zone_data['zone_id'];
  			$data['shipping_zone'] = $zone_data['name'];
  			$data['shipping_address_format'] = '';
  			$data['shipping_method'] = $shipping_method['title'];
  			$data['shipping_code'] = $shipping_method['quote']['code'];

  			if (isset($this->session->data['checkout_note'])) {
  				$data['comment'] = $this->session->data['checkout_note'];
  			}else {
  				$data['comment'] = '';
  			}

  			$total_data = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();
			 
				$this->load->model('setting/extension');
			
				$sort_order = array(); 
			
				$results = $this->model_setting_extension->getExtensions('total');
			
				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}
			
				array_multisort($sort_order, SORT_ASC, $results);
			
				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
		
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}
			
				$sort_order = array(); 
		  
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
	
				array_multisort($sort_order, SORT_ASC, $total_data);

  				$data['total'] = $total;
  				if (isset($this->request->cookie['tracking'])) {
					$this->load->model('affiliate/affiliate');
				
					$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
				
					if ($affiliate_info) {
						$data['affiliate_id'] = $affiliate_info['affiliate_id']; 
						$data['commission'] = ($total / 100) * $affiliate_info['commission']; 
					} else {
						$data['affiliate_id'] = 0;
						$data['commission'] = 0;
					}
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}
  				$data['language_id'] = $this->config->get('config_language_id');
  				$data['currency_id'] = $this->currency->getId();
  				$data['currency_code'] = $this->currency->getCode();
  				$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
  				$data['ip'] = $this->request->server['REMOTE_ADDR'];
  				if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
					$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
				} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
					$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
				} else {
					$data['forwarded_ip'] = '';
				}
  				if (isset($this->request->server['HTTP_USER_AGENT'])) {
					$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];	
				} else {
					$data['user_agent'] = '';
				}
  				if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
					$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];	
				} else {
					$data['accept_language'] = '';
				}

				// Gift Voucher
				$voucher_data = array();
			
				if (!empty($this->session->data['vouchers'])) {
					foreach ($this->session->data['vouchers'] as $voucher) {
						$voucher_data[] = array(
							'description'      => $voucher['description'],
							'code'             => substr(md5(mt_rand()), 0, 10),
							'to_name'          => $voucher['to_name'],
							'to_email'         => $voucher['to_email'],
							'from_name'        => $voucher['from_name'],
							'from_email'       => $voucher['from_email'],
							'voucher_theme_id' => $voucher['voucher_theme_id'],
							'message'          => $voucher['message'],						
							'amount'           => $voucher['amount']
						);
					}
				}  

  				$data['products'] = $product_data;
  				$data['vouchers'] = $voucher_data;
  				$data['totals'] = $total_data;

  				$this->load->model('checkout/order');
  				$this->session->data['order_id'] = $this->model_checkout_order->addOrder($data);
  				//$this->model_checkout_order->confirm($this->session->data['order_id'], 1);
  				
  				/*$this->cart->clear();
  				if (isset($this->session->data['fullname']))
  					unset($this->session->data['fullname']);
  				if (isset($this->session->data['tel']))
  					unset($this->session->data['tel']);
  				if (isset($this->session->data['email']))
  					unset($this->session->data['email']);
  				if (isset($this->session->data['address']))
  					unset($this->session->data['address']);
  				if (isset($this->session->data['shipping-method']))
  					unset($this->session->data['shipping-method']);
  				if (isset($this->session->data['payment-method']))
  					unset($this->session->data['payment-method']);
  				if (isset($this->session->data['street']))
  					unset($this->session->data['street']);
  				if (isset($this->session->data['ward']))
  					unset($this->session->data['ward']);
  				if (isset($this->session->data['district']))
  					unset($this->session->data['district']);
  				if (isset($this->session->data['checkout_note']))
  					unset($this->session->data['checkout_note']);*/

  			$json['redirect'] = 'index.php?route=checkout/success';
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function updateCart() {
		$json = array();
		if ( $this->customer->isLogged() ) {
			if ( isset( $this->request->get['product_id'] ) && isset( $this->request->get['quantity'] ) ) {
				$this->load->model( 'catalog/product' );
				$product = $this->model_catalog_product->getProduct( $this->request->get['product_id'] );
				if ( isset( $product['product_id'] ) ) {
					$this->cart->update( $this->request->get['product_id'], (int)$this->request->get['quantity'] );
					$json['status'] = 'success';
					$json['quantity'] = (int)$this->request->get['quantity'];
					$json['subtotal'] = $this->currency->format($product['price']*$json['quantity']);
					$json['total'] = $this->currency->format($this->cart->getTotal());
				}else {
					$json['status'] = 'failed';
				}
			}else {
				$json['status'] = 'failed';
			}
		}else {
			$json['redirect'] = 'index.php?route=account/login';
		}

		$this->response->setOutput( json_encode( $json ) );
	}

	public function reloadCart() {
		if ( $this->cart->hasProducts() ) {
			$this->load->language( 'checkout/checkout' );
			$i = 1; 
			foreach ($this->cart->getProducts() as $product) {
				echo '<tr>';
		      	echo '<td valign="top" align="center" class="item">' . $i++ . '</td>';
			  	echo '<td valign="top" class="item">' . $product['name'] . '</td>';		  
			  	echo '<td valign="top" align="right" class="item">' . $this->currency->format($product['price']) . '</td>';
			  	echo '<td valign="top" align="center" class="item">' . $product['quantity'] . '</td>';
			  	echo '<td valign="top" align="right" class="item">' . $this->currency->format($product['price']*$product['quantity']) . '</td>';
		    	echo '</tr>';
			}
			echo '<tr>';
			echo '<td align="right" class="item total-all" colspan="6">' . $this->language->get('text_total_all') . ' = <span id="total-all">' . $this->currency->format($this->cart->getTotal()) . '</span></td>';
			echo '</tr>';
		}else {
			echo '<tr>';
			echo '<td align="right" class="item total-all" colspan="6">' . $this->language->get('text_empty_cart') . '</td>';
			echo '</tr>';
		}
	}
}
?>