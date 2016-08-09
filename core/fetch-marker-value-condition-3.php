<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$ageStart = $_POST['ageStart'];
$ageEnd = $_POST['ageEnd'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$itemcb = $_POST['itemcb'];
$iscb = $_POST['iscb'];
// $eventType = $_POST['eventtype'];
// $eventString = implode("','" , $eventType);
$isRoad = $_POST['isRoad'];
$isWater = $_POST['isWater'];
$isFall = $_POST['isFall'];

$return = '';
$atype_event1 = 0;
$atype_event2 = 0;
$atype_event3 = 0;

if($isRoad=='Yes'){
  $strSQL = "SELECT count(*) numcount
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('1')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            and a.pat_laststatus = '1'
            GROUP BY a.atype ORDER BY a.atype";
  $resultQuery = $db->select($strSQL,false,true);
  // print $strSQL;
  if($resultQuery){
    $atype_event1 = $resultQuery[0]['numcount'];
  }else{
    $atype_event1 = 0;
  }
}else{
  $atype_event1 = 0;
}


$return[0]['numcount'] = $atype_event1;

if($isWater=='Yes'){
  $strSQL = "SELECT count(*) numcount
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('2')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            and a.pat_laststatus = '1'
            GROUP BY a.atype ORDER BY a.atype";
  $resultQuery = $db->select($strSQL,false,true);
  if($resultQuery){
    $atype_event2 = $resultQuery[0]['numcount'];
  }else{
    $atype_event2 = 0;
  }
}else{
  $atype_event2 = 0;
}

$return[1]['numcount'] = $atype_event2;

if($isFall=='Yes'){
  $strSQL = "SELECT count(*) numcount
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('3')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            and a.pat_laststatus = '1'
            GROUP BY a.atype ORDER BY a.atype";
  $resultQuery = $db->select($strSQL,false,true);
  if($resultQuery){
    $atype_event3 = $resultQuery[0]['numcount'];
  }else{
    $atype_event3 = 0;
  }
}else{
  $atype_event3 = 0;
}

$return[2]['numcount'] = $atype_event3;



//
// $return = '';
// for($i=0;$i<count($resultQuery);$i++){
//   $return[$i]['numcount'] = $resultQuery[$i]['numcount'];
// }

echo json_encode($return);
$db->disconnect();

?>
