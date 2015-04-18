<?php

class ControllerNewsSearch extends Controller {

    private $limit = 10;

    public function index() {
        //---------------------- *load language* -----------------------
        $this->language->load('news/search');
        //-------------------- *end load language* ---------------------
        //---------------------- *load model* -----------------------
        $this->load->model('news/news');
        $this->load->model('tool/image');
        //-------------------- *end load model* ---------------------

        $this->load->model('setting/setting');
        $limit_setting = $this->model_setting_setting->getSetting('limit_setting');
        if (isset($limit_setting['news_search_limit']))
        $this->limit = $limit_setting['news_search_limit'];

        $page = 0;

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        }
        
        $this->data['breadcrumbs'] = array();
        
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => HTTP_SERVER,         
            'separator' => false
        );
        
        $this->data['newses'] = array();
        $this->data['pagination'] = '';
        
        $key = '';
        if (isset($this->request->get['keyword'])) {
            $key = $this->request->get['keyword'];
        }
        
        if ( $key != '') {
            $this->document->setTitle(sprintf($this->language->get('title'), $key));
            
            $data_search = array(
                'filter_name' => $key,
            	'filter_status'	=> 1,
                'limit' => $this->limit,
                'start' => ($page - 1) * $this->limit,
                'sort' => 'news_created_date',
                'order' => 'DESC'
            );

            $results = $this->model_news_news->getNewses($data_search);

            foreach ($results as $result) {
                $news = $this->model_news_news->getNews($result['news_id']);

                if ($news['news_image_url'] && file_exists(DIR_IMAGE . $news['news_image_url'])) {
                    $image = $this->model_tool_image->resize($news['news_image_url'], 162, 123);
                } else {
                    $image = $this->model_tool_image->resize('no_image.jpg', 162, 123);
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

            $total_infor = $this->model_news_news->getTotalNews($data_search);
            $pagination = new Pagination();
            $pagination->total = $total_infor;
            $pagination->page = $page;
            $pagination->limit = $this->limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = HTTP_SERVER . 'tim-kiem/keyword='.$key.'&page={page}';
            $this->data['pagination'] = $pagination->render();
            
            $this->data['result'] = sprintf($this->language->get('results'), $key,$total_infor);
            
            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_search') . ': ' . ((utf8_strlen($key) > 35) ? (utf8_substr($key, 0, 35) . '...') : $key),
                'href'      => null,            
                'separator' => $this->language->get('text_seperator')
            );
        }
        
        if ( $key != '' ){
        	$this->data['keyword'] = $key;
        }else {
        	$this->data['keyword'] = '';
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/search.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/news/search.tpl';
        } else {
            $this->template = 'default/template/news/search.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
        //    'common/container_top',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }
}
?>