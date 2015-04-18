<?php 
class ControllerAccountActive extends Controller {
	public function index() {
    	if ($this->customer->isLogged()) {
      		$this->customer->logout();	
    	}
    	
    	$customer_id = 0;
    	
    	if (isset($this->request->get['customer_id'])){
    		$customer_id = $this->request->get['customer_id'];
    	}
    	
    	if ($customer_id != 0){
    		$this->load->model('account/customer');
    		
    		$this->model_account_customer->activeAccount($customer_id);
 
	    	$this->language->load('account/active');
			
			$this->document->setTitle($this->language->get('heading_title'));
	      	
			$this->data['breadcrumbs'] = array();
	
	      	$this->data['breadcrumbs'][] = array(
	        	'text'      => $this->language->get('text_home'),
				'href'      => HTTP_SERVER,        	
	        	'separator' => false
	      	);
	      	
			$this->data['breadcrumbs'][] = array(
	        	'text'      => $this->language->get('text_account'),
				'href'      => HTTP_SERVER . 'thong-tin-tai-khoan',       	
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
    	}else{
    		$this->redirect(HTTP_SERVER);
    	}
  	}
}
?>