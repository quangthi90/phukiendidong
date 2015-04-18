<?php 
class ModelSaleNewsletter extends Model {
	public function getTotalNewsletters($data = array()) {
		$sql = "SELECT count(email) AS total FROM ((SELECT DISTINCT c.email FROM " . DB_PREFIX . "customer AS c WHERE newsletter = '1') UNION (SELECT DISTINCT ns.email FROM " . DB_PREFIX . "newsletter AS ns)) AS nc_c";

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getNewsletters($data = array()) {
		$sql = "SELECT DISTINCT email FROM ((SELECT DISTINCT c.email FROM " . DB_PREFIX . "customer AS c WHERE newsletter = '1') UNION (SELECT DISTINCT ns.email FROM " . DB_PREFIX . "newsletter AS ns)) AS nc_c";

		if (isset($data['limit']) || isset($data['start'])) {
			if (isset($data['start']) && $data['start'] >= 0) {
				$start = (int)$data['start'];
			}else {
				$start = 0;
			}
			if (isset($data['limit']) && $data['limit'] > 0) {
				$limit = (int)$data['limit'];
			}else {
				$limit = 10;
			}

			$sql .= " LIMIT " . $start . ", " . $limit;
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}
}