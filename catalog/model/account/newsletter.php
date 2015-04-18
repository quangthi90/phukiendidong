<?php 
class ModelAccountNewsletter extends Model {
	public function addNewsletter($email) {
		$sql = "INSERT INTO " . DB_PREFIX . "newsletter SET email = '" . $email . "', date_created = '" . time() . "',  ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'";
		$this->db->query($sql);
	}

	public function getNewsLetter($email) {
		$sql = "SELECT * FROM " . DB_PREFIX . "newsletter WHERE email = '" . $email . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}
}