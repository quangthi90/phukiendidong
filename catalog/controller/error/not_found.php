<?php   
class ControllerErrorNotFound extends Controller {
	public function index() {
		$this->document->setTitle($this->language->get('heading_title'));
				
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}

		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
		    $this->data['icon'] = $server . $this->config->get('config_icon');
		} else {
		    $this->data['icon'] = '';
		}
		$this->data['name'] = $this->config->get('config_name');
	
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
		    $this->data['logo'] = $server . $this->config->get('config_logo');
		} else {
		    $this->data['logo'] = '';
		}
		
		$this->data['home'] = HTTP_SERVER;
		
		$this->language->load('error/not_found');
		$this->data['heading_title'] = $this->language->get('heading_title');		
		$this->data['text_error'] = $this->language->get('text_error');
				
		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
		} else {
			$this->template = 'default/template/error/not_found.tpl';
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