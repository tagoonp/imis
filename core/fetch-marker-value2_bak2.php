<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);

include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$level = $_POST['txtLevel'];
$ageStart = $_POST['ageStart'];
$ageEnd = $_POST['ageEnd'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$itemcb = $_POST['itemcb'];
$iscb = $_POST['iscb'];
$isall = $_POST['isall'];
$eventType = $_POST['eventtype'];
$buff = explode(',' , $eventType);
$eventType = implode("','" , $buff);

// $return_buff = array(0,0,0);

$itemsstr = '';
if($itemcb=='Yes'){
  $itemsstr = ' and itemsid IS NOT NULL ';
}else{
  $itemsstr = ' and itemsid IS NULL ';
}

$isstr = '';
if($itemcb=='Yes'){
  $isstr = ' or isid != "" ';
}else{
  $isstr = ' or isid = "" ';
}

$i = 0;

$strSQL = "SELECT atype, count(*) numcase
             FROM link_data_table
             WHERE
             atype in ('".$eventType."')
             and adate between '".$dateStart."' and '".$dateEnd."'
             and age between ".$ageStart." and '".$ageEnd."'
             GROUP BY atype
             ";



echo json_encode($strSQL);
exit();

$resultQuery = $db->select($strSQL,false,true);

$return_buff =  array(0, 0, 0);

if($resultQuery){
  foreach ($resultQuery as $value) {
    if($value['atype']=='25'){
      $return_buff[0] = number_format($value['numcase']);
    }else if($value['atype']=='23'){
      $return_buff[1] = number_format($value['numcase']);
    }else if($value['atype']=='24'){
      $return_buff[2] = number_format($value['numcase']);
    }
  }
}

$return = '';
for($i=0;$i<count($return_buff);$i++){
  $return[$i]['numcount'] = $return_buff[$i];
}


echo json_encode($return);
$db->disconnect();

?>
