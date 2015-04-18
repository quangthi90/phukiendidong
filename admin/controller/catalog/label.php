<?php
class ControllerCatalogLabel extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/label');

		$this->load->model('catalog/label');

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/label');

		$this->load->model('catalog/label');

		// request
		if (isset($this->request->post) && $this->isValidateForm()) {
			$this->model_catalog_label->addLabel($this->request->post);

			// success message
			// redirect
			$this->redirect($this->url->link('catalog/label', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['action'] = $this->url->link('catalog/label/insert', 'token=' . $this->session->data['token'], 'SSL');

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/label');

		$this->load->model('catalog/label');

		// request
		if (isset($this->request->post) && $this->isValidateForm()) {
			$this->model_catalog_label->editLabel($this->request->get['label_id'], $this->request->post);

			// success message
			// redirect
			$this->redirect($this->url->link('catalog/label', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['action'] = $this->url->link('catalog/label/update', 'token=' . $this->session->data['token'] . '&label_id=' . $this->request->get['label_id'], 'SSl');

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/label');

		$this->load->model('catalog/label');

		// request
		if (isset($this->request->post['selected'])) {
			$this->model_catalog_label->deleteLabel(array('label_id' => $this->request->post['selected']));

			// success message
			// redirect
			$this->redirect($this->url->link('catalog/label', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->getList();
	}

	public function getList() {
		// error
		$this->data['error_warning'] = '';
		$this->data['success'] = '';

		// filter & sort url
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
			$page = $this->request->get['page'];
		}else {
			$page = 1;
		}

		// breadcrumbs
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/label', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);

   		// text
   		$this->data['text_enable'] = $this->language->get('text_enable');
   		$this->data['text_disable'] = $this->language->get('text_disable');
   		$this->data['text_no_results'] = $this->language->get('text_no_results');
   		// column
   		$this->data['column_title'] = $this->language->get('column_title');
   		$this->data['column_image'] = $this->language->get('column_image');
   		$this->data['column_status'] = $this->language->get('column_status');
   		$this->data['column_action'] = $this->language->get('column_action');
   		// button
   		$this->data['button_insert'] = $this->language->get('button_insert');
   		$this->data['button_delete'] = $this->language->get('button_delete');
   		// link
   		$this->data['insert'] = $this->url->link('catalog/label/insert', 'token=' . $this->session->data['token'], 'SSL');
   		$this->data['delete'] = $this->url->link('catalog/label/delete', 'token=' . $this->session->data['token'], 'SSL');

   		// filter data
   		$filter_data = array();
   		$filter_data['start'] = ($page - 1)*$this->config->get('config_admin_limit');
   		$filter_data['limit'] = $this->config->get('config_admin_limit');

   		// labels
   		$this->load->model('tool/image');
   		$this->data['labels'] = array();
   		$label_data = $this->model_catalog_label->getLabels($filter_data);
   		foreach ($label_data as $label) {
   			$action = array();
   			$action[] = array(
   				'text' => $this->language->get('text_edit'),
   				'href' => $this->url->link('catalog/label/update', 'token=' . $this->session->data['token'] . '&label_id=' . $label['label_id'], 'SSL')
   				);

   			if ($label['image'] && file_exists(DIR_IMAGE . $label['image'])) {
				$image = $this->model_tool_image->resize($label['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

   			$this->data['labels'][] = array(
   				'label_id' => $label['label_id'],
   				'title' => $label['title'],
   				'image' => $image,
   				'status' => $label['status'],
   				'action' => $action
   				);
   		}

   		$label_total = $this->model_catalog_label->getTotalLabels($filter_data);

   		// pagination url
   		$url = '';

   		// pagination
   		$pagination = new Pagination();
		$pagination->total = $label_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/label', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

   		// add child & render
		$this->template = 'catalog/label_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getForm() {
		// error
		$this->data['error_warning'] = '';
		$this->data['success'] = '';
		$this->data['error_title'] = '';
		$this->data['error_image'] = '';

		// breadcrumbs
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/label', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => ' :: '
   		);

   		// text
   		$this->data['text_enable'] = $this->language->get('text_enable');
   		$this->data['text_disable'] = $this->language->get('text_disable');
   		$this->data['text_browse'] = $this->language->get('text_browse');
   		$this->data['text_clear'] = $this->language->get('text_clear');
   		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
   		// entry
   		$this->data['entry_title'] = $this->language->get('entry_title');
   		$this->data['entry_image'] = $this->language->get('entry_image');
   		$this->data['entry_status'] = $this->language->get('entry_status');
   		// button
   		$this->data['button_save'] = $this->language->get('button_save');
   		$this->data['button_cancel'] = $this->language->get('button_cancel');
   		// link
   		$this->data['cancel'] = $this->url->link('catalog/label', 'token=' . $this->session->data['token'], 'SSL');
   		$this->data['token'] = $this->session->data['token'];

   		// languages
   		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		// label
		if (isset($this->request->get['label_id'])) {
			$label_data = $this->model_catalog_label->getLabel($this->request->get['label_id']);
		}

		if (isset($this->request->post['label_description'])) {
			$this->data['label_description'] = $this->request->post['label_description'];
		}elseif (isset($label_data)) {
			$this->data['label_description'] = $label_data['label_description'];
		}else {
			$this->data['label_description'] = array();
		}

		$this->load->model('tool/image');
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['image'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($label_data) && $label_data['image'] && file_exists(DIR_IMAGE . $label_data['image'])) {
			$this->data['image'] = $this->model_tool_image->resize($label_data['image'], 100, 100);
		} else {
			$this->data['image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

   		// add child & render
		$this->template = 'catalog/label_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function isValidateForm() {
		$error = array();

		if (isset($this->request->post)) {
			if (isset($this->request->post['label_description']) && (count($this->request->post['label_description']) > 0)) {
				foreach ($this->request->post['label_description'] as $label_description) {
					if (!isset($label_description['title']) || !($label_description['title'])) {
						$error['error_description'] = $this->language->get('error_description');
					}
				}
			}else {
				$error['error_description'] = $this->language->get('error_description');
			}

			if (!isset($this->request->post['image']) || !($this->request->post['image'])) {
				$error['error_image'] = $this->language->get('error_image');
			}
		}

		if (count($error) > 0) {
			return false;
		}else {
			return true;
		}
	}
}