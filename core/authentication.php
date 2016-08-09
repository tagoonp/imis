<?php
session_start();
require ("../configuration/connect.class.php");
$db = new database();
$db->connect();
$sessionName = $db->getSessionname();
// function for checking user account //
// $strSQL = sprintf("SELECT * FROM ".$prefix."user WHERE username = '%s' and active_status = '%s'",mysql_real_escape_string($_POST['username']),mysql_real_escape_string('Yes'));
$strSQL = sprintf("SELECT * FROM dsw1_user WHERE username = '%s' and password = '%s' and active_status = '%s'",mysql_real_escape_string($_POST['username']),mysql_real_escape_string(md5($_POST['password'])),mysql_real_escape_string('Yes'));
$resultAuthen = $db->select($strSQL,false,true);

if($resultAuthen){
  // Verify password
    $_SESSION[$sessionName.'sessID'] = session_id();
  	$_SESSION[$sessionName.'sessUsername'] = $resultAuthen[0]['username'];
    $_SESSION[$sessionName.'sessUtype'] = $resultAuthen[0]['usertype_id'];
  	session_write_close();
    print "Y";
  // }else{
  //   print "N1";
  // }
}else{
  print "N";
  print $strSQL;
}

$db->disconnect();



?>
