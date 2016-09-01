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

// $return_buff = array(0,0,0);


$i = 0;


$strSQL = "SELECT COUNT(*) as numcase, atype FROM `link_data_table` WHERE atype in ('".$eventType."') and adate between '".$dateStart."' and '".$dateEnd."' and status = 1 and (age >= ".$ageStart." and age <= ".$ageEnd.") ".$province." and lat is not NULL and lng is not NULL GROUP BY atype ";

// echo json_encode($strSQL);
// exit();

$resultQuery = $db->select($strSQL,false,true);

$return_buff =  array(0, 0, 0);
$t25 = 0;
$t23 = 0;
$ts4 = 0;

if($resultQuery){
  foreach ($resultQuery as $value) {
    if($value['atype']==25){
      $return_buff[0] = number_format($value['numcase']);
      // $t25++;
    }else if($value['atype']==23){
      $return_buff[1] = number_format($value['numcase']);
      // $t23++;
    }else if($value['atype']==24){
      $return_buff[2] = number_format($value['numcase']);
      // $t24++;
    }
  }
}

// $return_buff[0] = number_format($t25);
// $return_buff[1] = number_format($t23);
// $return_buff[2] = number_format($t24);

// print_r($return_buff);
// exit();
$return = '';
for($i=0;$i<count($return_buff);$i++){
  $return[$i]['numcount'] = $return_buff[$i];
}


echo json_encode($return);
$db->disconnect();

?>
