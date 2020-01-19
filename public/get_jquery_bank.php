<?php
include 'db.php';

$bank_id = $_GET['bank_id'];
$bank_id2 = $_GET['bank_id2'];
$account_no = $_GET['account_no'];
$account_no2 = $_GET['account_no2'];
$expense_type_id = $_GET['expense_type_id'];
$d_bank_id = $_GET['d_bank_id'];
$d_account_no = $_GET['d_account_no'];
$cashval = $_GET['cashval'];

if(!empty($expense_type_id)){
	$ad_sc = mysql_query("select * from expense_name WHERE expense_type_id = '$expense_type_id' ORDER BY expense_name ASC");
	$data = '<option value="">----- Select -----</option>';
	while($row_sc  = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$expense_name = $row_sc['expense_name'];
		$data = $data . '<option value="'.$id.'">'.$expense_name.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="expense_name_id" id="expense_name_id"  style="border:1px solid #CCC; width:200px; height:25px;">
		  '.$data.'
		</select>';
        else:
		echo '
		<select name="expense_name_id" id="expense_name_id" style="border:1px solid #CCC; width:200px; height:25px;">
		  <option value="">--- No Expense Found ---</option>
		</select>';
       endif;	
  }  

elseif(!empty($bank_id)){
	$ad_sc = mysql_query("select * from bank_account WHERE bank_id = '$bank_id' ORDER BY account_no ASC");
	$data = '<option value="">----- Select -----</option>';
	while($row_sc  = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$account_no = $row_sc['account_no'];
		$data = $data . '<option value="'.$id.'">'.$account_no.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="account_no" id="account_no"  style="border:1px solid #CCC; width:150px; height:27px;">
		  '.$data.'
		</select>';
        else:
		echo '
		<select name="account_no" id="account_no" style="border:1px solid #CCC; width:150px; height:27px;">
		  <option value="">--- No Account Found ---</option>
		</select>';
       endif;	
  }  

elseif(!empty($bank_id2)){
	$ad_sc = mysql_query("select * from bank_account WHERE bank_id = '$bank_id2' ORDER BY account_no ASC");
	$data = '<option value="">----- Select -----</option>';
	while($row_sc  = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$account_no = $row_sc['account_no'];
		$data = $data . '<option value="'.$id.'">'.$account_no.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="account_no" id="account_no"  style="border:1px solid #CCC; width:200px; height:25px;" onchange="getChequeNo()">
		  '.$data.'
		</select>';
        else:
		echo '
		<select name="account_no" id="account_no" style="border:1px solid #CCC; width:200px; height:25px;" onchange="getChequeNo()">
		  <option value="">--- No Account Found ---</option>
		</select>';
       endif;	
  }  

elseif(!empty($account_no)){
	$ad_sc = mysql_query("select * from bank_cheque WHERE account_no = '$account_no' && status ='unused' ORDER BY cheque_no ASC");
	$ad_sc2 = mysql_query("select balance from cash_in_bank WHERE account_no = '$account_no'");
		
		if(@mysql_num_rows($ad_sc2)== 0){ $mess = "<font color='#FF5918'>Selectd account balance=0</font>"; $mess2 = 0;}
		else {
            while($row_sc2  = @mysql_fetch_array($ad_sc2)){
                $amount = $row_sc2['balance'];
             }
           $mess =  "<font color='#FF5918'>Selected Account Balance =$amount</font>";
		   $mess2 = $amount;
          }
	$data = '<option value="">Select Cheque No</option>';
	while($row_sc  = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$cheque_no = $row_sc['cheque_no'];
		$data = $data . '<option value="'.$id.'">'.$cheque_no.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="cheque_no" id="cheque_no"  style="border:1px solid #CCC; width:200px; height:25px;">
		  '.$data.'
		</select>'.'-'.$mess.'-'.$mess2;
        else:
		echo '
		<select name="cheque_no" id="cheque_no" style="border:1px solid #CCC; width:200px; height:25px;">
		  <option value="">No Cheque No Found</option>
		</select>'.'-'.$mess.'-'.$mess2;
       endif;	
  }  
elseif(!empty($account_no2)){
    
	$ad_sc = mysql_query("select * from bank_cheque WHERE account_no = '$account_no2' && status ='unused' ORDER BY cheque_no ASC");
	$data = '<option value="">Select Cheque No</option>';
	while($row_sc  = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$cheque_no = $row_sc['cheque_no'];
		$data = $data . '<option value="'.$id.'">'.$cheque_no.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="cheque_no" id="cheque_no"  style="border:1px solid #CCC; width:200px; height:25px;">
		  '.$data.'
		</select>';
        else:
		echo '
		<select name="cheque_no" id="cheque_no" style="border:1px solid #CCC; width:200px; height:25px;">
		  <option value="">No Cheque No Found</option>
		</select>';
       endif;	
  }  
elseif(!empty($d_bank_id)){
	$ad_sc = mysql_query("select * from bank_account WHERE bank_id = '$d_bank_id' ORDER BY account_no ASC");
	$data = '<option value="">----- Select -----</option>';
	while($row_sc  = @mysql_fetch_array($ad_sc)){
		$id        = $row_sc['id'];
		$account_no = $row_sc['account_no'];
		$data = $data . '<option value="'.$id.'">'.$account_no.'</option>';	
	}
	if(mysql_num_rows($ad_sc) > 0):
		echo '
		<select name="d_account_no" id="d_account_no"  style="border:1px solid #CCC; width:200px; height:25px;" onchange="getAccountBalance()">
		  '.$data.'
		</select>';
        else:
		echo '
		<select name="d_account_no" id="d_account_no" style="border:1px solid #CCC; width:200px; height:25px;" onchange="getAccountBalance()">
		  <option value="">--- No Account Found ---</option>
		</select>';
       endif;	
  }  

elseif(!empty($d_account_no)){
	    
		$ad_sc2 = mysql_query("select balance from cash_in_bank WHERE account_no = '$d_account_no'");		
		if(@mysql_num_rows($ad_sc2)== 0){ $mgr = 0; echo "<font color='#FF5918'>Selectd account balance=0</font>".'-'.$mgr; }
		else {
            while($row_sc2  = @mysql_fetch_array($ad_sc2)){
                $amount = $row_sc2['balance'];
				$mgr = $amount;
             }
           echo "<font color='#FF5918'>Selected Account Balance =$amount</font>".'-'.$mgr;
          }
   } 
elseif(!empty($cashval)){
	    
		$ad_sc2 = mysql_query("select amount from cash_in_hand ORDER BY id DESC LIMIT 1");		
		if(@mysql_num_rows($ad_sc2)== 0){ $mgr = 0; echo "<font color='#FF5918'>Total Cash Balance = 0</font>".'-'.$mgr; }
		else {
            while($row_sc2  = @mysql_fetch_array($ad_sc2)){
                $amount = $row_sc2['amount'];
				$mgr = $amount;
             }
           echo "<font color='#FF5918'>Total Cash Balance = $amount</font>".'-'.$mgr;
          }
   }  
else
{
echo "";
}
?>