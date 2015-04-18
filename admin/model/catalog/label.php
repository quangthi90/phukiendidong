<?php
class ModelCatalogLabel extends Model {
	public function addLabel($data = array()) {
		$sql = "INSERT INTO `" . DB_PREFIX . "label` SET image='" . $data['image'] . "', status='" . (int)$data['status'] . "'";
		$this->db->query($sql);

		$label_id = $this->db->getLastId();

		foreach ($data['label_description'] as $language_id => $label_description) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "label_description` SET label_id='" . $label_id . "', language_id='" . $language_id . "', title='" . $label_description['title'] . "'");
		}
	}

	public function editLabel($label_id, $data = array()) {
		$sql = "UPDATE `" . DB_PREFIX . "label` SET image='" . $data['image'] . "', status='" . $data['status'] . "' WHERE label_id='" . $label_id . "'";
		
		$this->db->query($sql);

		$sql = "DELETE FROM `" . DB_PREFIX . "label_description` WHERE label_id='" . $label_id . "'";

		$this->db->query($sql);

		foreach ($data['label_description'] as $language_id => $label_description) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "label_description` SET label_id='" . $label_id . "', language_id='" . $language_id . "', title='" . $label_description['title'] . "'");
		}
	}

	public function deleteLabel($data = array()) {
		if (isset($data['label_id'])) {
			foreach ($data['label_id'] as $label_id) {
				$sql = "DELETE FROM `" . DB_PREFIX . "label` WHERE label_id='" . $label_id . "'";
				$this->db->query($sql);
				$sql = "DELETE FROM `" . DB_PREFIX . "label_description` WHERE label_id='" . $label_id . "'";
				$this->db->query($sql);
			}
		}
		
	}

	public function getLabels($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "label` l LEFT JOIN `" . DB_PREFIX . "label_description` ld ON (l.label_id=ld.label_id)";
		
		$sql .= " WHERE ld.language_id='" . $this->config->get('config_language_id') . "'";

		if (isset($data['status'])) {
			$sql .= " AND status='" . (int)$data['status'] . "'";
		}
		
		if (isset($data['limit'])) {
			$limit = (int)$data['limit'];
		}else {
			$limit = 10;
		}
		if (isset($data['start'])) {
			$start = (int)$data['start'];
		}else {
			$start = 0;
		}

		$sql .= " LIMIT " . $start . ", " . $limit;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getLabel($label_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "label` WHERE label_id='" . (int)$label_id . "'";

		$query = $this->db->query($sql); 

		$label = $query->row;

		if ($query->row['image']) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "label_description` WHERE label_id='" . (int)$label_id . "'";

			$query = $this->db->query($sql);

			$label_description_data = $query->rows;

			$label_description = array();
			foreach ($label_description_data as $description) {
				$label_description[$description['language_id']]['title'] = $description['title'];
			}

			$label['label_description'] = $label_description;
		}
		
		return $label;
	}

	public function getTotalLabels($data = array()) {
		$sql = "SELECT COUNT(label_id) AS total FROM `" . DB_PREFIX . "label`";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}