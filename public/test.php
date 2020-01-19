<?php
 

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "123456";
$DB_NAME = "sylhet_pos";

$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($con->connect_errno > 0) {
    die('Connection failed [' . $con->connect_error . ']');
}

//$tableName = 'customer';
//$backupFile = 'backup/mysql.sql';
//$query = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";


$jsonObj = array();


$query = "SELECT * FROM customer";
$sql = mysqli_query($con, $query) or die('Connection failed [' . $con->connect_error . ']');

print_r($query);
while ($data = mysqli_fetch_assoc($sql)) {
    array_push($jsonObj, $data);
    
print_r($data);
}

exit();
$set['customer'] = $jsonObj;

header('Content-Type: application/json; charset=utf-8');
echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
die();
//$result = mysqli_query($con, $query);
