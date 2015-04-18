<?php  
class ControllerModulehotnews extends Controller {
	private $language_id = 2;
	private $limit = 9;
	
	protected function index($setting) {
		static $module = 0;
		if (isset($setting['limit'])) {
			$this->limit = $setting['limit'];
		}

		//------------------- *load language* --------------------
		$this->language->load('module/hotnews');
		$this->data['heading_title'] = $this->language->get('heading_title');
		//------------------ *end load language* -----------------  

		
		//------------------- *load model* --------------------
		$this->load->model('news/category');
		$this->load->model('news/news');
		$this->load->model('tool/image');
		//---------------- *end load model* -------------------
		
		
		//------------------- *get list Categories* --------------------
		$results = $this->model_news_category->getCategories(array('is_leaf' => 1)); // List categories
		
		$this->data['news_categories'] = array(); // Danh sách tin tức theo danh mục
		
		$this->data['categories'] = array();
		
		$this->data['newses'] = array();
		
		foreach ($results as $result){
			if ( $result['news_category_id'] == 22 ){
				continue;
			}

			$result = $this->model_news_category->getCategoryById( $result['news_category_id'] );
			
			$this->data['categories'][] = array(
				'id'		=> $result['news_category_id'],
				'name'		=> $result['category_name'],
				'href' 		=> HTTP_SERVER . $result['keyword']
			);
			
			$data = array(	
					'filter_category_id' 	=> $result['news_category_id'],
					'sort'					=> 'news_created_date',
					'order'					=> 'DESC',
					'start'					=> 0,
					'limit'					=> $this->limit
			);
			
			$newses = $this->model_news_news->getNewses($data);
			
			if ( count($newses) == 0 ){
				continue;
			}
			
			$this->data['newses'][$result['news_category_id']] = array();
			
			foreach ($newses as $i => $news){
				$news = $this->model_news_news->getNews($news['news_id']);
				
				if ( $news['news_image_url'] && file_exists(DIR_IMAGE . $news['news_image_url']) ){
					$image = $this->model_tool_image->resize($news['news_image_url'], 310, 200);
				}else{
					$image = $this->model_tool_image->resize('no_image.jpg', 310, 200);
				}

//				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query='news_category_id=" . $this->db->escape($category['news_category_id']) . "'");
//            	$keyword = $query->row['keyword'];
				
				$this->data['newses'][$result['news_category_id']][] = array(
					'id'			=> $news['news_id'],
					'title'			=> $news['title'],
					'description'	=> $news['meta_description'],
					'image'			=> $image,
					'href'			=> HTTP_SERVER . $news['keyword']
				);
			}
		}
		//---------------- *end get list Category* -------------------
		
		$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/hotnews.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/hotnews.tpl';
		} else {
			$this->template = 'default/template/module/hotnews.tpl';
		}
		
		$this->render();
	}
}
?>