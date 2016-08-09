<?php
session_start();

require ("../configuration/connect.class.php");
$db = new database();
$db->connect();
$sessionName = $db->getSessionname();

if(isset($_SESSION[$sessionName.'sessID'])){
  switch($_SESSION[$sessionName.'sessUtype']){
    case 1: header('Location: ../usr/administrator/'); break;
    case 2: header('Location: ../usr/leader/'); break;
    case 3: header('Location: ../institute_coordinator/'); break;
    case 4: header('Location: ../usr/field_coordinator/'); break;
    case 5: header('Location: ../usr/common/'); break;
    default: header('Location: ../500-page.html'); break;
  }
}else{
  header('Location: signout.php');
  exit();
}
?>
