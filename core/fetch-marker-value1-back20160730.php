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

// $itemsstr = '';
// if($itemcb=='Yes'){
//   $itemsstr = ' and ( itemsid IS NOT NULL ';
// }else{
//   $itemsstr = ' and (itemsid IS NULL ';
// }
//
// $isstr = '';
// if($iscb=='Yes'){
//   $isstr = ' or isid != "" )';
// }else{
//   $isstr = ' or isid = "" )';
// }

if(($itemcb=='Yes') && ($iscb=='Yes')){
  $itemsstr = ' and ( itemsid IS NOT NULL or isid != "" )';
}

$i = 0;
foreach ($buff as $value) {
  if($isall=='Yes'){
    $strSQL = "SELECT a.province province, a.district district, a.tumbon tumbon, a.adate adate, a.atime atime
              FROM link_data_table a
              WHERE
              -- a.lat != ''
              -- and a.lng != ''
              a.atype in ('".$value."')
              and a.adate between '".$dateStart."' and '".$dateEnd."'
              ".$itemsstr."
              ORDER BY a.adate, a.atime";
  }else{
    $strSQL = "SELECT a.province province, a.district district, a.tumbon tumbon, a.adate adate, a.atime atime
              FROM link_data_table a
              WHERE
              -- a.lat != ''
              -- and a.lng != ''
              a.atype in ('".$value."')
              and a.adate between '".$dateStart."' and '".$dateEnd."'
              and a.age between '".$ageStart."' and '".$ageEnd."'
              ".$itemsstr."
              ORDER BY a.adate, a.atime";
  }

  // echo json_encode($strSQL);
  // exit();

  $resultQuery = $db->select($strSQL,false,true);
  $atype_event = 0;

  for($i=0;$i<count($resultQuery);$i++){
    if($i>0){
      if(($resultQuery[$i]['province']==$resultQuery[$i-1]['province'])
        && ($resultQuery[$i]['district']==$resultQuery[$i-1]['district'])
        && ($resultQuery[$i]['tumbon']==$resultQuery[$i-1]['tumbon'])
        && ($resultQuery[$i]['adate']==$resultQuery[$i-1]['adate'])
        && ($resultQuery[$i]['atime']==$resultQuery[$i-1]['atime'])){

      }else{
        $atype_event++;
      }
    }else{
      $atype_event = 0;
    }
  }

  if($resultQuery){
    if($value=='25'){
      $return_buff[0] = $atype_event;
    }else if($value=='23'){
      $return_buff[1] = $atype_event;
    }else if($value=='24'){
      $return_buff[2] = $atype_event;
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
