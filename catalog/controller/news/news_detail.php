<?php  
class ControllerNewsNewsDetail extends Controller {
	private $error = array(); 
	
	private $limit = 10;
	
	private $langauge_id = 2;
	
	public function index() {
		$this->language->load('news/news_detail');
		
		// warning
		$this->data['warning_add_fv'] 		= $this->language->get('warning_add_fv');
		$this->data['warning_not_add_fv'] 	= $this->language->get('warning_not_add_fv');
		
		//---------------------- *load model* -----------------------
		$this->load->model('news/category');
		$this->load->model('news/news');
		$this->load->model('news/comment');
		//-------------------- *end load model* ---------------------

		$news_id = 1;
		
		if (isset($this->request->get['news_id'])){
			$news_id = $this->request->get['news_id'];
		}
		
		$page = 1;
		
		if (isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		
		$news = $this->model_news_news->getNews($news_id, $this->langauge_id);
		
		// add comment
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post) && $news) {
			$this->model_news_comment->addComment($news_id, $this->request->post);
			
			$this->redirect(HTTP_SERVER . $news['keyword']);
		}
		// end add comment
		
		$category_infor = $this->model_news_category->getCategoryById($news['news_category_id']);
		
		$text_category = $category_infor['category_name'];
		
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => HTTP_SERVER,			
			'separator' => false
		);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $text_category,
			'href'      => HTTP_SERVER . $category_infor['keyword'],			
			'separator' => $this->language->get('text_seperator')
		);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => (utf8_strlen($news['title']) > 50) ? (utf8_substr($news['title'], 0, 50) . '...') : $news['title'] ,
			'href'      => HTTP_SERVER . $news['keyword'],
			'separator' => $this->language->get('text_seperator')
		);
		
		$this->load->model('news/comment');
		if ($news) {
			$this->data['news'] = $news;
			
			$this->data['totalcomment'] = $this->model_news_comment->getTotalComment(array('news_id' => $news['news_id']));
		}

		/* customer */
		if ($this->customer->isLogged()) {
			$this->data['customer_inf'] = array(
				'id' => $this->customer->getId(),
				'firstname' => $this->customer->getFirstName(),
				'lastname' => $this->customer->getLastName(),
				'writen' => $this->model_news_comment->getTotalComment(array('customer_id' => $this->customer->getID()))
			);
		}
		/* end customer_inf */

		/* text */
		$this->document->setTitle($news['title']);
		
		$this->data['text_comment'] = 'Bình luận';
		$this->data['text_send'] = 'Gửi';
		$this->data['text_likes'] = 'Số lượt thích';
		$this->data['text_writen'] = 'Bài viết';
		$this->data['text_wait'] = $this->language->get('text_wait');
		/* msg */
		$this->data['msg_follow'] = 'Theo dõi chủ đề này';
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news_detail.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/news_detail.tpl';
		} else {
			$this->template = 'default/template/news/news_detail.tpl';
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

	public function showcomment() {
		$this->load->model('news/comment');
		$this->load->model('account/customer');

		$this->data['comments'] = array();

		if (isset($this->request->get['news_id'])) {
			$totalcomment = $this->model_news_comment->getTotalComment(array('news_id' => $this->request->get['news_id']));

            $data_comment = array(
				'news_id' => $this->request->get['news_id'],
				'order' => 'news_comment_date_created',
				'sort' => 'DESC'
			);
			
			$comments = $this->model_news_comment->getComments( $data_comment );

			if ( 0 < count($comments) ){
				foreach ($comments as $comment) {
					$customer = $this->model_account_customer->getCustomer($comment['customer_id']);
					if (isset($customer['thumb_url']) && $customer['thumb_url'] != '' && file_exists(DIR_IMAGE . $customer['thumb_url'])) {
						$customer['thumb_url'] = 'image/' . $customer['thumb_url'];
					}else {
						$customer['thumb_url'] = 'image/no_avatar.jpg';
					}
					$this->data['comments'][] = array(
						'id' => $comment['news_comment_id'],
						'content' => $comment['news_comment_content'],
						'date' => date('h:i:s d/m/Y', $comment['news_comment_date_created']),
						'customer' => $customer
					);
				}
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/comment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/comment.tpl';
		} else {
			$this->template = 'default/template/news/comment.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function writecomment() {
		$this->load->language('news/news_detail');

		$json = array();

		if (isset($this->request->post)) {
			if ($this->customer->isLogged()) {
				if ((utf8_strlen($this->request->post['content']) < 5) || (utf8_strlen($this->request->post['content']) > 500)) {
					$json['error'] = $this->language->get('error_content');
				}
			}else {
				$json['error'] = $this->language->get('error_not_login');
			}

			if (!isset($json['error'])) {
				$this->load->model('news/comment');
				$this->model_news_comment->addComment($this->request->get['news_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
				$json['totalcomment'] = $this->model_news_comment->getTotalComment(array('news_id' => $this->request->get['news_id']));
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>