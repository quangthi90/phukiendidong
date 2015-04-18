<?php
class ModelNewsNews extends Model {
	public function addNew($data) {
		$created = time();
		if ( isset($data['created_date']) && !empty($data['created_date']) ){
			$created = strtotime($data['created_date']);
		}
		
		$updated = time();
		if ( isset($data['updated_date']) && !empty($data['updated_date']) ){
			$updated = strtotime($data['updated_date']);
		}
		
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "news 
			SET news_image_url = '" . (string)$data['image'] . "', news_category_id = '" . (int)$data['category'] . "', 
				news_created_date = '" . (string)$created . "', 
				news_updated_date = '" . (string)$updated . "', 
				news_status = '" . (int)$data['status'] . "', special = '" . (int)$data['special'] . "'");
		
		$news_id = $this->db->getLastId();
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "news_description 
				SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', 
					title = '" . (string)trim($this->db->escape($value['name'])) . "', 
					meta_description = '" . (string)$this->db->escape($value['meta_description']) . "', 
					description = '" . (string)$this->db->escape($value['description']) . "'");
		}
		
		if (isset($data['keyword']) && !empty($data['keyword'])) { 
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_id=" . (int)$news_id . "', 
					keyword = '" . trim($this->db->escape($data['keyword'])) . "'");
		}else{
			$this->load->model('news/category');
			
			$category = $this->model_news_category->getCategoryById($data['category']);
			
			$category = $category[$this->config->get('config_language_id')];
			
			$remove_sign = $this->url->removeSign(strtolower($data['news_description'][$this->config->get('config_language_id')]['name']));
			
			$keyword = $category['keyword'] . '/' . $remove_sign . '-' . $news_id;
			
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_id=" . (int)$news_id . "', 
					keyword = '" . $this->db->escape($keyword) . "'");
		}
						
		$this->cache->delete('new');
	}
	
	public function editNew($news_id, $data) {
		$created = time();
		if ( isset($data['created_date']) && !empty($data['created_date']) ){
			$created = strtotime($data['created_date']);
		}
		
		$updated = time();
		if ( isset($data['updated_date']) && !empty($data['updated_date']) ){
			$updated = strtotime($data['updated_date']);
		}
		
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET news_image_url = '" . (string)$data['image'] . "', news_category_id = '" . (int)$data['category'] . "', 
				news_created_date = '" . $created . "', 
				news_updated_date = '" . $updated . "', 
				special = '" . (int)$data['special'] . "', news_status = '" . (int)$data['status'] . "'
			WHERE news_id = '" . (int)$news_id . "'");

		$this->db->query("
			DELETE FROM " . DB_PREFIX . "news_description 
			WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "news_description 
				SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', 
				title = '" . (string)trim($this->db->escape($value['name'])) . "', 
				meta_description = '" . (string)$this->db->escape($value['meta_description']) . "', 
				description = '" . (string)$this->db->escape($value['description']) . "'");
		}

		$this->db->query("
			DELETE FROM " . DB_PREFIX . "url_alias 
			WHERE query = 'news_id=" . (int)$news_id. "'");
		
		if (isset($data['keyword']) && !empty($data['keyword'])) { 
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_id=" . (int)$news_id . "', 
					keyword = '" . trim($this->db->escape($data['keyword'])) . "'");
		}else{
			$this->load->model('news/category');
			
			$category = $this->model_news_category->getCategoryById($data['category']);
			
			$category = $category[$this->config->get('config_language_id')];

			$remove_sign = $this->url->removeSign(strtolower($data['news_description'][$this->config->get('config_language_id')]['name']));
			
			$keyword = $category['keyword'] . '/' . $remove_sign . '-' . $news_id;
			
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_id=" . (int)$news_id . "', 
					keyword = '" . $this->db->escape($keyword) . "'");
		}
						
		$this->cache->delete('new');
	}
	
	public function deleteNew($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
		
		$this->cache->delete('new');
	}

	/*public function deleteNew($news_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET news_status = '0'
			WHERE news_id = '" . (int)$news_id . "'");
		
		$this->cache->delete('new');
	}*/
	
	public function recoveryNew($news_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET news_status = '1'
			WHERE news_id = '" . (int)$news_id . "'");
		
		$this->cache->delete('new');
	}
	
	public function getNew($news_id) {
		$query = $this->db->query("
			SELECT DISTINCT *, 
			(
				SELECT keyword FROM " . DB_PREFIX . "url_alias 
				WHERE query = 'news_id=" . (int)$news_id . "'
			) AS keyword 
			FROM " . DB_PREFIX . "news i, " . DB_PREFIX . "news_description id  
			WHERE i.news_id = '" . (int)$news_id . "' and i.news_id = id.news_id");

		$results = $query->rows;
		
		$infors = array();
		
		foreach ($results as $result){
			$infors[$result['language_id']] = $result;
		}
		
		return $infors;
	}
	
	public function getNews($data = array()) {
			$sql = "SELECT * 
					FROM " . DB_PREFIX . "news i, " . DB_PREFIX . "news_description id, " . DB_PREFIX . "news_category_description cd
					WHERE i.news_id = id.news_id AND i.news_category_id = cd.news_category_id";
			
			if (!empty($data['filter_category_id'])) {
				$sql .= " AND cd.news_category_id = '" . $data['filter_category_id'] . "'";			
			}
					
			$sql .= " AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND id.language_id = cd.language_id"; 
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}

			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND news_status = '" . (int)$data['filter_status'] . "'";
			}
			
			if (isset($data['filter_created']) && !is_null($data['filter_created'])) {
				$sql .= " AND news_created_date = '" . (int)$data['filter_created'] . "'";
			}
			
			if (isset($data['filter_updated']) && !is_null($data['filter_updated'])) {
				$sql .= " AND news_updated_date = '" . (int)$data['filter_updated'] . "'";
			}
			
			$sort_data = array(
					'title',
					'category_name',
					'news_status',
					'news_created_date',
					'news_updated_date',
					'special'
				);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY news_created_date";	
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
	
	public function getNewDescriptions($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("
			SELECT * 
			FROM " . DB_PREFIX . "news_description 
			WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'name'             => $result['title'],
				'description'      => $result['description'],
				'meta_description' => $result['meta_description']
			);
		}
		
		return $news_description_data;
	}
		
	public function getTotalNews($data = array()) {
		$sql = "SELECT COUNT(DISTINCT i.news_id) AS total 
		FROM " . DB_PREFIX . "news i, " . DB_PREFIX . "news_description id 
		WHERE i.news_id = id.news_id";

		if (!empty($data['filter_category_id'])) {
			$sql .= " AND news_category_id = '" . $data['filter_category_id'] . "'";			
		}
		 
		$sql .= " AND language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(title) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND news_status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_created']) && !is_null($data['filter_created'])) {
			$sql .= " AND news_created_date = '" . (int)$data['filter_created'] . "'";
		}
		
		if (isset($data['filter_updated']) && !is_null($data['filter_updated'])) {
			$sql .= " AND news_updated_date = '" . (int)$data['filter_updated'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>