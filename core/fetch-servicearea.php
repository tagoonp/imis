<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$strSQL = "SELECT *
          FROM td3s_servicearea
          WHERE sa_status = 'Yes'";
$resultQuery = $db->select($strSQL,false,true);

$return = '';
for($i=0;$i<count($resultQuery);$i++){
  $return[$i]['sa_id'] = $resultQuery[$i]['sa_id'];
  $return[$i]['sa_name'] = $resultQuery[$i]['sa_name'];
}

echo json_encode($return);
$db->disconnect();

?>
