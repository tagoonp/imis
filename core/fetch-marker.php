<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// include "../configuration/connect.class.php";
// $db = new database();
// $db->connect();
//
// $strSQL = "SELECT count(*) numcount, a.prov_id province_id, b.Changwat_lat Changwat_lat, b.Changwat_lng Changwat_lng, b.Name province_name FROM td3s_linked_data a inner join td3s_changwat b
//           on a.prov_id = b.Changwat
//           WHERE 1 GROUP BY a.prov_id ORDER BY numcount desc";

// $strSQL = "SELECT count(*) numcount, a.prov_id id, b.Changwat_lat lat, b.Changwat_lng lng, b.Name name FROM td3s_linked_data a inner join td3s_changwat b
//           on a.prov_id = b.Changwat
//           WHERE 1 GROUP BY a.prov_id ORDER BY numcount desc";

// $strSQL = "SELECT count(*) numcount, a.prov_id id, b.Changwat_lat lat, b.Changwat_lng lng, b.Name name
//           FROM td3s_linked_data_test a inner join td3s_changwat b
//           on a.prov_id = b.Changwat
//           WHERE
//           a.atype != '0'
//           and a.a_lat != ''
//           and a.a_lng != ''
//           and a.atype in ('1','2','3')
//           GROUP BY a.prov_id ORDER BY numcount desc";
//
// $resultQuery = $db->select($strSQL,false,true);
// //
// $return = '';
// for($i=0;$i<count($resultQuery);$i++){
//   $return[$i]['numcount'] = $resultQuery[$i]['numcount'];
//   $return[$i]['id'] = $resultQuery[$i]['id'];
//   $return[$i]['name'] = $resultQuery[$i]['name'];
//   $return[$i]['lat'] = $resultQuery[$i]['lat'];
//   $return[$i]['lng'] = $resultQuery[$i]['lng'];
// }

$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;
$collection2 = $db->col_province;
$cursor = $collection->find();
$cursor->limit(1000);

$return = '';
// for($i=0;$i<count($cursor);$i++){
//   // $return[$i]['numcount'] = $cursor[$i]['numcount'];
//   // $return[$i]['id'] = $cursor[$i]['id'];
//   $return[$i]['name'] = $cursor[$i]['prov_name'];
//   $return[$i]['lat'] = $cursor[$i]['lat'];
//   $return[$i]['lng'] = $cursor[$i]['lng'];
// }

$i = 0;
$result;
foreach ($cursor as $key => $value) {
  // echo $value['record_id'].". ".$value['adate']." ".$value['atime']." จังหวัด".$value['prov_name']." อำเภอ".$value['dist_name']."<br>";
  // $return[$i]['name'] = $value['prov_name'];
  // $return[$i]['lat'] = $value['lat'];
  // $return[$i]['lng'] = $value['lng'];
  //
  // // $cursor2 = $collection2->find(array("Changwat" => $value['province']));
  // $cursor2 = $collection->find(array("Changwat" => "ลำปาง"));
  //
  // // echo sizeof($cursor2);
  // // $return[$i]['Changwat_lat'] = $cursor2[0]['Changwat_lat'];
  // // $return[$i]['Changwat_lng'] = $cursor2[0]['Changwat_lng'];
  // foreach ($cursor2 as $key2 => $value2) {
  //   $return[$i]['name2'] = $value2['Name'];
  //   $return[$i]['Changwat_lat'] = $value2['Changwat_lat'];
  //   $return[$i]['Changwat_lng'] = $value2['Changwat_lng'];
  //   echo $value2['Name']." ".$value2['Changwat_lat'].", ".$value2['Changwat_lng ']."<br>";
  //   // break;
  // }
  // $i++;
  $result[] = $value['province'];
  // print $value['province']."<br>";
}

// print sizeof($result);

foreach ($result as $value) {
  $cursor2 = $collection2->find(array("Changwat" => $value));
  foreach ($cursor2 as $key2 => $value2) {
    $return[$i]['name'] = $value2['Name'];
    $return[$i]['Changwat_lat'] = $value2['Changwat_lat'];
    $return[$i]['Changwat_lng'] = $value2['Changwat_lng'];
    // echo $value2['Name']." ".$value2['Changwat_lat'].", ".$value2['Changwat_lng']."<br>";
    $i++;
  }
}
echo json_encode($return);
// $db->disconnect();

?>
