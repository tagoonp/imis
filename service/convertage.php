<?php
ini_set('memory_limit', '-1');
require ("../configuration/connect.class.php");
$db = new database();
$db->connect();
// $sessionName = $db->getSessionname();

$strSQL = "SELECT * FROM link_data_table WHERE 1";
$result = $db->select($strSQL,false,true);

if($result){
  foreach ($result as $value) {
    if(is_numeric($value['age'])){

    }else{
      $strSQL = "UPDATE link_data_table SET age = '-1' WHERE record_id = '".$value['record_id']."'";
      $res = $db->update($strSQL);
    }
  }
}

$c = 0;

// if($result){
//   foreach ($result as $value) {
//     if(is_numeric($value['age'])){
//
//     }else{
//       $c++;
//     }
//   }
// }
//
// print $c;
// print "asd";
 ?>
