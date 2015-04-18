<?php
class ModelSaleContact extends Model{
	public function sendReply($data = array()){
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');		
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject($data['reply_title']);
		$mail->setText($data['reply_content']);
		$mail->send();
	}
	
	public function reviewed($contact_id){
		$sql = "UPDATE " . DB_PREFIX . "contact SET contact_review = '1' WHERE contact_id = " . $contact_id;
		
		$this->db->query($sql);
	}
	
	public function getContact($contact_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "contact ct, " . DB_PREFIX . "customer cr 
				WHERE ct.customer_id = cr.customer_id AND contact_id = " . $contact_id;
		
		$query = $this->db->query($sql);
		
		return $query->row;
	}
	
	public function getContacts($data = array()){
		$sql = "SELECT * FROM " . DB_PREFIX . "contact ct, " . DB_PREFIX . "customer cr
				WHERE ct.customer_id = cr.customer_id";
		
		if (!empty($data['contact_id'])){
			$sql .= " AND contact_id = " . $data['contact_id'];
		}
		
		if (!empty($data['contact_review'])){
			$sql .= " AND contact_review = " . $data['contact_review'];
		}
		
		$sort_data = array(
			'contact_title',
			'contact_email',
			'customer_name',
			'contact_review',
			'contact_created_date'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY contact_created_date";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalContacts($data = array()){
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contact ct, " . DB_PREFIX . "customer cr
				WHERE ct.customer_id = cr.customer_id";
		
		if (!empty($data['contact_id'])){
			$sql .= " AND contact_id = " . $data['contact_id'];
		}
		
		if (isset($data['contact_review'])){
			$sql .= " AND contact_review = '" . $data['contact_review'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function deleteContact($contact_id){
		$sql = "
			DELETE FROM " . DB_PREFIX . "contact
			WHERE contact_id =" . (int)$contact_id;
		
		$this->db->query($sql);
		
		return;
	}
}
?>