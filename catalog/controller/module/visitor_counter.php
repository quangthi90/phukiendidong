<?php
################################################################################################
#  Visitor Counter Module for Opencart 1.5.1.x from HostJars http://opencart.hostjars.com      #
################################################################################################
?><?php

class ControllerModuleVisitorCounter extends Controller {
	protected function index() {
		//LOAD LANGUAGE
		$this->language->load('module/visitor_counter');

		//SET TITLE
      	$this->data['heading_title'] = $this->language->get('heading_title');

		//LOAD MODEL FILES
		$this->load->model('module/visitor_counter');



		$this->model_module_visitor_counter->addVisitor($this->request->server['REMOTE_ADDR']);
		$results = $this->model_module_visitor_counter->getVisitors();
		
		$num_visitors = 0;
		$num_visits = 0;
		
		foreach ($results as $result) {
			$num_visits += $result['count'];
			$num_visitors++; 
		}
		
		$filler_text = "00000000";
		if (strlen("$num_visitors") < 8) {
			$num_visitors = substr($filler_text, 0, (8-strlen("$num_visitors"))) . "$num_visitors";
		}
		if (strlen("$num_visits") < 8) {
			$num_visits = substr($filler_text, 0, (8-strlen("$num_visits"))) . "$num_visits";
		}
		
		$this->data['num_visits'] = $num_visits;
		$this->data['num_visitors'] = $num_visitors;
		$this->data['bg_color'] = $this->config->get('visitor_counter_background_color');
		$this->data['font_color'] = $this->config->get('visitor_counter_font_color');
		if ($this->config->get('visitor_counter_count_type') == 1) {
			$this->data['visitor_counter_num'] = "$num_visitors";
		}
		else {
			$this->data['visitor_counter_num'] = "$num_visits";
		}
		$this->id = 'visitor_counter';


		//CHOOSE TEMPLATE
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/visitor_counter.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/visitor_counter.tpl';
		} else {
			$this->template = 'default/template/module/visitor_counter.tpl';
		}

		//RENDER
		$this->render();
	}
}
?>