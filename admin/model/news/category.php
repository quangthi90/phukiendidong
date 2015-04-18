<?php
class ModelNewsCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', is_leaf = '" . $data['is_leaf'] . "'");
	
		$category_id = $this->db->getLastId();
		
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_description SET news_category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', category_name = '" . $this->db->escape($value['name']) . "'");
		}
						
		if (isset($data['keyword']) && !empty($data['keyword'])) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$remove_sign = $this->url->removeSign(strtolower($data['category_description'][$this->config->get('config_language_id')]['name']));
			
			$keyword = $remove_sign . '-' . $category_id;
			
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_category_id=" . (int)$category_id . "', 
					keyword = '" . $this->db->escape($keyword) . "'");
		}
		
		$this->cache->delete('category');
	}
	
	public function editCategory($category_id, $data) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news_category 
			SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', 
				status = '" . (int)$data['status'] . "', is_leaf = '" . $data['is_leaf'] . "' 
			WHERE news_category_id = '" . (int)$category_id . "'");
		
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("
				UPDATE " . DB_PREFIX . "news_category_description 
				SET category_name = '" . $value['name'] . "' 
				WHERE news_category_id = '" . (int)$category_id . "' and language_id = '" . $language_id . "'");
		}
				
		$this->db->query("
				DELETE FROM " . DB_PREFIX . "url_alias 
				WHERE query = 'news_category_id=" . (int)$category_id. "'");
		
		if (isset($data['keyword']) && !empty($data['keyword'])) { 
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_category_id=" . (int)$category_id . "', 
					keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$remove_sign = $this->url->removeSign(strtolower($data['category_description'][$this->config->get('config_language_id')]['name']));
			
			$keyword = $remove_sign . '-' . $category_id;
			
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_category_id=" . (int)$category_id . "', 
					keyword = '" . $this->db->escape($keyword) . "'");
		}
		
		$this->cache->delete('category');
	}
	
	public function deleteCategory($category_id) {
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "news_category 
			WHERE news_category_id = '" . (int)$category_id . "'");
		
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "news_category_description 
			WHERE news_category_id = '" . (int)$category_id . "'");
		
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "url_alias 
			WHERE query = 'news_category_id=" . (int)$category_id . "'");
		
		$query = $this->db->query("
			SELECT news_category_id 
			FROM " . DB_PREFIX . "news_category 
			WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['news_category_id']);
		}
		
		$this->cache->delete('category');
	} 
	
	/*public function deleteCategory($category_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news_category 
			SET status = '0'
			WHERE news_category_id = '" . (int)$category_id . "'");
		
		$query = $this->db->query("
			SELECT news_category_id 
			FROM " . DB_PREFIX . "news_category 
			WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['news_category_id']);
		}
		
		$this->cache->delete('category');
	}*/
	
	public function getCategoryById($category_id) {
		$query = $this->db->query("
			SELECT *, 
			(
				SELECT keyword 
				FROM " . DB_PREFIX . "url_alias 
				WHERE query = 'news_category_id=" . (int)$category_id . "'
			) AS keyword
			FROM " . DB_PREFIX . "news_category, " . DB_PREFIX . "news_category_description 
			WHERE news_category.news_category_id = '" . (int)$category_id . "' 
				AND news_category.news_category_id = news_category_description.news_category_id");
		
		$results = $query->rows;
		
		$cateogries = array();
		
		foreach ($results as $result){
			$cateogries[$result['language_id']] = $result;
		}
		
		return $cateogries;
	} 
	
	public function getCategoryDescriptions($category_id) {
		$query = $this->db->query("
			SELECT *
			FROM " . DB_PREFIX . "news_category_description 
			WHERE news_category_id = '" . (int)$category_id . "'");
		
		return $query->rows;
	}
	
	public function getAllCategories() {
		$language_id = $this->config->get('config_language_id');
		
		$sql = "
			SELECT *
			FROM " . DB_PREFIX . "news_category, " . DB_PREFIX . "news_category_description
			WHERE news_category.news_category_id = news_category_description.news_category_id 
				AND language_id = '" . $language_id . "' ORDER BY sort_order";
		
		$query = $this->db->query($sql);
			
		return $query->rows;
	}
	
	public function getCategoriesByParent($parent_id) {
		$language_id = $this->config->get('config_language_id');
		
		$sql = "
			SELECT *
			FROM " . DB_PREFIX . "news_category, " . DB_PREFIX . "news_category_description
			WHERE news_category_description.news_category_id = news_category.news_category_id 
				AND language_id = '" . $language_id . "' and parent_id = '" . $parent_id . "' ORDER BY sort_order";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getCategoriesByIsLeaf($is_leaf) {
		$language_id = $this->config->get('config_language_id');
		
		$sql = "
			SELECT *
			FROM " . DB_PREFIX . "news_category, " . DB_PREFIX . "news_category_description
			WHERE news_category.news_category_id = news_category_description.news_category_id 
				AND language_id = '" . $language_id . "' and is_leaf = '" . $is_leaf . "' ORDER BY sort_order";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getnewsCategoryDescriptionsByCategoryId($category_id){
		$query = $this->db->query("
			SELECT * FROM " . DB_PREFIX . "news_category_description 
			WHERE news_category_id = '" . $category_id . "'");
		
		return $query->rows;
	}
	
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category");
		
		return $query->row['total'];
	}
}
?>