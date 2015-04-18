<?php
class ModelNewsComment extends Model {
	public function addComment($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "news_comment SET news_id = '" . $data['news_id'] . "', customer_id = '" . $data['customer_id'] . "', news_comment_content = '" . $data['content'] . "', news_comment_date_created = '" . (string)time() . "', news_comment_status = '" . $data['status'] . "'";
		
		if (isset($data['review'])) {
			$sql .= ", news_comment_review = '" . $data['review'] . "'";
		}

		$this->db->query($sql);
	}

	public function editComment($news_comment_id, $data) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news_comment 
			SET news_id = '" . (int)$data['news_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', 
				news_comment_content = '" . (string)$data['content'] ."', news_comment_status = '" . (int)$data['status'] . "', news_comment_review = '1' 
			WHERE news_comment_id = '" . (int)$news_comment_id . "'");
	}

	public function setReviewComment($news_comment_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news_comment 
			SET news_comment_review = '1' 
			WHERE news_comment_id = '" . (int)$news_comment_id . "'");
	}
	
	public function deleteComment($data) {
		foreach ($data as $value) {
			$sql = "DELETE FROM " . DB_PREFIX . "news_comment WHERE news_comment_id = '" . $value . "'";
			$this->db->query($sql);
		}
	}

	public function getComment($news_comment_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news_comment WHERE news_comment_id = '" . (int)$news_comment_id . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}
	
	public function getComments($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news_comment nc, " . DB_PREFIX . "customer c, " . DB_PREFIX . "news n, " . DB_PREFIX . "news_description nd WHERE nc.customer_id = c.customer_id AND nc.news_id = n.news_id AND n.news_id = nd.news_id AND nd.language_id = '" . $this->config->get('config_language_id') . "'";

		if (isset($data['news_id'])) {
			$sql .= " AND nc.news_id = '" . (int)$data['news_id'] . "'";
		}

		$sort_data = array(
					'n.title',
					'c.firstname',
					'nc.news_comment_status'
				);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY nc.news_comment_date_created";	
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
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

	public function getTotalComments($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_comment";

		if (isset($data['review'])) {
			$sql .= " WHERE";
		}

		if (isset($data['review'])) {
			$sql .= " news_comment_review = '" . (int)$data['review'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
?>