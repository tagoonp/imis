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
$eventString = implode("','" , $eventType);

print "asd";

$strSQL = "SELECT count(*) numcount, a.prov_id id, b.Changwat_lat lat, b.Changwat_lng lng, b.Name name
          FROM td3s_linked_data_test a inner join td3s_changwat b
          on a.prov_id = b.Changwat
          WHERE
          a.atype != '0'
          and a.a_lat != ''
          and a.a_lng != ''
          and a.atype in ('".$eventString."')
          and a.adate between '".$dateStart."' and '".$dateEnd."'
          and a.pat_age between '".$ageStart."' and '".$ageEnd."'
          and a.is_is = '".$itemcb."'
          and a.is_items = '".$iscb."'
          GROUP BY a.prov_id ORDER BY numcount desc";

if($level==3){ //By district
  $strSQL = "SELECT count(*) numcount, a.district_id id, b.Ampur_lat lat, b.Ampur_lng lng, b.Name name
            FROM td3s_linked_data_test a inner join td3s_ampur b
            on a.prov_id = b.Changwat and a.district_id = b.Ampur
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('".$eventString."')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            GROUP BY a.prov_id,a.district_id ORDER BY numcount desc";
}else if($level==4){
  $strSQL = "SELECT count(*) numcount, a.tumbon_id id, b.Tumbon_lat lat, b.Tumbon_lng lng, b.Name name
            FROM td3s_linked_data_test a inner join td3s_tumbon b
            on a.prov_id = b.Changwat and a.district_id = b.Ampur and a.tumbon_id = b.Tumbon
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('".$eventString."')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            GROUP BY a.prov_id,a.district_id,a.tumbon_id ORDER BY numcount desc";
}else if($level==2){
  $strSQL = "SELECT count(*) numcount, a.prov_id id, b.Changwat_lat lat, b.Changwat_lng lng, b.Name name FROM td3s_linked_data_test a inner join td3s_changwat b
            on a.prov_id = b.Changwat
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('".$eventString."')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            GROUP BY a.prov_id ORDER BY numcount desc";
}else if($level==5){
  $strSQL = "SELECT count(*) numcount, a.link_id id, a.a_lat lat, a.a_lng lng, a.place_detail name FROM td3s_linked_data_test a
            WHERE
            a.atype != '0'
            and a.a_lat != ''
            and a.a_lng != ''
            and a.atype in ('".$eventString."')
            and a.adate between '".$dateStart."' and '".$dateEnd."'
            and a.pat_age between '".$ageStart."' and '".$ageEnd."'
            and a.is_is = '".$itemcb."'
            and a.is_items = '".$iscb."'
            GROUP BY a.a_lat, a.a_lng ORDER BY numcount desc";
}
$resultQuery = $db->select($strSQL,false,true);
//
$return = '';

if($level==5){
  for($i=0;$i<count($resultQuery);$i++){
    $return[$i]['numcount'] = 1;
    $return[$i]['id'] = $resultQuery[$i]['id'];
    $return[$i]['name'] = $resultQuery[$i]['name'];
    $return[$i]['lat'] = $resultQuery[$i]['lat'];
    $return[$i]['lng'] = $resultQuery[$i]['lng'];
    $return[$i]['atype'] = $resultQuery[$i]['atype'];
  }
}else{
  for($i=0;$i<count($resultQuery);$i++){
    $return[$i]['numcount'] = $resultQuery[$i]['numcount'];
    $return[$i]['id'] = $resultQuery[$i]['id'];
    $return[$i]['name'] = $resultQuery[$i]['name'];
    $return[$i]['lat'] = $resultQuery[$i]['lat'];
    $return[$i]['lng'] = $resultQuery[$i]['lng'];
  }
}


echo json_encode($return);
$db->disconnect();

?>
