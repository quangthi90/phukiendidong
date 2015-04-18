<?php 
class ControllerNewsCategory extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_category->editCategory($this->request->get['news_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_category_id) {
				$this->model_news_category->deleteCategory($news_category_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		$language = $this->config->get('config_language_id');
		
		
		//---------------------------- *Thanh điều hướng* ----------------------------
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('advertisement/advertisement', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		//-------------------------- *end Thanh điều hướng* --------------------------
		

   		//---------------------------- *Add link button* ----------------------------
		$this->data['insert'] = $this->url->link('news/category/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('news/category/delete', 'token=' . $this->session->data['token'], 'SSL');
		//-------------------------- *end Add link button* --------------------------
		
		
		//---------------------------- *get list News Category* ----------------------------
		$this->data['categories'] = array();
		
		$results = $this->model_news_category->getAllCategories();

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/category/update', 'token=' . $this->session->data['token'] . '&news_category_id=' . $result['news_category_id'], 'SSL')
			);
			
			$parent_name = 'Root';
			
			if ($result['parent_id'] != 0){
				$parent = $this->model_news_category->getCategoryById($result['parent_id']);
				
				$parent = $parent[$language];
				
				$parent_name = $parent['category_name'];
				
				if ($parent['status'] == 0 && $result['status'] == 1){
					$this->model_news_category->deleteCategory($result['news_category_id']);
					
					$this->getList();
					
					break;
				}
			}
			
			
			//---------------------------- *get language* ----------------------------
			$this->data['text_enabled'] = $this->language->get('text_enabled');
	    	$this->data['text_disabled'] = $this->language->get('text_disabled');
			//-------------------------- *end get language* --------------------------

	    	
			$this->data['categories'][] = array(
				'news_category_id' => $result['news_category_id'],
				'name'        => $result['category_name'],
				'parent_name' => $parent_name,
				'status'  	  => $result['status'] == 1 ? $this->data['text_enabled'] : $this->data['text_disabled'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['news_category_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		//-------------------------- *end get list News Category* --------------------------
		
		
		//---------------------------- *get language* ----------------------------
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_parent'] = $this->language->get('column_parent');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 		//-------------------------- *end get language* --------------------------
 
		
		//---------------------------- *get warning* ----------------------------
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		//-------------------------- *end get warning* --------------------------
		
		
		$this->template = 'news/category_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->load->model('localisation/language');
		
		//$language = $this->model_localisation_language->getLanguageByCode($this->config->get('config_admin_language'));
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');	
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
    					
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_is_leaf'] = $this->language->get('entry_is_leaf');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');		
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('advertisement/advertisement', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['news_category_id'])) {
			$this->data['action'] = $this->url->link('news/category/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['category_forcus'] = $this->request->get['news_category_id'];
			$this->data['action'] = $this->url->link('news/category/update', 'token=' . $this->session->data['token'] . '&news_category_id=' . $this->request->get['news_category_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['news_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$temp = $this->model_news_category->getCategoryById($this->request->get['news_category_id']);
      		
      		foreach ($temp as $a){
	      		if ($this->config->get('config_language_id') == $a['language_id'])
	      			$category_info = $a;
      		}
    	}
    	
		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (!empty($category_info)) {
			$category_description = $this->model_news_category->getCategoryDescriptions($category_info['news_category_id']);
			foreach ($category_description as $value) {
    			$this->data['category_description'][$value['language_id']] = $value; 
    		}
		} else {
			$this->data['category_description'] = array();
		}
    	
    	$categories = $this->model_news_category->getAllCategories();
    	    	
    	$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		// Remove own id from list
		if (!empty($category_info)) {
			foreach ($categories as $key => $category) {
				if ($category['news_category_id'] == $category_info['news_category_id']) {
					unset($categories[$key]);
				}
			}
		}

		$this->data['categories'] = $categories;
		
		if (isset($this->request->post['category_name'])) {
			$this->data['category_name'] = $this->request->post['category_name'];
		} elseif (!empty($category_info)) {
			$this->data['category_name'] = $category_info['category_name'];
		} else {
			$this->data['category_name'] = '';
		}
		
		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$this->data['parent_id'] = $category_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
		
		if (isset($this->request->post['is_leaf'])) {
			$this->data['is_leaf'] = $this->request->post['is_leaf'];
		} elseif (!empty($category_info)) {
			$this->data['is_leaf'] = $category_info['is_leaf'];
		} else {
			$this->data['is_leaf'] = '';
		}
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($category_info)) {
			$this->data['keyword'] = $category_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
				
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$this->data['sort_order'] = $category_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$this->data['status'] = $category_info['status'];
		} else {
			$this->data['status'] = 1;
		}
				
		$this->template = 'news/category_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'news/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}
?>