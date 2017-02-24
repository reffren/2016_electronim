<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
$regex="/^\d{6}$/"; // регулярное выражение соответствующее только 6 любым цифрам, как например 201603
  if(isset($_POST['out']))  { // проверяем была ли нажата кнопка "выгрузить"
    $id = mysqli_real_escape_string($dbc, trim($_POST['user_id']));
    $ppr_date = mysqli_real_escape_string($dbc, trim($_POST['ppr_date']));
	$file_name = mysqli_real_escape_string($dbc, trim($_POST['filename'])); // File Name
	$file_name .= ".xls";
	  if(preg_match($regex, $ppr_date)) { //если ввод цифр правильный, то продолжаем
	$sql = "select work_name, work_time, work_end_time from acsm_work where work_date_downloaded='201603' AND user_id='2'";
	$user_query = mysqli_query($dbc, $sql);

	  	// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=" .$file_name);
?>
<table border="1">
    <tr>
    	<th>№</th>
		<th>Наименование работы</th>
		<th>Всего по плану</th>
		<th>Факт чел.ч.</th>
	</tr>
	<?php
$no = 1;
while ($data = mysqli_fetch_array($user_query)) {
		echo '
		<tr>
			<td>'.$no.'</td>
			<td>'.$data['work_name'].'</td>
			<td>'.$data['work_time'].'</td>
			<td>'.$data['work_end_time'].'</td>
		</tr>
		';
		$no++;
    }
  }
 echo '<p class = "error">Некорректная дата, пожалуйста введите дату в формате "201601", где 2016 - год, 01 - месяц, и <a href="upload.php">повторите попытку</a>!</p>';
}
?>