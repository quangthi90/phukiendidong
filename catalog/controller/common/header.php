<?php

class ControllerCommonHeader extends Controller {

    protected function index() {
        $this->data['title'] = $this->document->getTitle();

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = $this->config->get('config_ssl');
        } else {
            $this->data['base'] = $this->config->get('config_url');
        }

        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

        $this->language->load('common/header');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = HTTPS_IMAGE;
            $this->data['image_deliver'] = HTTPS_IMAGE.'data/deliver.png';
        } else {
            $server = HTTP_IMAGE;
            $this->data['image_deliver'] = HTTP_IMAGE.'data/deliver.png';
        }

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        $this->data['name'] = $this->config->get('config_name');

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }

        $this->data['text_cart'] = $this->language->get('text_cart');

        if ($this->cart->hasProducts()) {
            $this->data['text_cart'] .= '(' . $this->cart->countProducts() . ')';
        }

        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_checkout'] = $this->language->get('text_checkout');
        $this->data['text_subprice'] = $this->language->get('text_subprice');
        $this->data['text_email_input'] = $this->language->get('text_email_input');
        $this->data['text_login'] = $this->language->get('text_login');
        $this->data['text_logout'] = $this->language->get('text_logout');
        $this->data['text_reg'] = $this->language->get('text_reg');
        $this->data['text_account'] = $this->language->get('text_account');

        if ($this->customer->isLogged()) {
            $this->data['text_account'] = 'Xin chào ' . ((count_chars($this->customer->getLastName()) > 10) ? (substr($this->customer->getLastName(), 0, 10) . '...') : ($this->customer->getLastName()));
        }

        $this->data['home'] = HTTP_SERVER;
        $this->data['wishlist'] = $this->url->link('account/wishlist');
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['account'] = HTTP_SERVER . 'thong-tin-tai-khoan';
        $this->data['shopping_cart'] = $this->url->link('checkout/cart');
        $this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
        $this->data['newsletter_register'] = $this->url->link('account/newsletter_register');

        // Menu
        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_product'] = $this->language->get('text_product');
        $this->data['text_decoration'] = $this->language->get('text_decoration');
        $this->data['text_news'] = $this->language->get('text_news');
        $this->data['text_promotion'] = $this->language->get('text_promotion');
        $this->data['text_video'] = $this->language->get('text_video');
        $this->data['text_hotline'] = $this->language->get('text_hotline');

        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $this->data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories();

        foreach ($categories as $category) {
            //if ($category['top']) {
                $children_data = array();

                $children = $this->model_catalog_category->getCategories($category['category_id']);

                foreach ($children as $child) {
                    if ($this->config->get('config_product_count')) {
                    	$data = array(
	                        'filter_category_id' => $child['category_id'],
	                        'filter_sub_category' => true
	                    );
                    
                        $product_total = $this->model_catalog_product->getTotalProducts($data);

                        $child['name'] .= ' (' . $product_total . ')';
                    }
                    
                    $child = $this->model_catalog_category->getCategory($child['category_id']);
					
                    $children_data[] = array(
                        'name' => $child['name'],
                        'href' => HTTP_SERVER . $child['keyword']
                    );
                }

                // Level 1
                $this->data['categories'][] = array(
                    'name' => $category['name'],
                    'children' => $children_data,
                    'column' => 1,
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            //}
        }
		
        // news category
        $this->load->model('news/category');
        $this->load->model('news/news');

        $this->data['news_categories'] = '';
        $children = '';
        
        $news_categories = $this->model_news_category->getCategories(array('parent_id' => 0));

        if (count($news_categories) > 0) {
        $this->data['news_categories'] .= '<ul>';
        foreach ($news_categories as $category) {
        	if ( $category['news_category_id'] == 22 ){
        		continue;
        	}
        	
            if ($category['is_leaf']) {
                $this->data['news_categories'] .= '<li>';
                $this->data['news_categories'] .= '<a href="'. $this->url->link('news/news_category', 'news_category_id=' . $category['news_category_id']) .'">';
                $this->data['news_categories'] .= $category['category_name'];
                $this->data['news_categories'] .= '</a>';
                $this->data['news_categories'] .= '</li>';
            }else {
                $children = $this->getNewsCategoryChildren($category['news_category_id']);

                $this->data['news_categories'] .= '<li>';
                $this->data['news_categories'] .= '<a href="'. $this->url->link('news/news_category', 'news_category_id=' . $category['news_category_id']) .'">';
                $this->data['news_categories'] .= $category['category_name'];
                $this->data['news_categories'] .= '</a>';
                $this->data['news_categories'] .= $children;
                $this->data['news_categories'] .= '</li>';
            }
        }
        $this->data['news_categories'] .= '</ul>';
        }
        // end news category
        
        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header.tpl';
        } else {
            $this->template = 'default/template/common/header.tpl';
        }

        $this->render();
    }

    private function getNewsCategoryChildren($news_category_id) {
        $children = '';
        $categories = $this->model_news_category->getCategories(array('parent_id' => $news_category_id));
        if (count($categories) > 0) {
        $children .= '<ul>';
        foreach ($categories as $category) {
            if ($category['is_leaf']) {
                $children .= '<li>';
                $children .= '<a href="'. $this->url->link('news/news_category', 'news_category_id=' . $category['news_category_id']) .'">';
                $children .= $category['category_name'];
                $children .= '</a>';
                $children .= '</li>';
            }else {
                $children_info = $this->getNewsCategoryChildren($category['news_category_id']);

                $children .= '<li>';
                $children .= '<a href="'. $this->url->link('news/news_category', 'news_category_id=' . $category['news_category_id']) .'">';
                $children .= $category['category_name'];
                $children .= '</a>';
                $children .= $children_info;
                $children .= '</li>';
            }
            
        }
        $children .= '</ul>';
        }
        return $children;
    }
}

?>