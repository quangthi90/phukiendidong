<?php  
class ControllerModuleSameNews extends Controller {	
	private $limit = 10;
	
	protected function index($setting) {
		static $module = 0;
		if (isset($setting['limit'])) {
			$this->limit = $setting['limit'];
		}

		//------------------- *load language* --------------------
		//$this->language->load('module/samenews');
		//$this->data['heading_title'] = $this->language->get('heading_title');
		//------------------ *end load language* -----------------  
		
		//------------------- *load model* --------------------
		$this->load->model('news/category');
		$this->load->model('news/news');
		$this->load->model('tool/image');
		//---------------- *end load model* -------------------
		
		// current news
		$curr_news_id = 0;	
		if ( isset($this->request->get['news_id']) ){
			$curr_news_id = $this->request->get['news_id'];
		}
		

		if ( $curr_news_id != 0 ){
			$curr_news = $this->model_news_news->getNews( $curr_news_id );
			
			// Get current category ID
			$parts = explode('/', $curr_news['keyword']);
			
			$parts = explode('-', $parts[0]);
			
			$curr_news_category_id = $parts[count($parts) - 1];
			
			// list same news
			$data_same_news = array(
				'filter_category_id' => $curr_news_category_id,
				'order' => 'news_created_date',
				'sort' => 'DESC',
				'start' => 0,
				'limit' => $this->limit,
			);
		}else{
			$curr_news_category_id = 0;
			if ( isset($this->request->get['news_category_id']) ){
				$curr_news_category_id = $this->request->get['news_category_id'];
			}
			
			if ( $curr_news_category_id == 0 ){
				$data_same_news = array(
					'order' => 'news_created_date',
					'sort' => 'DESC',
					'start' => 0,
					'limit' => $this->limit,
				);
			}else{
				$data_same_news = array(
					'filter_category_id' => $curr_news_category_id,
					'order' => 'news_created_date',
					'sort' => 'DESC',
					'start' => 0,
					'limit' => $this->limit,
				);
			}
		}
		
		$newses = $this->model_news_news->getNewses( $data_same_news );

		$this->data['newses'] = array();
		foreach ($newses as $news) {
			// Get news detail & keyword
			$news = $this->model_news_news->getNews( $news['news_id'] );
			
            if ($news['news_image_url'] && file_exists(DIR_IMAGE . $news['news_image_url'])) {
            	$image = $this->model_tool_image->resize($news['news_image_url'], 60, 70);
            } else {
                $image = $this->model_tool_image->resize('no_ad_image.jpg', 60, 70);
            }

            $this->data['newses'][] = array(
                'id' => $news['news_id'],
                'title' => $news['title'],
                'description' => $news['meta_description'],
                'image' => $image,
                'href' => HTTP_SERVER . $news['keyword'],
                'created' => date('h:i A - d/m/Y', $news['news_created_date'])
            );
        }
		
		$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/samenews.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/samenews.tpl';
		} else {
			$this->template = 'default/template/module/samenews.tpl';
		}
		
		$this->render();
	}
}
?>