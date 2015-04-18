<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		$this->data['text_home'] = $this->language->get('text_home');
		
		if (isset($this->request->get['filter_name'])) {
			$this->data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$this->data['filter_name'] = '';
		}

		$this->data['success'] = '';
		$this->data['error_warning'] = '';
		if (isset($this->session->data['error_newsletter_register'])) {
			$this->data['error_warning'] = $this->session->data['error_newsletter_register'];
			unset($this->session->data['error_newsletter_register']);
		}
		if (isset($this->session->data['success_newsletter_register'])) {
			$this->data['success'] = $this->session->data['success_newsletter_register'];
			unset($this->session->data['success_newsletter_register']);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
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