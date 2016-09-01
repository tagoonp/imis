<?php
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;
$collection2 = $db->col_district;
// $retval = $collection->distinct("province");
$evtArr = array();
if($_POST['evt1']=='true'){
  $evtArr[] = 25;
}

if($_POST['evt2']=='true'){
  $evtArr[] = 23;
}

if($_POST['evt3']=='true'){
  $evtArr[] = 24;
}

$strArr = array(
  array('age' => array('$gte' => intval($_POST['sage']), '$lte' => intval($_POST['eage']))),
  array('adate' => array('$gte' => $_POST['sdate'], '$lte' => $_POST['edate'])),
  array('atype' => array('$in' => $evtArr))
);

// if($_POST['isdb']==true){
//   // $strArr[] = array('isid' => array('$ne' => ""));
// }else{
//   $strArr[] = array('isid' => "");
// }
//
// if($_POST['itemsdb']==true){
//   // $strArr[] = array('itemsid' => array('$ne' => 'NULL'));
// }else{
//   $strArr[] = array('itemsid' => "NULL");
// }

$cursor = $collection->group(
  array('province' => true, 'district' => true), // fields to group by
  array('count' => 0), // initial value of the aggregation counter object.
  new MongoCode('function(doc, prev) { prev.count += 1 }'), // a function that takes two arguments (the current document and the aggregation to this point) and does the aggregation
  // array('id' => array('$gt' => 200)) // condition for including a document in the aggregation
  array( '$and' =>
    $strArr
  )
);



$c = 1;
$return = '';


$i = 0;
foreach ($cursor['retval'] as $item){

  // print $item['province']." ".$item['district'];
  $cursor2 = $collection2->find(array("Changwat" => $item['province'], "Ampur" => $item['district']));

  foreach ($cursor2 as $key2 => $value2) {
    $return[$i]['num'] = $item['count'];
    // $return[$i]['name_string'] = "";
    $return[$i]['prov'] = $value2['Changwat'].",".$value2['Ampur'];
    $return[$i]['lat'] = $value2['Ampur_lat'];
    $return[$i]['lng'] = $value2['Ampur_lng'];
    $i++;
  }

}

echo json_encode($return);
$mongodb->close();
?>
