<?php
// ini_set('memory_limit', '256M');
// ini_set('max_execution_time', 300);

$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;
$collection2 = $db->col_province;

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

// $strArr = array(
//   array('age' => array('$gte' => intval($_POST['sage']), '$lte' => intval($_POST['eage']))),
//   array('adate' => array('$gte' => $_POST['sdate'], '$lte' => $_POST['edate'])),
//   array('atype' => array('$in' => $evtArr))
// );

$strArr = array(
  array('age' => array('$gte' => intval(0), '$lte' => intval(100))),
  array('adate' => array('$gte' => '2013-01-01', '$lte' => '2013-12-31')),
  array('atype' => array('$in' => array(23,24,25)))
);

$cursor = $collection->group(
  array('province' => true), // fields to group by
  array('count' => 0), // initial value of the aggregation counter object.
  new MongoCode('function(doc, prev) { prev.count += 1 }'), // a function that takes two arguments (the current document and the aggregation to this point) and does the aggregation
  // array('age' => array('$gte' => intval($_POST['sage'])))
  array( '$and' =>
    $strArr
  )
);

$i = 0;
$return = '';
foreach ($cursor['retval'] as $item){

  $cursor2 = $collection2->find(array("Changwat" => $item['province']));

  foreach ($cursor2 as $key2 => $value2) {
    $return[$i]['num'] = $item['count'];
    $return[$i]['prov'] = $value2['Changwat'];
    $return[$i]['lat'] = $value2['Changwat_lat'];
    $return[$i]['lng'] = $value2['Changwat_lng'];
    $i++;
  }
}

echo json_encode($return);

?>
