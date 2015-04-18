<?php    
class ControllerSaleEmailManager extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->language('sale/contact');
		 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/contact');
		
    	$this->getList();
  	}

  	public function delete() {
		$this->load->language('sale/contact');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/contact');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $contact_id) {
				$this->model_sale_contact->deleteContact($contact_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_del_success');

			$url = '';

			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_contact_id'])) {
				$url .= '&filter_contact_id=' . $this->request->get['filter_contact_id'];
			}
			
			if (isset($this->request->get['filter_review'])) {
				$url .= '&filter_review=' . $this->request->get['filter_review'];
			}
			
			if (isset($this->request->get['filter_created_date'])) {
				$url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
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
			
			$this->redirect($this->url->link('sale/contact', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    
    	$this->getList();
  	}  
  	
  	public function update() {
		$this->load->language('sale/contact');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/contact');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_contact->sendReply($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

    		if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_contact_id'])) {
				$url .= '&filter_contact_id=' . $this->request->get['filter_contact_id'];
			}
			
			if (isset($this->request->get['filter_review'])) {
				$url .= '&filter_review=' . $this->request->get['filter_review'];
			}
			
			if (isset($this->request->get['filter_created_date'])) {
				$url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
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
			
			$this->redirect($this->url->link('sale/contact', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		
  		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset($this->request->get['filter_contact_id'])) {
			$filter_contact_id = $this->request->get['filter_contact_id'];
		} else {
			$filter_contact_id = null;
		}
				
		if (isset($this->request->get['filter_created_date'])) {
			$filter_created_date = $this->request->get['filter_created_date'];
		} else {
			$filter_created_date = null;
		}		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';

  		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}
			
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_contact_id'])) {
			$url .= '&filter_contact_id=' . $this->request->get['filter_contact_id'];
		}
			
		if (isset($this->request->get['filter_review'])) {
			$url .= '&filter_review=' . $this->request->get['filter_review'];
		}
			
		if (isset($this->request->get['filter_created_date'])) {
			$url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
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

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/email_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
   		
		$this->data['delete'] = $this->url->link('sale/email_manager/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['contacts'] = array();

		$data = array( 
			'filter_username'          => $filter_title, 
			'filter_email'             => $filter_email, 
			'filter_date_added'        => $filter_created_date,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$contact_total = $this->model_sale_contact->getTotalContacts($data);
	
		$results = $this->model_sale_contact->getContacts($data);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/email_manager/update', 'token=' . $this->session->data['token'] . '&contact_id=' . $result['contact_id'] . $url, 'SSL')
			);
			
			$this->data['contacts'][] = array(
				'contact_id'    	=> $result['contact_id'],
				'title'           	=> $result['contact_review'] ? $result['contact_title'] : '<b>' . $result['contact_title'] . '</b>',
				'email'          	=> $result['contact_email'],
				'customer' 			=> $result['lastname'] . ' ' . $result['firstname'],
				'review'         	=> ($result['contact_review'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'created'     		=> date('d/m/Y', $result['contact_created_date']),
				'selected'       	=> isset($this->request->post['selected']) && in_array($result['contact_id'], $this->request->post['selected']),
				'action'         	=> $action
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_select'] = $this->language->get('text_select');	
		$this->data['text_default'] = $this->language->get('text_default');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_review'] = $this->language->get('column_review');
		$this->data['column_created'] = $this->language->get('column_created');
		$this->data['column_action'] = $this->language->get('column_action');	
		
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
		
		$url = '';

  		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}
			
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_contact_id'])) {
			$url .= '&filter_contact_id=' . $this->request->get['filter_contact_id'];
		}
			
		if (isset($this->request->get['filter_review'])) {
			$url .= '&filter_review=' . $this->request->get['filter_review'];
		}
			
		if (isset($this->request->get['filter_created_date'])) {
			$url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'] . '&sort=contact_title' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'] . '&sort=contact_email' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'] . '&sort=customer_name' . $url, 'SSL');
		$this->data['sort_review'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'] . '&sort=contact_review' . $url, 'SSL');
		$this->data['sort_created_date'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'] . '&sort=contact_created_date' . $url, 'SSL');
		
		$url = '';

  		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}
			
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_contact_id'])) {
			$url .= '&filter_contact_id=' . $this->request->get['filter_contact_id'];
		}
			
		if (isset($this->request->get['filter_review'])) {
			$url .= '&filter_review=' . $this->request->get['filter_review'];
		}
			
		if (isset($this->request->get['filter_created_date'])) {
			$url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $contact_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_title'] = $filter_title;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_customer'] = $filter_customer;
		$this->data['filter_created_date'] = $filter_created_date;
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/email_manager_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
  
  	private function getForm() {
  		$this->data['heading_title'] 	= $this->language->get('heading_title');
 
    	$this->data['text_enabled'] 	= $this->language->get('text_enabled');
    	$this->data['text_disabled'] 	= $this->language->get('text_disabled');
		$this->data['text_select'] 		= $this->language->get('text_select');
    	$this->data['text_wait'] 		= $this->language->get('text_wait');
		$this->data['text_no_results'] 	= $this->language->get('text_no_results');
		$this->data['text_send'] 		= $this->language->get('text_send');
		
    	$this->data['entry_title'] 		= $this->language->get('entry_title');
    	$this->data['entry_content'] 	= $this->language->get('entry_content');
    	$this->data['entry_email'] 		= $this->language->get('entry_email');
    	$this->data['entry_customer'] 	= $this->language->get('entry_customer');
		$this->data['entry_created'] 	= $this->language->get('entry_created');
		$this->data['entry_reply'] 		= $this->language->get('entry_reply');
 
		$this->data['button_save'] 		= $this->language->get('button_save');
    	$this->data['button_cancel'] 	= $this->language->get('button_cancel');
    	$this->data['button_remove'] 	= $this->language->get('button_remove');
	
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['contact_id'])) {
			$this->data['contact_id'] = $this->request->get['contact_id'];
			
			$this->model_sale_contact->reviewed($this->data['contact_id']);
		} else {
			$this->data['contact_id'] = 0;
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

 		if (isset($this->error['content'])) {
			$this->data['error_content'] = $this->error['content'];
		} else {
			$this->data['error_content'] = '';
		}
	
		$url = '';
		
  		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}
			
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_contact_id'])) {
			$url .= '&filter_contact_id=' . $this->request->get['filter_contact_id'];
		}
			
		if (isset($this->request->get['filter_review'])) {
			$url .= '&filter_review=' . $this->request->get['filter_review'];
		}
			
		if (isset($this->request->get['filter_created_date'])) {
			$url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
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
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/email_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('sale/email_manager/update', 'token=' . $this->session->data['token'] . '&contact_id=' . $this->request->get['contact_id'] . $url, 'SSL');
		  
    	$this->data['cancel'] = $this->url->link('sale/email_manager', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	if (isset($this->request->get['contact_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$contact_info = $this->model_sale_contact->getContact($this->request->get['contact_id']);
    	}
			
    	if (isset($this->request->post['title'])) {
      		$this->data['title'] = $this->request->post['title'];
    	} elseif (isset($contact_info)) { 
			$this->data['title'] = $contact_info['contact_title'];
		} else {
      		$this->data['title'] = '';
    	}

    	if (isset($this->request->post['content'])) {
      		$this->data['content'] = $this->request->post['content'];
    	} elseif (isset($contact_info)) { 
			$this->data['content'] = $contact_info['contact_content'];
		} else {
      		$this->data['content'] = '';
    	}

    	if (isset($this->request->post['email'])) {
      		$this->data['email'] = $this->request->post['email'];
    	} elseif (isset($contact_info)) { 
			$this->data['email'] = $contact_info['contact_email'];
		} else {
      		$this->data['email'] = '';
    	}

    	if (isset($this->request->post['customer'])) {
      		$this->data['customer'] = $this->request->post['customer'];
    	} elseif (isset($contact_info)) { 
			$this->data['customer'] = $contact_info['lastname'] . ' ' . $contact_info['firstname'];
		} else {
      		$this->data['customer'] = '';
    	}
    	
  		if (isset($this->request->post['created'])) {
      		$this->data['created'] = $this->request->post['created'];
    	} elseif (isset($contact_info)) { 
			$this->data['created'] = $contact_info['contact_created_date'];
		} else {
      		$this->data['created'] = '';
    	}	
    	
    	if (isset($this->request->post['reply_content'])) {
      		$this->data['reply_content'] = $this->request->post['reply_content'];
    	} else {
      		$this->data['reply_content'] = '';
    	}	
    	
    	if (isset($this->request->post['reply_title'])) {
      		$this->data['reply_title'] = $this->request->post['reply_title'];
    	} else {
      		$this->data['reply_title'] = '';
    	}	
		
		$this->template = 'sale/email_manager_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
			 
  	private function validateForm() {
    	if (utf8_strlen($this->request->post['reply_title']) < 1) {
      		$this->error['title'] = $this->language->get('error_title');
    	}

    	if (utf8_strlen($this->request->post['reply_content']) < 100) {
      		$this->error['content'] = $this->language->get('error_content');
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/email_manager')) {
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
			$this->load->model('sale/contact');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
		
			$results = $this->model_sale_contact->getcontacts($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'contact_id'    => $result['contact_id'], 
					'name'           => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
					'contact_group' => $result['contact_group'],
					'title'      => $result['title'],
					'content'       => $result['content'],
					'email'          => $result['email'],
					'telephone'      => $result['telephone'],
					'fax'            => $result['fax'],
					'address'        => $this->model_sale_contact->getAddresses($result['contact_id'])
				);					
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}	
}
?>