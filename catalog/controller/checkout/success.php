<?php 
class ControllerCheckoutSuccess extends Controller { 
	public function index() { 
		$this->load->language( 'checkout/checkout' );
		
		// text
		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_total_all'] = $this->language->get('text_total_all');
		$this->data['text_back_home'] = $this->language->get('text_back_home');
		$this->data['text_order_success'] = $this->language->get('text_order_success');
		
		// link
		$this->data['home'] = HTTP_SERVER;
		
		if (isset($this->session->data['order_id'])) {
			// products
			$this->data['products'] = array();
			if ( $this->cart->hasProducts() ) {
				$this->load->model('tool/image');
				foreach ($this->cart->getProducts() as $product) {
					if ($product['image'] && file_exists(DIR_IMAGE . $product['image'])) {
						$image = $this->model_tool_image->resize($product['image'], 80, 80);
					} else {
						$image = $this->model_tool_image->resize('no_image.jpg', 80, 80);
					}
					$this->data['products'][] = array(
						'product_id' => $product['product_id'],
						'price' => $this->currency->format($product['price']),
						'name' => $product['name'],
						'image' => $image,
						'quantity' => $product['quantity'],
						'subtotal' => $this->currency->format($product['price']*$product['quantity']),
						'model' => $product['model']
						);
				}
				$this->data['total'] = $this->currency->format($this->cart->getTotal());
			}
			$this->data['total'] = $this->currency->format($this->cart->getTotal());
			$this->data['order_id'] = $this->session->data['order_id'];
		
			$this->cart->clear();
			
			/*unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);*/
			
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
  			if (isset($this->session->data['checkout_note']))
  				unset($this->session->data['checkout_note']);
		}	
		
		$this->document->setTitle($this->language->get('heading_title'));
									   
		/*$this->language->load('checkout/success');
		
		$this->data['breadcrumbs'] = array(); 

      	$this->data['breadcrumbs'][] = array(
        	'href'      => HTTP_SERVER,
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 
		
      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/cart'),
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);
				
		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	
					
      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/success'),
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
    		$this->data['text_message'] = sprintf($this->language->get('text_customer'), HTTP_SERVER . 'thong-tin-tai-khoan', $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
    		$this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}
		
    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = HTTP_SERVER;*/

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/success.tpl';
		} else {
			$this->template = 'default/template/checkout/success.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'			
		);
				
		$this->response->setOutput($this->render());
  	}
}
?>