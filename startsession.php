<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  if (isset($_COOKIE['user_id']) && isset($_COOKIE['name'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['name'] = $_COOKIE['name'];
  }
}
?>