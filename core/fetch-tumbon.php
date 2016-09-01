<?php
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->col_tumbon;

$cursor = $collection->find(array('Changwat' => intval($_POST['prov_id']), 'Ampur' => intval($_POST['dist_id'])));
$cursor->sort(array('Name' => 1));

$return = '';
$i = 0;
foreach ($cursor as $value) {
  $return[$i]['id'] = $value['Tumbon'];
  $return[$i]['pname'] = $value['Name'];
  $i++;
}

echo json_encode($return);
?>
