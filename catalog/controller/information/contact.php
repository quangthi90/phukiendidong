<?php 
class ControllerInformationContact extends Controller {
	private $error = array(); 
	    
  	public function index() {
		$this->language->load('information/contact');

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => HTTP_SERVER,        	
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => HTTP_SERVER . 'lien-he',
        	'separator' => $this->language->get('text_separator')
      	);	
      	
      	$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('http://maps.googleapis.com/maps/api/js?sensor=false&language=vi');
		$this->document->addScript('catalog/view/javascript/googlemap.js');	
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	$this->data['text_location'] = $this->language->get('text_location');
        $this->data['text_contact'] = $this->language->get('text_contact');
        $this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_telephone'] = $this->language->get('text_telephone');
    	$this->data['text_fax'] = $this->language->get('text_fax');
    	$this->data['text_email'] = $this->language->get('text_email');
    	$this->data['text_login_warning'] = 'Đăng nhập để hiện thị form gửi mail';

    	$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_title'] = $this->language->get('entry_title');
    	$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');
		
		$this->data['button_submit'] = $this->language->get('button_submit');
		$this->data['button_reset'] = $this->language->get('button_reset');
		
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}		
		
		if (isset($this->error['enquiry'])) {
			$this->data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$this->data['error_enquiry'] = '';
		}		
		
 		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}	

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
  		if (isset($this->request->post['title'])) {
			$this->data['title'] = $this->request->post['title'];
		} else {
			$this->data['title'] = '';
		}
		
		if (isset($this->request->post['content'])) {
			$this->data['content'] = $this->request->post['content'];
		} else {
			$this->data['content'] = '';
		}

		if ($this->customer->isLogged()) {
			$this->data['customer_info'] = $this->customer->isLogged();
			$this->data['email'] = $this->customer->getEmail();
		}else {
			$this->data['customer_info'] = '';
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()){
			$this->load->model('sale/contact');
			
			if (!$this->customer->isLogged()) {
		  		$this->session->data['redirect'] = HTTP_SERVER . 'thong-tin-tai-khoan';
		  
		  		$this->redirect(HTTP_SERVER . 'dang-nhap');
    		} 
    		
    		$this->request->post['customer_id'] = $this->customer->getId();
    		
			if ($this->model_sale_contact->addContact($this->request->post))
			{
				$this->data['success'] = $this->language->get('text_message');
				$this->data['content'] = "";
				$this->data['title'] = "";
			}
			else 
				$this->data['success'] = $this->language->get('text_error');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/contact.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/contact.tpl';
		} else {
			$this->template = 'default/template/information/contact.tpl';
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

  	public function success() {
		$this->language->load('information/contact');

		$this->document->setTitle($this->language->get('heading_title')); 

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => HTTP_SERVER,
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/contact'),
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_message'] = $this->language->get('text_message');

    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = HTTP_SERVER;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
  	private function validate() {
    	if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((utf8_strlen($this->request->post['content']) < 10) || (utf8_strlen($this->request->post['content']) > 3000)) {
      		$this->error['enquiry'] = $this->language->get('error_enquiry');
    	}

    	if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
      		$this->error['captcha'] = $this->language->get('error_captcha');
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  	  
  	}
}
?>
