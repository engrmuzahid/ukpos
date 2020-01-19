<?php
include 'db.php';

$q = strtolower($_GET["q"]);
if (!$q) return;

$ad_sc = mysql_query("select contact_no1 from customer WHERE status = 'approved'");
	
	while($row_sc = mysql_fetch_array($ad_sc)){
		$contact_no1 = $row_sc['contact_no1'];
		if (strpos(strtolower($contact_no1), $q) !== false) {
			echo "$contact_no1\n";
		}
	}

?>
