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
  $strSQL = "SELECT a.prov_id province, a.district_id district, a.tumbon_id tumbon, a.adate adate, a.atime atime
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('1')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            ORDER BY a.adate, a.atime";
  $resultQuery = $db->select($strSQL,false,true);

  for($i=0;$i<count($resultQuery);$i++){
     if($i>0){
       if(($resultQuery[$i]['province']==$resultQuery[$i-1]['province'])
          && ($resultQuery[$i]['district']==$resultQuery[$i-1]['district'])
          && ($resultQuery[$i]['tumbon']==$resultQuery[$i-1]['tumbon'])
          && ($resultQuery[$i]['adate']==$resultQuery[$i-1]['adate'])
          && ($resultQuery[$i]['atime']==$resultQuery[$i-1]['atime'])){

       }else{
         $atype_event1++;
       }
     }else{
       $atype_event1++;
     }
  }
}else{
  $atype_event1 = 0;
}

$return[0]['numcount'] = $atype_event1;

if($isWater=='Yes'){
  $strSQL = "SELECT a.prov_id province, a.district_id district, a.tumbon_id tumbon, a.adate adate, a.atime atime
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('2')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            ORDER BY a.adate, a.atime";
  $resultQuery = $db->select($strSQL,false,true);
  for($i=0;$i<count($resultQuery);$i++){
     if($i>0){
       if(($resultQuery[$i]['province']==$resultQuery[$i-1]['province'])
          && ($resultQuery[$i]['district']==$resultQuery[$i-1]['district'])
          && ($resultQuery[$i]['tumbon']==$resultQuery[$i-1]['tumbon'])
          && ($resultQuery[$i]['adate']==$resultQuery[$i-1]['adate'])
          && ($resultQuery[$i]['atime']==$resultQuery[$i-1]['atime'])){

       }else{
         $atype_event2++;
       }
     }else{
       $atype_event2++;
     }
  }
}else{
  $atype_event2 = 0;
}

$return[1]['numcount'] = $atype_event2;

if($isFall=='Yes'){
  $strSQL = "SELECT a.prov_id province, a.district_id district, a.tumbon_id tumbon, a.adate adate, a.atime atime
            FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('3')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            ORDER BY a.adate, a.atime";
  $resultQuery = $db->select($strSQL,false,true);
  for($i=0;$i<count($resultQuery);$i++){
     if($i>0){
      if(($resultQuery[$i]['province']==$resultQuery[$i-1]['province'])
      && ($resultQuery[$i]['district']==$resultQuery[$i-1]['district'])
      && ($resultQuery[$i]['tumbon']==$resultQuery[$i-1]['tumbon'])
      && ($resultQuery[$i]['adate']==$resultQuery[$i-1]['adate'])
      && ($resultQuery[$i]['atime']==$resultQuery[$i-1]['atime'])){
        // print $i."<br>";
      }else{
        // print $i."+<br>";
         $atype_event3++;
      }
    }else{
      $atype_event3++;
    }
  }
}else{
  $atype_event3 = 0;
}

$return[2]['numcount'] = $atype_event3;

echo json_encode($return);
$db->disconnect();

?>
