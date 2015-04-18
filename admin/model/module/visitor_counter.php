<?php
################################################################################################
#  Visitor Counter for Opencart 1.5.1.x From HostJars http://opencart.hostjars.com   	       #
################################################################################################
class ModelModuleVisitorCounter extends Model {
	
	public function createVisitorTable() 
	{
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "visitor_counter (prodid int, word char(25), count int, PRIMARY KEY (prodid, word))");
	}

}
?>