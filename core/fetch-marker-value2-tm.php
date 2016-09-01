<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$province = ' and province = NULL ';

if(isset($_POST['province'])){
  if($_POST['province']!=''){
    $province = ' and province = '.$_POST['province'];
  }
}

if(isset($_POST['district'])){
  if(trim($_POST['district'])!=""){
    $province .= ' and district = '.$_POST['district'];
  }else{

  }
}

if(isset($_POST['tumbon'])){
  if($_POST['tumbon']!=''){
    $province .= ' and tumbon = '.$_POST['tumbon'];
  }
}

$ageStart = $_POST['ageStart'];
$ageEnd = $_POST['ageEnd'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$itemcb = $_POST['itemcb'];
$iscb = $_POST['dbis'];

$eventType = $_POST['eventtype'];
$buff = explode(',' , $eventType);
$eventType = implode("','" , $buff);


$i = 0;

$strSQL = "SELECT atype, count(*) numcase
             FROM link_data_table
             WHERE
             atype in ('".$eventType."')
             and adate between '".$dateStart."' and '".$dateEnd."'
             and age between ".$ageStart." and '".$ageEnd."'
             ".$province."
             and lat is not NULL and lng is not NULL
             and status = 0
             GROUP BY atype
             ";

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
