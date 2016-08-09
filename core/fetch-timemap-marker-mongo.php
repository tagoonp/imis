<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);

$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;

$evtArr = array(23,24,25);

$cursor = $collection->find(array('atype' => array('$in' => $evtArr)));
$cursor->limit(100);

// var_dump($cursor);
// exit();

$i = 0;
$return = '';
foreach ($cursor as $value) {
  // var_dump($value);
  // print "<br>";
  $locationArr = array();

  $locationArr['lat'] = $value['lat'];
  $locationArr['lon'] = $value['lng'];

  $date = new DateTime($value['adate']);
  // $tomorr = date($date, strtotime('+2 days'));
  $tomorr = $date->modify('+1 day');

  $return[$i]['start'] = $value['adate'];
  $return[$i]['end'] = $tomorr->format('Y-m-d');
  $return[$i]['point'] = $locationArr;

  $return[$i]['title'] = $value['prov_name'];

  $optValue = array();
  if($value['atype']==25){
    $optValue['theme'] = "red";
  }else if($value['atype']==23){
    $optValue['theme'] = "blue";
  }else if($value['atype']==24){
    $optValue['theme'] = "orange";
  }

  $return[$i]['options'] = $optValue;
  $i++;
}

// echo json_encode($return);

// $strSQL = "SELECT * FROM link_data_table WHERE lat != '' and lng != '' and atype in ('23', '24', '25')";

// $resultQuery = $db->select($strSQL,false,true);
// //
// $return = '';
//
// for($i=0;$i<count($resultQuery);$i++){
//   $locationArr = array();
//
//   $locationArr['lat'] = $resultQuery[$i]['lat'];
//   $locationArr['lon'] = $resultQuery[$i]['lng'];
//
//   $date = new DateTime($resultQuery[$i]['adate']);
//   // $tomorr = date($date, strtotime('+2 days'));
//   $tomorr = $date->modify('+1 day');
//
//   $return[$i]['start'] = $resultQuery[$i]['adate'];
//   $return[$i]['end'] = $tomorr->format('Y-m-d');
//   $return[$i]['point'] = $locationArr;
//   // $return[$i]['title'] = $resultQuery[$i]['name'];
//
//   $strSQL = "SELECT Name FROM td3s_tumbon WHERE Changwat = '".$resultQuery[$i]['prov_id']."' and Ampur = '".$resultQuery[$i]['district_id']."' and Tumbon = '".$resultQuery[$i]['tumbon_id']."'";
//   $resultTumbon = $db->select($strSQL,false,true);
//   if($resultTumbon){
//     $return[$i]['title'] = $resultTumbon[0]['prov_name'];
//   }else{
//     $return[$i]['title'] = $resultQuery[$i]['prov_name'];
//   }
//
//   $optValue = array();
//   if($resultQuery[$i]['atype']==25){
//     $optValue['theme'] = "red";
//   }else if($resultQuery[$i]['atype']==23){
//     $optValue['theme'] = "blue";
//   }else if($resultQuery[$i]['atype']==24){
//     $optValue['theme'] = "orange";
//   }
//
//   $return[$i]['options'] = $optValue;
// }

echo json_encode($return);
// echo json_encode($strSQL);
// $db->disconnect();

?>
