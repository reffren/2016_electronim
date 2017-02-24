<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
$user_key="instruction";
if(isset($_POST[$user_key])) {
  $id = mysqli_real_escape_string($dbc, trim($_POST[$user_key]));
  $v= "Урра все работает прекрасно!!!";
    $query_index="INSERT INTO test(test) VALUES('$id')";
    $data_index=mysqli_query($dbc, $query_index);
} else {
	$s= "Ничего не работает!!!";
	    $query_index="INSERT INTO test(test) VALUES('$s')";
    $data_index=mysqli_query($dbc, $query_index);
}
?>