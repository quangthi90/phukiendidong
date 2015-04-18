<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		
		$this->load->model('account/customer_group');
		
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
		
      	$this->db->query("
      		INSERT INTO " . DB_PREFIX . "customer 
      		SET store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', 
      			lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "',
      			sex = '" . $this->db->escape($data['sex']) . "', birthday = '" . strtotime($data['birthday']) . "', 
      			telephone = '" . $this->db->escape($data['telephone']) . "', password = '" . $this->db->escape(md5($data['password'])) . "', 
      			newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', 
      			customer_group_id = '" . (int)$customer_group_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', 
      			status = '1', date_added = NOW(), approved = '1'");
      	
		$customer_id = $this->db->getLastId();
			
      	$this->db->query("
      		INSERT INTO " . DB_PREFIX . "address 
      		SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', 
      			lastname = '" . $this->db->escape($data['lastname']) . "', address_1 = '" . $this->db->escape($data['address']) . "'");
		
		$address_id = $this->db->getLastId();

      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
      	// Create active link & send email for active account
		$code = md5($customer_id);
      	
      	$this->db->query("
      		INSERT INTO " . DB_PREFIX . "url_alias 
      		SET query = 'user_code=" . (int)$customer_id . "', 
      			keyword = 'active/" . (string)$code . "'");
      	
		$this->language->load('mail/customer');
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
		
		if (!$this->config->get('config_customer_approval')) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}
		
		$message .= HTTP_SERVER . 'dang-nhap' . "\n\n";
		$message .= $this->language->get('text_post') . "\n";
		$message .= HTTP_SERVER . 'active/' . $code . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
		
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
		$mail->setSubject($subject);
		$mail->setText($message);
		// $mail->send();
	}
	
	public function editCustomer($data) {
		$sql = "UPDATE " . DB_PREFIX . "customer 
			SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', 
				email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "'";
		if ( isset( $data['sex'] ) ) {
			$sql .= ", sex = '" . $this->db->escape($data['sex']) . "'";
		}
		if ( isset( $data['birthday'] ) ) {
			$sql .= ", birthday = '" . strtotime($data['birthday']) . "'";
		}

		$sql .=	" WHERE customer_id = '" . (int)$this->customer->getId() . "'";
		 
		$this->db->query( $sql );
	}

	public function editPassword($email, $password) {
      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($password)) . "' WHERE email = '" . $this->db->escape($email) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function editNewsletterByEmail($email) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '1' WHERE email = '" . $email . "'");
	}
					
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->row;
	}
	
	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");
		
		return $query->row;
	}
		
	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");
		
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");
		
		return $query->row;
	}
		
	public function getCustomers($data = array()) {
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "c.email = '" . $this->db->escape($data['filter_email']) . "'";
		}
		
		if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
			
		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.ip',
			'c.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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
		
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");
		
		return $query->row['total'];
	}
	
	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->rows;
	}	
	
	public function activeAccount($customer_id) {
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "url_alias 
			WHERE query = 'user_code=" . (int)$customer_id . "'");
		
		$this->db->query("
			UPDATE " . DB_PREFIX . "customer
			SET approved = '1'
			WHERE customer_id = '" . (int)$customer_id . "'");
		
		return true;
	}
	
	public function isBlacklisted($ip) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip_blacklist` WHERE ip = '" . $this->db->escape($ip) . "'");
		
		return $query->num_rows;
	}	

	public function setThumb($thumb_url, $customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET thumb_url='" . $thumb_url . "' WHERE customer_id='" . $customer_id . "'");
	}
	
	public function uploadImage( $image, $customer_id ) {
		$valid_format = array("jpg", "png", "gif", "bmp");
		if (strlen( $image['name'] ) ) {
			list($txt, $ext) = explode(".", $image['name']);
			if (in_array($ext, $valid_format)) {
				if ($image['size'] < (1024*1024)) {
					$path = 'data/user/';
					$name = 'user_thumb' . $customer_id . '.' . $ext;
					if (file_exists(DIR_IMAGE . $path . $name)) {
						unlink(DIR_IMAGE . $path . $name);
					}
					if (move_uploaded_file($image['tmp_name'], DIR_IMAGE . $path . $name)) {
						$this->setThumb('data/user/'. $name, $customer_id);
						return $path . $name;
					}else {
						return false;
					}
				}else {
					return false;
				}
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
}
?>