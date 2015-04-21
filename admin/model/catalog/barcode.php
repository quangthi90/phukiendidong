<?php 
class ModelCatalogBarcode extends Model {
	public function addBarcode($product_id, $data) {
		$sql = "INSERT INTO " . DB_PREFIX . "barcode (value, product_id, locked, deleted) VALUES ";

		foreach ($data['barcodes'] as $key => $value) {
			$sql .= "('$value', '$product_id', false, false)";

			if ($key < (count($data['barcodes']) - 1)) $sql .= ", ";
		}

		$this->db->query($sql);

		$query = $this->db->query("SELECT COUNT(*) AS quantity FROM " . DB_PREFIX . "barcode WHERE product_id = '$product_id'");

		$quantity = $query->row['quantity'];

		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '$quantity' WHERE product_id = '$product_id'");
	}

	public function getBarcode($barcode_value) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "barcode WHERE value = '" . (string)$barcode_value . "'");
		
		return $query->row;
	}		
}
?>