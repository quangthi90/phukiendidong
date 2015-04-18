<?php
class ControllerAccountNewsletterRegister extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');
		$this->load->model('account/newsletter');

		if (isset($this->request->post['email'])) {
			if ($this->isCustomer()) {
				$this->model_account_customer->editNewsletterByEmail($this->request->post['email']);
				$this->session->data['success_newsletter_register'] = 'Đăng kí thành công';
			}elseif ($this->isValidate()) {
				$this->model_account_newsletter->addNewsletter($this->request->post['email']);
				$this->session->data['success_newsletter_register'] = 'Đăng kí thành công';
			}else {
				$this->session->data['error_newsletter_register'] = 'Email Không hợp lệ hoặc đã đăng kí';
			}
			$this->redirect(HTTP_SERVER);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/newsletter_register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mail/newsletter_register.tpl';
		} else {
			$this->template = 'default/template/mail/newsletter_register.tpl';
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

	public function isValidate() {
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ($this->model_account_newsletter->getNewsletter($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}

    	if (count($this->error) > 0) {
    		return false;
    	}else {
    		return true;
    	}
	}

	public function isCustomer() {
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if (!$this->model_account_customer->getCustomerByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}

    	if (count($this->error) > 0) {
    		return false;
    	}else {
    		return true;
    	}
	}
}