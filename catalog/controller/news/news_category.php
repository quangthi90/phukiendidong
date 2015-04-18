<?php

class ControllerNewsNewsCategory extends Controller {

    private $error = array();
    private $language_id = 2;
    private $limit = 10;

    public function index() {
        //---------------------- *load language* -----------------------
        $this->language->load('news/news_category');
        //-------------------- *end load language* ---------------------
        //---------------------- *load model* -----------------------
        $this->load->model('news/category');
        $this->load->model('news/news');
        $this->load->model('tool/image');
        //-------------------- *end load model* ---------------------

        $this->load->model('setting/setting');
        $limit_setting = $this->model_setting_setting->getSetting('limit_setting');
        if (isset($limit_setting['news_category_limit']))
        $this->limit = $limit_setting['news_category_limit'];

        $this->document->setTitle($this->language->get('heading_title'));
        
        $page = 0;
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        }

        $category_id = 0;
        if ( isset($this->request->get['news_category_id']) ) {
            $category_id = $this->request->get['news_category_id'];
        }

        $category = $this->model_news_category->getCategoryById( $category_id );

        if ($category) {

            // breadcrumbs
            $this->data['breadcrumbs'] = array();
            
            if ( $category['parent_id'] != 0){
                $parent = $category;
                do {
                    $parent = $this->model_news_category->getCategoryById( $parent['parent_id'] );
                    
                    array_unshift($this->data['breadcrumbs'], array(
                        'text' => $parent['category_name'],
                        'href' => HTTP_SERVER . $parent['keyword'],
                        'separator' => true
                    ));
                } while ( $parent['parent_id'] != 0 );
            }

            array_unshift($this->data['breadcrumbs'], array(
                'text' => $this->language->get('text_home'),
                'href' => HTTP_SERVER,
                'separator' => false,
            ));

            $this->data['breadcrumbs'][] = array(
                'text' => $category['category_name'],
                'href' => HTTP_SERVER . $category['keyword'],
                'separator' => true
            );
            // end breadcrumbs

            // news
            $newses = $this->model_news_news->getNewses( array( 
                'category' => $category,
                'start' => ($page - 1) * $this->limit,
                'limit' => $this->limit,
                'order' => 'news_created_date',
                'sort' => 'DESC',
            ));

            $this->data['newses'] = array();
            foreach ($newses as $news) {
            	$news = $this->model_news_news->getNews( $news['news_id'] );
            	
                if ($news['news_image_url'] && file_exists(DIR_IMAGE . $news['news_image_url'])) {
                    $image = $this->model_tool_image->resize($news['news_image_url'], 162, 123);
                } else {
                    $image = $this->model_tool_image->resize('no_ad_image.jpg', 162, 123);
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

            $total_news = $this->model_news_news->getTotalNews(array(
                'category' => $category,
            ));

            $pagination = new Pagination();
            $pagination->total = $total_news;
            $pagination->page = $page;
            $pagination->limit = $this->limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = HTTP_SERVER . $category['keyword'] . '/page={page}';
            $this->data['pagination'] = $pagination->render();
            
            $this->data['result'] = sprintf($this->language->get('results'), $category["category_name"], $total_news);
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news_category.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/news/news_category.tpl';
        } else {
            $this->template = 'default/template/news/news_category.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

}
?>