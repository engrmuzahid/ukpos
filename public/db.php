<?php
//error_reporting(E_ALL ^E_DEPRECATED ^E_NOTICE);
$host = "localhost";
$username = "root";
$password = "mysql";
$dbname = "sylhet_pos_12_13";

//$username = "sylhetsh_user";
//$password = "UKp0smain";
//$dbname = "sylhetsh_pos_main";

$con = mysql_connect($host, $username, $password) or die("Can't connect to database server");

//select the db
mysql_select_db($dbname, $con);