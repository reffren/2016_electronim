<?php
include("includes/db.php");
$page_title = 'Авторизация';
$error_msg = "";
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($dbc,"SET NAMES 'utf8'");
session_destroy();
if(!isset($_SESSION['user_id']))  {
    if(isset($_POST['entrance']))  {
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $entlogin = mysqli_real_escape_string($dbc, trim($_POST['entlogin']));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        if(!empty($entlogin) && !empty($password)) {
          $query = "SELECT user_id, name, name FROM acsm_users WHERE name = '$entlogin' AND pass = '$password'";
          mysqli_query($dbc,"SET NAMES 'utf8'");         
          $data = mysqli_query($dbc, $query);
            if(mysqli_num_rows($data)==1) {
              $row = mysqli_fetch_array($data);
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION['name'] = $row['name'];
              setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
              setcookie('name', $row['name'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
              $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'upload';
              header('Location: ' . $home_url);
              mysqli_close($dbc);
              exit();
            }  
            else  {
              $els1 = 1;
            }
          
          }
            else  {
              $els1 = 2;
            }
        }
}

mysqli_close($dbc);
require_once('header.php');

?>
<div id="entrance">
  <form method="post" action="<?php echo dirname($_SERVER['PHP_SELF']); ?>">
    <table>
      <tr>
        <th colspan="2" class="orange">Для зарегистрированных пользователей.</th>
        <th></th>
      </tr>
<?php
switch($els1) {
case 1:
      echo '<tr>';
      echo '<th colspan="2"><p class = "error">Пароль не верен или пользователь не существует</p></th>';
      echo '<th></th>';
      echo '</tr>';
break;
case 2:
      echo '<tr>';
      echo '<th colspan="2"><p class = "error">Необходимо ввести логин и пароль</p></th>';
      echo '<th></th>';
      echo '</tr>';
break;
default:
}
?>
      <tr>
        <th colspan="2" class="th">Введите логин и пароль для входа.</th>
        <th></th>
      </tr>
      <tr>
        <td colspan="2" class="th">Логин (Эл. почта):<br /><input type="text" id ="entlogin" name="entlogin" size="50" value="<?php echo $entlogin; ?>" /></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2" class="th">Пароль:<br /><input type="password" id="password" name="password" size="50" /></td>
        <td></td>
      </tr>
      <tr>
        <td id="submitright"> <input type="submit" name="entrance" value="Войти"/></td>
        <td id="forgetpass"><a>Забыли пароль?</a></td>
      </tr>
    </table>
  </form>
</div> 
<?php
  require_once('footer.php');
?>