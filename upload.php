<?php
require_once('startsession.php');
if(isset($_SESSION['name']))  {
  $user_id = $_SESSION['user_id'];
  header('Content-Type: text/html; charset=UTF-8');
  require_once('header.php');
  include("includes/file_name.php");
  include("includes/functions.php"); 
    if(isset($_POST['save']))  {
      $file=$_FILES['file']['name']; //извлекаем файл из формы
      $file_type=$_FILES['file']['type']; //извлекаем тип файла, для последующей проверки
      if (!file_exists("excel/".$user_id."")) { //проверяем существует ли требуемая директория или файл
        mkdir("excel/".$user_id.""); //создаем папку
      }  
      $target=GW_UPLOADPATH.$user_id."/".$file; //ссылка на папку img
	  if ($_FILES['file']['error']==0) { // проверяем не было ли ошибки при загрузке файла
        if($file_type=='application/vnd.ms-excel') { // проверяем соответсвует ли загруженный файл типу документа Microsoft Excel
          if(move_uploaded_file($_FILES['file']['tmp_name'],$target)) {// здесь перемещаем файл из временного хранилища в папку img 
            showXLS($target, $user_id);
          } else { echo "Не удалось загрузить файл, пожалуйста обратитесь к администратору";}
        } else {
          echo 'Загружаемый файл не соответствует типу документа Excel, пожалуйста загрузите документ Microsoft Excel и повторите попытку';
          }
	  } else {
		  echo 'Произошла ошибка при загрузке файла (возможно не выбрали файл), пожалуйста повторите попытку или обратитесь к администратору';
	  }
    }
$query = "select name_department from acsm_users where user_id='$user_id'";
$result = mysqli_query($dbc, $query); 
//if(mysqli_num_rows($result)==1) {
$row = mysqli_fetch_array($result);
$filename=$row['name_department'];
//}
?>
<div class="exit">
<a href="logout.php">Выход</a>
</div>
<div id="file_upload">
<p>Загрузка/выгрузка ведомости ППР</p>
<form enctype="multipart/form-data" method="post" action="<?php echo dirname($_SERVER['PHP_SELF']) . 'upload'; ?>">
<input type="file" id="file" name="file" />
<input type="submit" value="Сохранить ППР" name="save" />
</form>
<div id="out">
<form enctype="multipart/form-data" method="post" action="http://electronim.ru/out.php">
<?php echo '<input type="hidden" id ="filename" name="filename" value=' . $filename . ' />';  // передаем file_name в out.php для имени ппр ?>
<input type="hidden" id ="user_id" name="user_id" value=".$user_id." /> <?php // передаем user_id в out.php для выгрузки определенного ппр для определенного id ?>
<input type="text" id ="ppr_date" name="ppr_date" />
<input type="submit" value="Выгрузить ППР" name="out" />
</form>
</div>
</div>
<?php
}
?>
