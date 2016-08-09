<?php
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
$eventType = $_POST['eventtype'];
$buff = explode(',' , $eventType);
$eventType = implode("','" , $buff);

$return_buff = array(0,0,0);

$i = 0;

foreach ($buff as $value) {
  $strSQL = "SELECT a.atype, count(*) numcase
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('".$value."')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            and a.pat_laststatus = '1'
            ";

  $resultQuery = $db->select($strSQL,false,true);

  if($resultQuery){
    if($value==1){
      $return_buff[0] = $resultQuery[0]['numcase'];
    }else if($value==2){
      $return_buff[1] = $resultQuery[0]['numcase'];
    }else if($value==3){
      $return_buff[2] = $resultQuery[0]['numcase'];
    }
  }
  $i++;
}

$return = '';

for($i=0;$i<count($return_buff);$i++){
  $return[$i]['numcount'] = $return_buff[$i];
}

echo json_encode($return);
$db->disconnect();

?>
