<?php
class ModelNewsNews extends Model {
	public function addNews($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET news_image_url = '" . $data['image'] . "', news_category_id = '" . $data['category'] . "', news_created_date = '" . strtotime($data['created_date']) . "', news_updated_date = '" . strtotime($data['updated_date']) . "', news_status = '" . $data['status'] . "', special = '" . $data['special'] . "'");
		
		$news_id = $this->db->getLastId();
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						
		$this->cache->delete('news');
	}
	
	public function editNews($news_id, $data) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET news_image_url = '" . $data['image'] . "', news_category_id = '" . $data['category'] . "', 
				news_created_date = '" . strtotime($data['created_date']) . "', 
				news_updated_date = '" . strtotime($data['updated_date']) . "', 
				news_status = '" . $data['status'] . "',
				count_view = '" . $data['count_view'] . "'
			WHERE news_id = '" . (int)$news_id . "'");

		$this->db->query("
			DELETE FROM " . DB_PREFIX . "news_description 
			WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "news_description 
				SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', 
				title = '" . $this->db->escape($value['name']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("
			DELETE FROM " . DB_PREFIX . "url_alias 
			WHERE query = 'news_id=" . (int)$news_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_id=" . (int)$news_id . "', 
					keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						
		$this->cache->delete('news');
	}
	
	public function countViewNews($count, $news_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET count_view = '" . (int)$count . "'
			WHERE news_id = '" . (int)$news_id . "'");
	}
	
/*	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
		
		$this->cache->delete('news');
	}
*/

	public function deleteNews($news_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET news_status = '0'
			WHERE news_id = '" . (int)$news_id . "'");
		
		$this->cache->delete('news');
	}
	
	public function recoveryNews($news_id) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "news 
			SET news_status = '1'
			WHERE news_id = '" . (int)$news_id . "'");
		
		$this->cache->delete('news');
	}
	
	public function getNews($news_id) {
		$language = $this->config->get('config_language_id');
		
		$sql = "
			SELECT DISTINCT *, 
			(
				SELECT keyword FROM " . DB_PREFIX . "url_alias 
				WHERE query = 'news_id=" . (int)$news_id . "'
			) AS keyword 
			FROM " . DB_PREFIX . "news n, " . DB_PREFIX . "news_description nd  
			WHERE n.news_id = '" . (int)$news_id . "' and n.news_id = nd.news_id
				AND n.news_status = '1' AND nd.language_id = '" . (int)$language . "'";
		
		$query = $this->db->query($sql);
				
		return $query->row;
	}
	
	public function getNewses($data = array()) {
		$sql = "SELECT *
				FROM " . DB_PREFIX . "news n, " . DB_PREFIX . "news_description nd, 
					" . DB_PREFIX . "news_category_description ncd
				WHERE n.news_id = nd.news_id AND n.news_category_id = ncd.news_category_id
					AND n.news_status = '1' AND ncd.language_id = " . (int)$this->config->get('config_language_id')
					. " AND nd.language_id = " . (int)$this->config->get('config_language_id');

		if (!empty($data['category'])){
			$category = $data['category'];

			if ( $category['is_leaf'] != 1 ){
				$sql .= " AND (";

				$child_category_ids = $this->getLeafCategories( $category['news_category_id'] );
				foreach ( $child_category_ids as $key => $child_category_id ) {
					$sql .= " n.news_category_id = " . (int)$child_category_id . " OR";
				}

				$sql .= " n.news_category_id = " . (int)$category['news_category_id'] . ")";
			}else{
				$data['filter_category_id'] = $category['news_category_id'];
			}
		}
		
		if (!empty($data['filter_category_id'])) {
        	$sql .= " AND n.news_category_id = " . (int)$data['filter_category_id'];
		} 
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(title) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_created']) && !is_null($data['filter_created'])) {
			$sql .= " AND news_created_date = '" . (int)$data['filter_created'] . "'";
		}
		
		if (isset($data['filter_updated']) && !is_null($data['filter_updated'])) {
			$sql .= " AND news_updated_date = '" . (int)$data['filter_updated'] . "'";
		}
		
		if (isset($data['special']) && !is_null($data['special'])) {
			$sql .= " AND special = '" . (int)$data['special'] . "'";
		}
		
		if (isset($data['old']) && !is_null($data['old'])) {
			$sql .= " AND news_created_date < '" . (int)$data['old'] . "'";
		}
		
		if (isset($data['new']) && !is_null($data['new'])) {
			$sql .= " AND news_created_date > '" . (int)$data['new'] . "'";
		}
		
		$sort_data = array(
				'title',
				'category_name',
				'news_status',
				'news_created_date',
				'news_updated_date',
				'count_view'
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
		// print($sql); exit();
		$query = $this->db->query($sql);
		
		return $query->rows;
		
	}
	
	public function getNewsDescriptions($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("
			SELECT * FROM " . DB_PREFIX . "news_description 
			WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'name'             => $result['title'],
				'description'      => $result['description'],
				'meta_description' => $result['meta_description'],
				'tag_keyword' 	   => $result['tag_keyword']
			);
		}
		
		return $news_description_data;
	}
		
	public function getTotalnews($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.news_id) AS total 
			FROM " . DB_PREFIX . "news n, " . DB_PREFIX . "news_description nd 
			WHERE n.news_id = nd.news_id";

		if (!empty($data['category'])){
			$category = $data['category'];

			if ( $category['is_leaf'] != 1 ){
				$sql .= " AND (";

				$child_category_ids = $this->getLeafCategories( $category['news_category_id'] );
				foreach ( $child_category_ids as $key => $child_category_id ) {
					$sql .= " n.news_category_id = " . (int)$child_category_id . " OR";
				}

				$sql .= " n.news_category_id = " . (int)$category['news_category_id'] . ")";
			}else{
				$data['filter_category_id'] = $category['news_category_id'];
			}
		}

		if (!empty($data['filter_category_id'])) {
                    if(-1 != (int)$data['filter_category_id'])
                        $sql .= " AND news_category_id = '" . $data['filter_category_id'] . "'";			
		}
		 
		$sql .= " AND language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(title) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
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
		// print($sql); exit();
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	

    public function getLeafCategories( $parent_id ){
    	$child_category_ids = array();
    	$parents = $this->model_news_category->getCategories( array('parent_id' => $parent_id) );

    	foreach ($parents as $key => $parent) {
    		if ( $parent['is_leaf'] != 1 ){
    			$datas = $this->getLeafCategories( $parent['news_category_id'] );

    			foreach ($datas as $key => $data) {
    				$child_category_ids[] = $data['news_category_id'];
    			}
    		}else{
    			$child_category_ids[] = $parent['news_category_id'];
    		}
    	}

    	return $child_category_ids;
    }
}
?>