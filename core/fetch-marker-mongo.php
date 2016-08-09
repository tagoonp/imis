<?php
// ini_set('memory_limit', '256M');
// ini_set('max_execution_time', 300);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET,POST');
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;
// $collection2 = $db->col_province;

// $evtArr = array();
// if($_POST['evt1']=='true'){
//   $evtArr[] = 25;
// }
//
// if($_POST['evt2']=='true'){
//   $evtArr[] = 23;
// }
//
// if($_POST['evt3']=='true'){
//   $evtArr[] = 24;
// }

// $evtArr = array(23,24,25); ---
//
// $strArr = array(
//   array('age' => array('$gte' => intval($_POST['sage']), '$lte' => intval($_POST['eage']))),
//   array('adate' => array('$gte' => $_POST['sdate'], '$lte' => $_POST['edate'])),
//   array('atype' => array('$in' => $evtArr))
// );

// $strArr = array(
//   array('age' => array('$gte' => intval($_POST['sage']), '$lte' => intval($_POST['eage']))),
//   array('adate' => array('$gte' => '2013-08-01', '$lte' => '2013-12-31')),
//   array('atype' => array('$in' => $evtArr))
// );
//
// $cursor = $collection->find(
//   array( '$and' =>
//     $strArr
//   )
// );
$cursor = $collection->find();

$cursor->limit(100);

$i = 0;
$return = '';
foreach ($cursor as $value2) {
  $return[$i]['num'] = 1;
  $return[$i]['prov'] = $value2['record_id'];
  $return[$i]['atype'] = $value2['atype'];
  $return[$i]['lat'] = $value2['lat'];
  $return[$i]['lng'] = $value2['lng'];
  $i++;
}

echo json_encode($return);
$mongodb->close();
?>
