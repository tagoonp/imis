<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

// $strSQL = "SELECT a.link_id id, a.adate adate, a.atime atime, a.a_lat lat,b.Changwat_lat cwlat, b.Changwat_lng cwlng, a.a_lng lng, b.name name, a.atype atype
//           FROM td3s_linked_data_test a inner join td3s_changwat b
//           on a.prov_id = b.Changwat
//           WHERE
//           a.atype != '0'
//           and a.a_lat != ''
//           and a.a_lng != ''
//           and a.atype in ('1','2','3')
//           GROUP BY a.a_lat, a.a_lng
//           ";

$strSQL = "SELECT a.link_id id, a.adate adate, a.atime atime, a.a_lat lat, a.prov_id prov_id, a.district_id district_id, a.tumbon_id tumbon_id, b.Changwat_lat cwlat, b.Changwat_lng cwlng, a.a_lng lng, b.name name, a.atype atype
          FROM td3s_linked_data_test a inner join td3s_changwat b ON a.prov_id = b.Changwat
          WHERE
          a.atype != '0'
          and a.a_lat != ''
          and a.a_lng != ''
          and a.atype in ('1','2','3')
          GROUP BY a.a_lat, a.a_lng ";

$resultQuery = $db->select($strSQL,false,true);
//
$return = '';

for($i=0;$i<count($resultQuery);$i++){
  $locationArr = array();

  $locationArr['lat'] = $resultQuery[$i]['cwlat'];
  $locationArr['lon'] = $resultQuery[$i]['cwlng'];

  $date = new DateTime($resultQuery[$i]['adate']);
  // $tomorr = date($date, strtotime('+2 days'));
  $tomorr = $date->modify('+1 day');

  $return[$i]['start'] = $resultQuery[$i]['adate'];
  $return[$i]['end'] = $tomorr->format('Y-m-d');
  $return[$i]['point'] = $locationArr;
  // $return[$i]['title'] = $resultQuery[$i]['name'];

  $strSQL = "SELECT Name FROM td3s_tumbon WHERE Changwat = '".$resultQuery[$i]['prov_id']."' and Ampur = '".$resultQuery[$i]['district_id']."' and Tumbon = '".$resultQuery[$i]['tumbon_id']."'";
  $resultTumbon = $db->select($strSQL,false,true);
  if($resultTumbon){
    $return[$i]['title'] = $resultTumbon[0]['Name'];
  }else{
    $return[$i]['title'] = $resultQuery[$i]['name'];
  }

  $optValue = array();
  if($resultQuery[$i]['atype']==1){
    $optValue['theme'] = "red";
  }else if($resultQuery[$i]['atype']==2){
    $optValue['theme'] = "blue";
  }else if($resultQuery[$i]['atype']==3){
    $optValue['theme'] = "orange";
  }

  $return[$i]['options'] = $optValue;
}

echo json_encode($return);
// echo json_encode($strSQL);
$db->disconnect();

?>
