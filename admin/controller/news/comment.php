<?php 
class ControllerNewsComment extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('news/comment');
		$this->document->setTitle($this->language->get('heading_title')); 
		$this->load->model('news/news');
		$this->load->model('news/comment');
		$this->load->model('sale/customer');

		$this->getList();
  	}

  	public function insert() {
		$this->load->language('news/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/comment');
		$this->load->model('news/news');
		$this->load->model('sale/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_comment->addComment($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

  	public function delete() { 
		$this->load->language('news/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/comment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			$this->model_news_comment->deleteComment($this->request->post['selected']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function update() {
		$this->load->language('news/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/comment');
		$this->load->model('news/news');
		$this->load->model('sale/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_comment->editComment($this->request->get['news_comment_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
			
		if (isset($this->request->get['news_comment_id'])) {
			$this->model_news_comment->setReviewComment($this->request->get['news_comment_id']);
		}

		$this->getForm();
	}

  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nc.news_comment_date_created';
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
			'href'      => $this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('news/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('news/comment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['comments'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$comment_total = $this->model_news_comment->getTotalComments();
	
		$results = $this->model_news_comment->getComments($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/comment/update', 'token=' . $this->session->data['token'] . '&news_comment_id=' . $result['news_comment_id'] . $url, 'SSL')
			);
						
			$this->data['comments'][] = array(
				'comment_id'  => $result['news_comment_id'],
				'title'       => $result['title'],
				'customer'     => $result['firstname'],
				'review' => $result['news_comment_review'],
				'status'     => ($result['news_comment_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_created' => date('d/m/Y', $result['news_comment_date_created']),
				'selected'   => isset($this->request->post['selected']) && in_array($result['review_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_news'] = $this->language->get('column_news');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_created'] = $this->language->get('column_date_created');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_news'] = $this->url->link('news/comment', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('news/comment', 'token=' . $this->session->data['token'] . '&sort=c.firstname' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('news/comment', 'token=' . $this->session->data['token'] . '&sort=nc.status' . $url, 'SSL');
		$this->data['sort_date_created'] = $this->url->link('news/comment', 'token=' . $this->session->data['token'] . '&sort=nc.date_created' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'news/comment_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

  	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');

		$this->data['entry_news'] = $this->language->get('entry_news');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_content'] = $this->language->get('entry_content');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['news'])) {
			$this->data['error_news'] = $this->error['error_news'];
		} else {
			$this->data['error_news'] = '';
		}
		
 		if (isset($this->error['customer'])) {
			$this->data['error_customer'] = $this->error['customer'];
		} else {
			$this->data['error_customer'] = '';
		}
		
 		if (isset($this->error['content'])) {
			$this->data['error_content'] = $this->error['content'];
		} else {
			$this->data['error_content'] = '';
		}

		$url = '';
			
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
			'href'      => $this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

   		// entry
   		$this->data['news'] = $this->model_news_news->getNews();
   		$this->data['customers'] = $this->model_sale_customer->getCustomers();
										
		if (!isset($this->request->get['news_comment_id'])) { 
			$this->data['action'] = $this->url->link('news/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/comment/update', 'token=' . $this->session->data['token'] . '&news_comment_id=' . $this->request->get['news_comment_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/comment', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['news_comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$comment_info = $this->model_news_comment->getComment($this->request->get['news_comment_id']);
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['news_id'])) {
			$this->data['news_id'] = $this->request->post['news_id'];
		} elseif (!empty($comment_info)) {
			$this->data['news_id'] = $comment_info['news_id'];
		} else {
			$this->data['news_id'] = '';
		}
				
		if (isset($this->request->post['customer_id'])) {
			$this->data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($comment_info)) {
			$this->data['customer_id'] = $comment_info['customer_id'];
		} else {
			$this->data['customer_id'] = '';
		}

		if (isset($this->request->post['content'])) {
			$this->data['content'] = $this->request->post['content'];
		} elseif (!empty($comment_info)) {
			$this->data['content'] = $comment_info['news_comment_content'];
		} else {
			$this->data['content'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$this->data['status'] = $comment_info['news_comment_status'];
		} else {
			$this->data['status'] = '';
		}

		$this->template = 'news/comment_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'news/comment')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['content']) < 1) {
			$this->error['content'] = $this->language->get('error_content');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function autocomplete() {
		/*$json = array();
		
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

		$this->response->setOutput(json_encode($json));*/
	}
}
?>