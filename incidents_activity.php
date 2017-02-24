<?php
include("includes/db.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
if(isset($_POST['image']) && isset($_POST['filename']) && isset($_POST['nameFolder'])) {

  $image = $_POST['image'];
  $file_name = $_POST['filename'];
  $folder = $_POST['nameFolder']; //имя пользователя
  $comment = $_POST['comment'];

    if (!file_exists("images/".$folder."")) { //проверяем существует ли требуемая директория или файл
      mkdir("images/".$folder.""); //создаем папку
      }  
  $path = 'images/'.$folder.'/'.$file_name.'.png';
  file_put_contents($path, base64_decode($image));
  
  $query="insert into acsm_incidents (user_name, comment, image_way) values('$folder', '$comment', '$path');";
  $data=mysqli_query($dbc, $query);
  echo "Данные успешно отправены";
  }else{
echo "Не удалось отправить данные";
}
?>