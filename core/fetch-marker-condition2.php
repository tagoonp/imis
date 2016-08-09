<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$ageStart = $_POST['ageStart'];
$ageEnd = $_POST['ageEnd'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$itemcb = $_POST['itemcb'];
$iscb = $_POST['iscb'];
$eventType = $_POST['eventtype'];
$eventString = implode("','" , $eventType);



$strSQL = "SELECT count(*) numcount, a.link_id id, a.prov_id province, a.district_id district, a.tumbon_id tumbon, a.a_lat lat, a.a_lng lng, a.place_detail name, a.atype atype
          FROM td3s_linked_data_test a
          WHERE
          a.atype != '0'
          and a.a_lat != ''
          and a.a_lng != ''
          and a.atype in ('".$eventString."')
          and a.adate between '".$dateStart."' and '".$dateEnd."'
          and a.pat_age between '".$ageStart."' and '".$ageEnd."'
          and a.is_is = '".$itemcb."'
          and a.is_items = '".$iscb."'
          GROUP BY a.a_lat, a.a_lng ORDER BY numcount desc";

$resultQuery = $db->select($strSQL,false,true);
//
$return = '';

for($i=0;$i<count($resultQuery);$i++){
  $return[$i]['numcount'] = $resultQuery[$i]['numcount'];
  $return[$i]['id'] = $resultQuery[$i]['id'];
  // $return[$i]['name'] = $resultQuery[$i]['name'];
  $return[$i]['lat'] = $resultQuery[$i]['lat'];
  $return[$i]['lng'] = $resultQuery[$i]['lng'];
  $return[$i]['atype'] = $resultQuery[$i]['atype'];
  $return[$i]['province'] = $resultQuery[$i]['province'];
  $return[$i]['district'] = $resultQuery[$i]['district'];
  $return[$i]['tumbon'] = $resultQuery[$i]['tumbon'];
}

echo json_encode($return);
// echo json_encode($strSQL);
$db->disconnect();

?>
