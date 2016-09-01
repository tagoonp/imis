<?php
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->col_province;

$cursor = $collection->find();
$cursor->sort(array('Name' => 1));

$return = '';
$i = 0;
foreach ($cursor as $value) {
  $return[$i]['id'] = $value['Changwat'];
  $return[$i]['pname'] = $value['Name'];
  $i++;
}

echo json_encode($return);
?>
