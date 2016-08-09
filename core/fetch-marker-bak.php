<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();
//
// $strSQL = "SELECT count(*) numcount, a.prov_id province_id, b.Changwat_lat Changwat_lat, b.Changwat_lng Changwat_lng, b.Name province_name FROM td3s_linked_data a inner join td3s_changwat b
//           on a.prov_id = b.Changwat
//           WHERE 1 GROUP BY a.prov_id ORDER BY numcount desc";

// $strSQL = "SELECT count(*) numcount, a.prov_id id, b.Changwat_lat lat, b.Changwat_lng lng, b.Name name FROM td3s_linked_data a inner join td3s_changwat b
//           on a.prov_id = b.Changwat
//           WHERE 1 GROUP BY a.prov_id ORDER BY numcount desc";

$strSQL = "SELECT count(*) numcount, a.prov_id id, b.Changwat_lat lat, b.Changwat_lng lng, b.Name name
          FROM td3s_linked_data_test a inner join td3s_changwat b
          on a.prov_id = b.Changwat
          WHERE
          a.atype != '0'
          and a.a_lat != ''
          and a.a_lng != ''
          and a.atype in ('1','2','3')
          GROUP BY a.prov_id ORDER BY numcount desc";

$resultQuery = $db->select($strSQL,false,true);
//
$return = '';
for($i=0;$i<count($resultQuery);$i++){
  $return[$i]['numcount'] = $resultQuery[$i]['numcount'];
  $return[$i]['id'] = $resultQuery[$i]['id'];
  $return[$i]['name'] = $resultQuery[$i]['name'];
  $return[$i]['lat'] = $resultQuery[$i]['lat'];
  $return[$i]['lng'] = $resultQuery[$i]['lng'];
}

echo json_encode($return);
$db->disconnect();

?>
