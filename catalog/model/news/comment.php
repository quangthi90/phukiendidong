<?php
class ModelNewsComment extends Model {
	public function addComment($news_id, $data) {
		$customer_id = $this->customer->getId();

		if (isset($data['status'])) {
			$status = $data['status'];
		}else {
			$status = 1;
		}
		
		$sql = "INSERT INTO " . DB_PREFIX . "news_comment 
			SET news_id = '" . (int)$news_id . "', 
				customer_id = '" . $customer_id . "', 
				news_comment_content = '" . (string)$data['content'] . "', 
				news_comment_date_created = '" . (string)time() . "', 
				news_comment_status = '" . (int)$status . "'";
		
		if (isset($data['review'])) {
			$sql .= ", news_comment_review = '" . (int)$data['review'] . "'";
		}

		$this->db->query($sql);
	}
	
	public function getComments($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news_comment";

		if (count($data) > 0) {
			$sql .= ' WHERE';
		}
		if (isset($data['news_id'])) {
			$sql .= " news_id='" . $data['news_id'] . "'";
		}
		
		$sort_data = array(
			'news_id',
			'news_comment_date_created',
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY news_comment_date_created";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}
		if (isset($data['start']) && isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 0) {
				$data['limit'] = 10;
			}
			
			$sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalComment($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_comment";

		$check = false;
		
		if (isset($data['news_id']) || isset($data['customer_id'])) {
			$sql .= ' WHERE';
		}

		if (isset($data['news_id'])) {
			if ($check) $sql .= ' AND';
			$sql .= " news_id='" . $data['news_id'] . "'";
			$check = true;
		}
		if (isset($data['customer_id'])) {
			if ($check) $sql .= ' AND';
			$sql .= " customer_id='" . $data['customer_id'] . "'";
			$check = true;
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}