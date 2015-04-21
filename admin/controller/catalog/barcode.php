<?php 
class ControllerCatalogBarcode extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('catalog/barcode');
    	
		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/barcode', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id, 'SSL'),
      		'separator' => ' :: '
   		);

   		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->document->addScript('view/javascript/quagga.min.js');

		$this->document->addStyle('view/stylesheet/barcode/styles.css');

   		$this->data['heading_title'] = $this->language->get('heading_title');

   		$this->data['entry_barcode'] = $this->language->get('entry_barcode');
   		$this->data['entry_scanner'] = $this->language->get('entry_scanner');
   		$this->data['entry_barcode_list'] = $this->language->get('entry_barcode_list');

   		$this->data['text_add'] = $this->language->get('text_add');
   		$this->data['text_remove'] = $this->language->get('text_remove');

   		$this->data['error_barcode_exist'] = $this->language->get('error_barcode_exist');

   		$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');

    	$this->data['action'] = $this->url->link('catalog/barcode/insert', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id, 'SSL');
    	$this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');

    	$this->data['token'] = $this->session->data['token'];
		
		$this->template = 'catalog/barcode.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function checkBarcode() {
		$json = array(
			'is_exist' => true
		);
		
		if (isset($this->request->get['barcode_value'])) {
			$this->load->model('catalog/barcode');
			
			$result = $this->model_catalog_barcode->getBarcode($this->request->get['barcode_value']);
			
			if ($result == null) {
				$json = array(
					'is_exist' => false
				);
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function insert() {
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->load->language('catalog/barcode');
			
			$this->load->model('catalog/barcode');
      		$this->model_catalog_barcode->addBarcode($this->request->get['product_id'], $this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');
						
      		$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	}
}
?>