<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);

$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;

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
  if($isall=='Yes'){

    $cursor = $collection->group(
      array('adate' => true), // fields to group by
      array('count' => 0), // initial value of the aggregation counter object.
      new MongoCode('function(doc, prev) { prev.count += 1 }'), // a function that takes two arguments (the current document and the aggregation to this point) and does the aggregation
      array( 'atype' => 25 )
    );


  }else{
    $cursor = $collection->group(
      array('adate' => true, 'atime' => true, 'province' => true, 'district' => true, 'tumbon' => true), // fields to group by
      array('count' => 0), // initial value of the aggregation counter object.
      new MongoCode('function(doc, prev) { prev.count += 1 }'), // a function that takes two arguments (the current document and the aggregation to this point) and does the aggregation
      array( 'atype' => 25 )
    );
  }

  foreach ($cursor['retval'] as $item){
    if($value=='25'){
      $return_buff[0] = $item['count'];
    }else if($value=='23'){
      $return_buff[1] = $item['count'];
    }else if($value=='24'){
      $return_buff[1] = $item['count'];
    }
  }

  // echo json_encode($strSQL);
  // exit();

  // $resultQuery = $db->select($strSQL,false,true);
  // if($resultQuery){
  //   if($value['atype']=='25'){
  //     $return_buff[0] = number_format(sizeof($resultQuery));
  //   }else if($value['atype']=='23'){
  //     $return_buff[1] = number_format(sizeof($resultQuery));
  //   }else if($value['atype']=='24'){
  //     $return_buff[2] = number_format(sizeof($resultQuery));
  //   }
  // }
  // $atype_event = 0;
  //
  // for($i=0;$i<count($resultQuery);$i++){
  //   if($i>0){
  //     if(($resultQuery[$i]['province']==$resultQuery[$i-1]['province'])
  //       && ($resultQuery[$i]['district']==$resultQuery[$i-1]['district'])
  //       && ($resultQuery[$i]['tumbon']==$resultQuery[$i-1]['tumbon'])
  //       && ($resultQuery[$i]['adate']==$resultQuery[$i-1]['adate'])
  //       && ($resultQuery[$i]['atime']==$resultQuery[$i-1]['atime'])){
  //
  //     }else{
  //       $atype_event++;
  //     }
  //   }else{
  //     $atype_event = 0;
  //   }
  // }
  //
  // if($resultQuery){
  //   if($value=='25'){
  //     $return_buff[0] = $atype_event;
  //   }else if($value=='23'){
  //     $return_buff[1] = $atype_event;
  //   }else if($value=='24'){
  //     $return_buff[2] = $atype_event;
  //   }
  // }
}

$return = '';

for($i=0;$i<count($return_buff);$i++){
  $return[$i]['numcount'] = $return_buff[$i];
}


echo json_encode($return);
// $db->disconnect();

?>
