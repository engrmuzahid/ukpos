<?php
include 'db.php';

$q = strtolower($_GET["q"]);
if (!$q) return;

$ad_sc = mysql_query("select customer_name from customer");
	
	while($row_sc = mysql_fetch_array($ad_sc)){
		$customer_name = $row_sc['customer_name'];
		if (strpos(strtolower($contact_no1), $q) !== false) {
			echo "$customer_name\n";
		}
	}

?>
