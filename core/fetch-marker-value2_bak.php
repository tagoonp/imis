<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();


$strSQL = "SELECT count(*) numcount
          FROM td3s_linked_data_test a inner join td3s_changwat b
          on a.prov_id = b.Changwat
          WHERE
          a.atype != '0'
          and a.a_lat != ''
          and a.a_lng != ''
          and a.atype in ('1','2','3')
          GROUP BY a.atype ORDER BY a.atype";

$resultQuery = $db->select($strSQL,false,true);
//
$return = '';
for($i=0;$i<count($resultQuery);$i++){
  $return[$i]['numcount'] = $resultQuery[$i]['numcount'];
}

echo json_encode($return);
$db->disconnect();

?>
