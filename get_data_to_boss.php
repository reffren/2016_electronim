<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
$sql = "select acsm_work.id, acsm_work.user_id, acsm_work.work_name, acsm_work.work_state, acsm_work.work_check, acsm_work.work_date_check, acsm_users.name_department from acsm_work inner join acsm_users using (user_id)";
$data = mysqli_query($dbc, $sql);
 
$result = array();
 
while($row = mysqli_fetch_array($data)){
array_push($result,
array('id'=>$row[0],
'user_id'=>$row[1],
'work_name'=>$row[2],
'work_state'=>$row[3],
'work_check'=>$row[4],
'work_date_check'=>$row[5],
'name_department'=>$row[6],
));
}
$encoded = json_encode(array("result"=>$result));
echo $unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
    return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
}, $encoded);

//echo json_encode(array("result"=>$result)); не работает в php 5.3, но в php 5.4 решается добавлением вторым параметром JSON_UNESCAPED_UNICODE = json_encode($str, JSON_UNESCAPED_UNICODE);
 
mysqli_close($dbc);
 
?>