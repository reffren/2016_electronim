<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
$user_key="user_id";

if(isset($_POST[$user_key])) {
  $id = mysqli_real_escape_string($dbc, trim($_POST[$user_key]));
  $sql = "select id, work_name, work_time from acsm_work where user_id='$id'";
  $data = mysqli_query($dbc, $sql);
  }

$result = array();
 
while($row = mysqli_fetch_array($data)){
  array_push($result,
  array('id'=>$row[0],
  'work_name'=>$row[1],
  'work_time'=>$row[2]
  ));
}

$encoded = json_encode(array("result"=>$result));
echo $unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
    return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
}, $encoded);

//echo json_encode(array("result"=>$result)); не работает в php 5.3, но в php 5.4 решается добавлением вторым параметром JSON_UNESCAPED_UNICODE = json_encode($str, JSON_UNESCAPED_UNICODE);
 
mysqli_close($dbc);
?>