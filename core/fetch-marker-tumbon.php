<?php
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;
$collection2 = $db->col_tumbon;

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

$cursor = $collection->group(
  array('province' => true, 'district' => true, 'tumbon' => true), // fields to group by
  array('count' => 0), // initial value of the aggregation counter object.
  new MongoCode('function(doc, prev) { prev.count += 1 }'), // a function that takes two arguments (the current document and the aggregation to this point) and does the aggregation
  array( '$and' =>
    $strArr
  )
);


$c = 1;
$return = '';

$i = 0;
foreach ($cursor['retval'] as $item){

  $cursor2 = $collection2->find(array("Changwat" => $item['province'], "Ampur" => $item['district'], "Tumbon" => $item['tumbon']));

  foreach ($cursor2 as $key2 => $value2) {
    $return[$i]['num'] = $item['count'];
    // $return[$i]['name_string'] = "";
    $return[$i]['prov'] = $value2['Changwat'].",".$value2['Ampur'].",".$value2['Tumbon'];
    $return[$i]['lat'] = $value2['Tumbon_lat'];
    $return[$i]['lng'] = $value2['Tumbon_lng'];
    $i++;
  }

}

echo json_encode($return);
$mongodb->close();
?>
