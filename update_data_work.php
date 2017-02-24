<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
$i=0;
if($_POST[$i]) {
  while(isset($_POST[$i])) {
    $id = $_POST[$i];
    $i++;
    $work_date = $_POST[$i];
    $i++;		
    $work_state = $_POST[$i];
    $i++;		
    $work_end_time = $_POST[$i];
	$i++;		
    $work_check = $_POST[$i];
	$i++;		
    $work_date_check = $_POST[$i];
    $i++;	
    $work_date_downloaded = $_POST[$i];
    $i++;	
    $query_index="UPDATE acsm_work SET work_date='$work_date', work_state='$work_state', work_end_time='$work_end_time', work_check='$work_check', work_date_check='$work_date_check', work_date_downloaded='$work_date_downloaded' WHERE id='$id';";
    $data_index=mysqli_query($dbc, $query_index);
  }
}
?>