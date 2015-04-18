<?php
class ControllerExtensionLimitManager extends Controller {
	public function index() {
		// request
		$this->load->model('setting/setting');
		if (isset($this->request->post['module']) && isset($this->request->post['setting'])) {
			foreach ($this->request->post['module'] as $code => $module_setting) {
				$setting = $this->model_setting_setting->getSetting($code);
				foreach ($this->request->post['module'][$code] as $key => $value) {
					$setting[$code . '_module'][$key]['limit'] = $value['limit'];
				}
				$this->model_setting_setting->editSetting($code, $setting);
			}
			$this->model_setting_setting->editSetting('limit_setting', $this->request->post['setting']);
		$this->redirect($this->url->link('extension/limit_manager', 'token=' . $this->session->data['token']));
		}

		// system message
		$this->data['success'] = '';
		$this->data['error'] = '';

		// breadcrumbs
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text' => 'Trang chủ',
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SLL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => 'Quản lí giới hạn',
			'href' => $this->url->link('extension/limit_manager', 'token=' . $this->session->data['token'], 'SLL'),
			'separator' => '::'
		);

		// heading
		$this->data['heading_title'] = 'Quản lí giới hạn';

		// text
		$this->data['text_module_name'] = 'Tên module';
		$this->data['text_layout'] = 'Giao diện';
		$this->data['text_position'] = 'Vị trí';
		$this->data['text_limit'] = 'Giới hạn';
		$this->data['text_no_results'] = 'Không tìm thấy kết quả nào';
		$this->data['button_cancel'] = 'Hùy';
		$this->data['button_save'] = 'Lưu';
		// action
		$this->data['action'] = $this->url->link('extension/limit_manager', 'token=' . $this->session->data['token'], 'SLL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SLL');
		
		// extensions
		$this->load->model('setting/extension');
		$this->load->model('design/layout');
		$extensions = $this->model_setting_extension->getExtensions('module');
		$extension_arr = array(
			'hotnews',
			'samenews',
			'lastest'
		);

		$this->data['extensions'] = array();	
		foreach ($extensions as $extension) {
			if (in_array($extension['code'], $extension_arr)) {
				$modules = $this->config->get($extension['code'] . '_module');
				$this->load->language('module/' . $extension['code']);			
				if ($modules) {
					foreach ($modules as $module) {
						$layout_info = $this->model_design_layout->getLayout($module['layout_id']);
						
						$this->data['extensions'][$extension['code']][] = array(
							'name' => $this->language->get('heading_title'),
							'position'       => $module['position'],
							'limit'    => isset($module['limit']) ? $module['limit'] : '',
							'sort_order' => $module['sort_order'],
							'layout' => $layout_info['name'],
							'code' => $extension['code']
						);				
					}
				}
			}
		}

		// limit setting
		$limit_setting = $this->model_setting_setting->getSetting('limit_setting');
		$this->data['setting'] = array();
		$this->data['setting']['product_category_limit'] = array(
			'layout' => 'Danh mục sản phẩm',
			'limit' => isset($limit_setting['product_category_limit']) ? $limit_setting['product_category_limit'] : ''
		);
		$this->data['setting']['news_category_limit'] = array(
			'layout' => 'Danh mục tin tức',
			'limit' => isset($limit_setting['news_category_limit']) ? $limit_setting['news_category_limit'] : ''
		);
		$this->data['setting']['news_search_limit'] = array(
			'layout' => 'Tìm kiếm tin tức',
			'limit' => isset($limit_setting['news_search_limit']) ? $limit_setting['news_search_limit'] : ''
		); 

		// render
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->template = 'extension/limit_manager.tpl';
		$this->response->setOutput($this->render());
	}
}