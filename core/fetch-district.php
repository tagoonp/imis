<?php
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->col_district;

$cursor = $collection->find(array('Changwat' => intval($_POST['prov_id'])));
$cursor->sort(array('Name' => 1));

$return = '';
$i = 0;
foreach ($cursor as $value) {
  $return[$i]['id'] = $value['Ampur'];
  $return[$i]['pname'] = $value['Name'];
  $i++;
}

echo json_encode($return);
?>
