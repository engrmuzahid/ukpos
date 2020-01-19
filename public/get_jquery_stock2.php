<?php
include 'db.php';

$product_category          = $_GET['product_category_id'];
$product_type              = $_GET['product_type_id'];
$product_id                = $_GET['product_id'];

if(!empty($product_category)){
	$ad_sc = mysql_query("select * from product_type WHERE product_category_id = '$product_category' ORDER BY type_name ASC");
	$data = '<option value="">----- Select -----</option>';
	while($row_sc = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$type_name = $row_sc['type_name'];
		$data = $data . '<option value="'.$id.'">'.$type_name.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="product_type2" id="product_type2" onchange="getProductName()" style="border:1px solid #CCC; width:150px; height:25px;">
		  '.$data.'
		</select>';
        else:
		echo '
		<select name="product_type2" id="product_type2" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">--- No Subcategory Found ---</option>
		</select>';
       endif;	
  }  
  
 elseif(!empty($product_type)){
	$ad_sc = mysql_query("select * from product WHERE product_type_id = '$product_type' ORDER BY product_name ASC");
	$data = '<option value="">----- Select -----</option>';
	while($row_sc = mysql_fetch_array($ad_sc)){
		$product_id           = $row_sc['product_id'];
		$product_name = $row_sc['product_name'];
		$data = $data . '<option value="'.$product_id.'">'.$product_name.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="product_id2" id="product_id2" style="border:1px solid #CCC; width:150px; height:25px;">
		  '.$data.'
		</select>';
   else:
		echo '
		<select name="product_id2" id="product_id2" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">----- No Product Found -----</option>
		</select>';
   endif;	
  }
else
{
echo "";
}
?>