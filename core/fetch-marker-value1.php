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
$isall = $_POST['isall'];
$buff = explode(',' , $eventType);
$eventType = implode("','" , $buff);

$return_buff = array(0,0,0);


if(($itemcb=='Yes') && ($iscb=='Yes')){
  $itemsstr = ' and ( itemsid IS NOT NULL or isid != "" )';
}

$i = 0;
foreach ($buff as $value) {
  $strSQL = "SELECT count(*) numcase, atype
            FROM link_data_table
            WHERE
            atype in ('".$value."')
            and adate between '".$dateStart."' and '".$dateEnd."'
            and age between ".$ageStart." and ".$ageEnd."
            ".$itemsstr."
            GROUP BY adate, atime, province, district, tumbon";

  // echo json_encode($strSQL);
  // exit();

  $resultQuery = $db->select($strSQL,false,true);
  if($resultQuery){
    if($value=='25'){
      $return_buff[0] = number_format(sizeof($resultQuery));
    }else if($value=='23'){
      $return_buff[1] = number_format(sizeof($resultQuery));
    }else if($value=='24'){
      $return_buff[2] = number_format(sizeof($resultQuery));
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
