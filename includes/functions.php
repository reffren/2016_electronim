<?php
include("includes/db.php");
$dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
function showXLS($target, $user_id) {
require('class/PHPExcel.php');
require_once('class/PHPExcel/IOFactory.php');

$target_file = $target; //"filefolder/file.xls";
  
$objPHPExcel = PHPExcel_IOFactory::load($target_file);

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    echo "<br>Загруженный ППР ".$worksheetTitle." имеет ";
    echo $nrColumns . ' колонки (A-' . $highestColumn . ') ';
    echo ' и ' . $highestRow . ' поля(ей).';
    echo '<br>Вы загрузили следующий документ: <table border="1"><tr>';
    for ($row = 1; $row <= $highestRow; ++ $row) {
		$work_name;
		$work_time;
        echo '<tr>';
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
			if($col==0) {
				$work_name = $val;
			} else {
				$work_time = $val;
			}
            echo '<td>' . $val; 
        }
		$query="INSERT INTO acsm_work(user_id, work_name, work_time) VALUES('$user_id', '$work_name', '$work_time')";
		$result=mysqli_query($dbc, $query);
        echo '</tr>';
    }
    echo '</table>';
}
}
?>