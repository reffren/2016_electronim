<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
$query_id_work="SELECT id_work FROM acsm_brig;"; 
$data_id_work=mysqli_query($dbc, $query_id_work);
$work_array=array();
while($row=mysqli_fetch_array($data_id_work)) {
  array_push($work_array, $row['id_work']);
}
$i=0;
$seven;
if($_POST[$i]) {
  while(isset($_POST[$i])) {
	$clue=0;
    $otv_ruk_name = $_POST[$i];
    $i++;
    $nablyoud_name = $_POST[$i];
    $i++;		
    $dopusk_name = $_POST[$i];
    $i++;		
    $proizv_name = $_POST[$i];
    $i++;		
    $vidayoush_name = $_POST[$i];
    $i++;		
    $brigada_name = $_POST[$i];
    $i++;	
    if(mysqli_num_rows($data_id_work)>0) {	
	  foreach($work_array as $id_work) {
	    $work_id = $_POST[$i];
	      if($id_work == $work_id) {
	        $clue=1;
		  } 
	  }
	} else {$work_id = $_POST[$i];}
	$i++;
	  if($clue==0) {
        $query_index="insert into acsm_brig (otv_ruk_name, nablyoud_name, dopusk_name, proizv_name, vidayoush_name, brigada_name, id_work) values('$otv_ruk_name', '$nablyoud_name', '$dopusk_name', '$proizv_name', '$vidayoush_name', '$brigada_name', '$work_id');";
        $data_index=mysqli_query($dbc, $query_index);
	 }
  }
}
?>