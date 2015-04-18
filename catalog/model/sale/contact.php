<?php
class ModelSaleContact extends Model{
	public function addContact($data){
		$bool = true;
		try {
			$sql = "INSERT INTO " . DB_PREFIX . "contact
					SET customer_id = " . $data['customer_id'] . ", contact_email = '" . $data['email'] . "',
						contact_title = '" . $data['title'] . "', contact_content = '" . $data['content'] . "',
						contact_created_date = '" . time() . "'";
			
			$this->db->query($sql);
		}
		catch(Exception $ex){
			$bool = false;
		}
		
		return $bool;
	}
}
?>