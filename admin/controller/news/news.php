<?php 
class ControllerNewsNews extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('news/news');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('news/news');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('news/news');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('news/news');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news->addNew($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . $this->request->get['filter_model'];
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('news/news');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news->editNew($this->request->get['news_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('news/news');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->deleteNew($news_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
	  		if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
	  		if (isset($this->request->get['filter_created'])) {
				$url .= '&filter_created=' . $this->request->get['filter_created'];
			}
			
	  		if (isset($this->request->get['filter_updated'])) {
				$url .= '&filter_updated=' . $this->request->get['filter_updated'];
			}
			
	  		if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
  	
	public function recovery() {
    	$this->load->language('news/news');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (isset($this->request->post['selected']) && $this->validateRecovery()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->recoveryNew($news_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
	  		if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
	  		if (isset($this->request->get['filter_created'])) {
				$url .= '&filter_created=' . $this->request->get['filter_created'];
			}
			
	  		if (isset($this->request->get['filter_updated'])) {
				$url .= '&filter_updated=' . $this->request->get['filter_updated'];
			}
			
	  		if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	private function getList() {				
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
  		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
  		if (isset($this->request->get['filter_created'])) {
			$filter_created = $this->request->get['filter_created'];
		} else {
			$filter_created = null;
		}
		
  		if (isset($this->request->get['filter_updated'])) {
			$filter_updated = $this->request->get['filter_updated'];
		} else {
			$filter_updated = null;
		}
		
  		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'news_created_date';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
  		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
  		if (isset($this->request->get['filter_created'])) {
			$url .= '&filter_created=' . $this->request->get['filter_created'];
		}
		
  		if (isset($this->request->get['filter_updated'])) {
			$url .= '&filter_updated=' . $this->request->get['filter_updated'];
		}
		
  		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['filter_url'] = $url;

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('advertisement/advertisement', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('news/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['recovery'] = $this->url->link('news/news/recovery', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('news/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['news'] = array();

		$data = array(
			'filter_name'	  		=> $filter_name,
			'filter_category_id' 	=> $filter_category, 
			'filter_status'   		=> $filter_status,
			'filter_created'   		=> $filter_created == null ? null : strtotime($filter_created),
			'filter_updated'   		=> $filter_updated == null ? null : strtotime($filter_updated),
			'sort'            		=> $sort,
			'order'           		=> $order,
			'start'           		=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           		=> $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');
		
		$news_total = $this->model_news_news->getTotalNews($data);
			
		$results = $this->model_news_news->getNews($data);
			    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL')
			);
			
			if ($result['news_image_url'] && file_exists(DIR_IMAGE . $result['news_image_url'])) {
				$image = $this->model_tool_image->resize($result['news_image_url'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
			
			if (isset($this->request->post['created_date'])) {
	       		$created = date('d-m-Y', $this->request->post['created_date']);
			} elseif (!empty($result['news_created_date'])) {
				$created = date('d-m-Y', $result['news_created_date']);
			} else {
				$created = date('d-m-Y', time() - 86400);
			}
			
			if (isset($this->request->post['updated_date'])) {
	       		$updated = date('d-m-Y', $this->request->post['updated_date']);
			} elseif (!empty($result['news_updated_date'])) {
				$updated = date('d-m-Y', $result['news_updated_date']);
			} else {
				$updated = date('d-m-Y', time() - 86400);
			}
			
      		$this->data['news'][] = array(
				'news_id' => $result['news_id'],
				'name'       => $result['title'],
				'image'      => $image,
      			'category'   => $result['category_name'],
				'status'     => ($result['news_status'] == 1 ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'created'    => $created,
      			'updated'    => $updated,
      			'special'	 => $result['special'] == 1 ? $this->language->get('text_true') : $this->language->get('text_false'),
				'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');		
			
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_name'] = $this->language->get('column_name');		
		$this->data['column_category'] = $this->language->get('column_category');		
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_created_date'] = $this->language->get('column_created_date');
		$this->data['column_updated_date'] = $this->language->get('column_updated_date');		
		$this->data['column_special'] = $this->language->get('column_special');
		$this->data['column_action'] = $this->language->get('column_action');		
				
		$this->data['button_recovery'] = $this->language->get('button_recovery');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		 
 		$this->data['token'] = $this->session->data['token'];
		
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
		
  		if (isset($this->request->post['filter_created'])) {
       		$this->data['created_date'] = date('d-m-Y', $this->request->post['filter_created']);
		} else {
			$this->data['created_date'] = '';
		}
		
  		if (isset($this->request->post['filter_updated'])) {
       		$this->data['updated_date'] = date('d-m-Y', $this->request->post['filter_updated']);
		} else {
			$this->data['updated_date'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
  		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
  		if (isset($this->request->get['filter_created'])) {
			$url .= '&filter_created=' . $this->request->get['filter_created'];
		}
		
  		if (isset($this->request->get['filter_updated'])) {
			$url .= '&filter_updated=' . $this->request->get['filter_updated'];
		}
		
  		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_name'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
		$this->data['sort_category'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=category_name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=news_status' . $url, 'SSL');
		$this->data['sort_created'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=news_created_date' . $url, 'SSL');
		$this->data['sort_updated'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=news_updated_date' . $url, 'SSL');
		$this->data['sort_special'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=special' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
  		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
  		if (isset($this->request->get['filter_created'])) {
			$url .= '&filter_created=' . $this->request->get['filter_created'];
		}
		
  		if (isset($this->request->get['filter_updated'])) {
			$url .= '&filter_updated=' . $this->request->get['filter_updated'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_category'] = $filter_category;
		$this->data['filter_created'] = $filter_created;
		$this->data['filter_updated'] = $filter_updated;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->load->model('news/category');
		$this->data['all_categories'] = $this->model_news_category->getAllCategories();
				
		$this->template = 'news/news_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
    	$this->data['heading_title'] 				= $this->language->get('heading_title');
 
    	$this->data['text_enabled'] 				= $this->language->get('text_enabled');
    	$this->data['text_disabled'] 				= $this->language->get('text_disabled');
		$this->data['text_true']	 				= $this->language->get('text_true');		
		$this->data['text_false']	 				= $this->language->get('text_false');
    	$this->data['text_none'] 					= $this->language->get('text_none');
    	$this->data['text_yes'] 					= $this->language->get('text_yes');
    	$this->data['text_no'] 						= $this->language->get('text_no');
		$this->data['text_select_all'] 				= $this->language->get('text_select_all');
		$this->data['text_unselect_all'] 			= $this->language->get('text_unselect_all');
		$this->data['text_plus'] 					= $this->language->get('text_plus');
		$this->data['text_minus'] 					= $this->language->get('text_minus');
		$this->data['text_default'] 				= $this->language->get('text_default');
		$this->data['text_image_manager'] 			= $this->language->get('text_image_manager');
		$this->data['text_browse'] 					= $this->language->get('text_browse');
		$this->data['text_clear'] 					= $this->language->get('text_clear');
		$this->data['text_option'] 					= $this->language->get('text_option');
		$this->data['text_option_value'] 			= $this->language->get('text_option_value');
		$this->data['text_select'] 					= $this->language->get('text_select');
		$this->data['text_none'] 					= $this->language->get('text_none');
		$this->data['text_percent'] 				= $this->language->get('text_percent');
		$this->data['text_amount'] 					= $this->language->get('text_amount');

		$this->data['entry_name'] 					= $this->language->get('entry_name');
		$this->data['entry_meta_description'] 		= $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] 			= $this->language->get('entry_meta_keyword');
		$this->data['entry_tag_keyword'] 			= $this->language->get('entry_tag_keyword');
		$this->data['entry_description'] 			= $this->language->get('entry_description');
		$this->data['entry_keyword'] 				= $this->language->get('entry_keyword');
		$this->data['entry_created_date'] 			= $this->language->get('entry_created_date');
    	$this->data['entry_updated_date'] 			= $this->language->get('entry_updated_date');
    	$this->data['entry_special']	 			= $this->language->get('entry_special');
    	$this->data['entry_image'] 					= $this->language->get('entry_image');
    	$this->data['entry_subimage'] 				= $this->language->get('entry_subimage');
    	$this->data['entry_category'] 				= $this->language->get('entry_category');
		$this->data['entry_status'] 				= $this->language->get('entry_status');
				
    	$this->data['button_save'] 					= $this->language->get('button_save');
    	$this->data['button_cancel'] 				= $this->language->get('button_cancel');
		$this->data['button_add_attribute'] 		= $this->language->get('button_add_attribute');
		$this->data['button_add_option'] 			= $this->language->get('button_add_option');
		$this->data['button_add_option_value'] 		= $this->language->get('button_add_option_value');
		$this->data['button_add_discount'] 			= $this->language->get('button_add_discount');
		$this->data['button_add_special'] 			= $this->language->get('button_add_special');
		$this->data['button_add_image'] 			= $this->language->get('button_add_image');
		$this->data['button_remove'] 				= $this->language->get('button_remove');
		
    	$this->data['tab_general'] 					= $this->language->get('tab_general');
    	$this->data['tab_data'] 					= $this->language->get('tab_data');
		 
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

 		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = array();
		}		
   
   		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}	

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('advertisement/advertisement', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('news/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_all_language = $this->model_news_news->getNew($this->request->get['news_id']);
      		
			foreach ($news_all_language as $temp){
	    		if ($temp['language_id'] == $this->config->get('config_language_id')){
	    			$new = $temp;
	    		}
	    	}
    	}
    	
  		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (!empty($new)) {
			$this->data['news_description'] = $this->model_news_news->getNewDescriptions($new['news_id']);
		} else {
			$this->data['news_description'] = array();
		}

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($new)) {
			$this->data['keyword'] = $new['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($new)) {
			$this->data['image'] = $new['news_image_url'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (!empty($new) && $new['news_image_url'] && file_exists(DIR_IMAGE . $new['news_image_url'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($new['news_image_url'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
    	if (isset($this->request->post['created_date'])) {
       		$this->data['created_date'] = date('d-m-Y h:i:s A', $this->request->post['created_date']);
		} elseif (!empty($new)) {
			$this->data['created_date'] = date('d-m-Y h:i:s A', $new['news_created_date']);
		} else {
			$this->data['created_date'] = date('d-m-Y h:i:s A', time());
		}
		
  		$this->data['updated_date'] = date('d-m-Y h:i:s A', time());
  		
  		if (isset($this->request->post['special'])) {
      		$this->data['special'] = $this->request->post['special'];
    	} else if (!empty($new)) {
			$this->data['special'] = $new['special'];
		} else {
      		$this->data['special'] = 1;
    	}
		
		if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} else if (!empty($new)) {
			$this->data['status'] = $new['news_status'];
		} else {
      		$this->data['status'] = 1;
    	}

    	$this->load->model('news/category');
				
		$this->data['categories'] = $this->model_news_category->getAllCategories();

		$this->data['news'] = isset($new) ? $new : null;
		
		$this->template = 'news/news_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'news/news')) {
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
    	if (!$this->user->hasPermission('modify', 'news/news')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	private function validateRecovery() {
    	if (!$this->user->hasPermission('modify', 'news/news')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('news/news');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'         => $filter_name,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_news_news->getNews($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'news_id' => $result['news_id'],
					'name'       => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>