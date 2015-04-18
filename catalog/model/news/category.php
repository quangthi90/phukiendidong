<?php

class ModelNewsCategory extends Model {

    public function addCategory($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "news_category SET parent_id = '" . (int) $data['parent_id'] . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', is_leaf = '" . $data['is_leaf'] . "'");

        $category_id = $this->db->getLastId();

        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "news_category_description SET news_category_id = '" . (int) $category_id . "', language_id = '" . (int) $language_id . "', category_name = '" . $this->db->escape($value['name']) . "'");
        }

        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_category_id=" . (int) $category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

        $this->cache->delete('category');
    }

    public function editCategory($category_id, $data) {
        $this->db->query("
			UPDATE " . DB_PREFIX . "news_category 
			SET parent_id = '" . (int) $data['parent_id'] . "', sort_order = '" . (int) $data['sort_order'] . "', 
				status = '" . (int) $data['status'] . "', is_leaf = '" . $data['is_leaf'] . "' 
			WHERE news_category_id = '" . (int) $category_id . "'");

        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("
				UPDATE " . DB_PREFIX . "news_category_description 
				SET category_name = '" . $value['name'] . "' 
				WHERE news_category_id = '" . (int) $category_id . "' and language_id = '" . $language_id . "'");
        }

        $this->db->query("
				DELETE FROM " . DB_PREFIX . "url_alias 
				WHERE query = 'news_category_id=" . (int) $category_id . "'");

        if ($data['keyword']) {
            $this->db->query("
				INSERT INTO " . DB_PREFIX . "url_alias 
				SET query = 'news_category_id=" . (int) $category_id . "', 
					keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

        $this->cache->delete('category');
    }

    /* 	public function deleteCategory($category_id) {
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
     */

    public function deleteCategory($category_id) {
        $this->db->query("
			UPDATE " . DB_PREFIX . "news_category 
			SET status = '0'
			WHERE news_category_id = '" . (int) $category_id . "'");

        $query = $this->db->query("
			SELECT news_category_id 
			FROM " . DB_PREFIX . "news_category 
			WHERE parent_id = '" . (int) $category_id . "'");

        foreach ($query->rows as $result) {
            $this->deleteCategory($result['news_category_id']);
        }

        $this->cache->delete('category');
    }

    public function getCategoryById($category_id) {
        $language = $this->config->get('config_language_id');

        $sql = "
			SELECT *, 
			(
				SELECT keyword 
				FROM " . DB_PREFIX . "url_alias 
				WHERE query = 'news_category_id=" . (int) $category_id . "'
			) AS keyword
			FROM " . DB_PREFIX . "news_category, " . DB_PREFIX . "news_category_description 
			WHERE news_category.news_category_id = '" . (int) $category_id . "' 
				AND news_category.news_category_id = news_category_description.news_category_id
				AND language_id = '" . (int) $language . "'";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function getCategoryDescriptions($category_id) {
        $query = $this->db->query("
			SELECT *
			FROM " . DB_PREFIX . "news_category_description 
			WHERE news_category_id = '" . (int) $category_id . "'");

        return $query->rows;
    }

    public function getCategories($data = array()) {
        $sql = "
			SELECT *
			FROM " . DB_PREFIX . "news_category nc, " . DB_PREFIX . "news_category_description ncd
			WHERE nc.news_category_id = ncd.news_category_id 
				AND ncd.language_id = '" . (int) $this->config->get('config_language_id') . "'
                AND nc.status = 1";

        if (isset($data['is_leaf'])) {
            $sql .= " AND nc.is_leaf = '" . $data['is_leaf'] . "'";
        }

        if (isset($data['parent_id'])) {
            $sql .= " AND nc.parent_id = '" . $data['parent_id'] . "'";
        }

        if (isset($data['category_name'])) {
            $sql .= " AND LCASE(category_name) LIKE '" . $this->db->escape(utf8_strtolower($data['category_name'])) . "%'";
        }

        $sql .= " ORDER BY sort_order";

        $query = $this->db->query($sql);

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

    public function getCategoriesByParent($parent_id, $limit = 0) {
        $language_id = $this->config->get('config_language_id');

        $sql = "
			SELECT *
			FROM " . DB_PREFIX . "news_category, " . DB_PREFIX . "news_category_description
			WHERE news_category_description.news_category_id = news_category.news_category_id 
				AND language_id = '" . $language_id . "' and parent_id = '" . $parent_id . "'
				AND status = 1
			ORDER BY sort_order ASC";

        if ($limit != 0) {
            $sql .= " LIMIT $limit";
        }

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

    public function getInforCategoryDescriptionsByCategoryId($category_id) {
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