<?php
$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;

$province = $_POST['province'];
$district = $_POST['district'];
// $province = 47;
// $evtArr = array(23,24,25);
$evtArr = array();
if($_POST['evt1']=='true'){
  $evtArr[] = 25;
}

if($_POST['evt2']=='true'){
  $evtArr[] = 23;
}

if($_POST['evt3']=='true'){
  $evtArr[] = 24;
}

// $evtArr = array(23,24,25);

// $strArr = array(
//   array('age' => array('$gte' => intval($_POST['sage']), '$lte' => intval($_POST['eage']))),
//   array('adate' => array('$gte' => $_POST['sdate'], '$lte' => $_POST['edate'])),
//   array('atype' => array('$in' => $evtArr))
// );

// $strArr = array(
//   array('age' => array('$gte' => intval($_POST['sage']), '$lte' => intval($_POST['eage']))),
//   array('adate' => array('$gte' => '2013-01-01', '$lte' => '2013-01-31')),
//   array('atype' => array('$in' => $evtArr))
// );

// $cursor = $collection->find(array('atype' => array('$in' => $evtArr)));
// $cursor->limit(100);

// $cursor = $collection->find(
//   array( '$and' =>
//     $strArr
//   )
// );

// $cursor = $collection->group(
//   array('adate' => true), // fields to group by
//   array('count' => 0), // initial value of the aggregation counter object.
//   new MongoCode('function(doc, prev) { prev.count += 1 }'), // a function that takes two arguments (the current document and the aggregation to this point) and does the aggregation
//   // array('age' => array('$gte' => intval($_POST['sage'])))
//   array( '$and' =>
//     $strArr
//   )
// );

 // $result = $hits_collection->aggregate(array( '$and' =>
 //     $strArr
 //   ));

//  $result = $collection->aggregate([
//     ['$match' => ['date' => ['$gt' => '2013-01-01', '$lt' => '2013-01-31']]]
// ]);

$ops = array(
                array(
                  '$match' => array(
                                      'adate' => array(
                                        '$gte' => $_POST['sdate'],
                                        '$lte' => $_POST['edate']
                                      ),
                                      'age' => array(
                                        '$gte' => intval($_POST['sage']),
                                        '$lte' => intval($_POST['eage'])
                                      ),
                                      'lat' => array(
                                                      '$ne' => 'NULL'
                                      ),
                                      'lng' => array(
                                                      '$ne' => 'NULL'
                                      ),
                                      'province' => intval($province),
                                      'district' => intval($district),
                                      'atype' => array('$in' => $evtArr)
                                      ),

                    ),
                array(
                        '$sort' => array(
                            'adate' => 1,
                            'lat' => 1
                        )
                )

    );

$cursor = $collection->aggregate($ops);

$return = '';
$h = 0;
$i = 0;
foreach ($cursor as $item) {
  if($h==1){
    foreach ($item as $value) {
      $locationArr = array();

      $locationArr['lat'] = $value['lat'];
      $locationArr['lon'] = $value['lng'];

      $date = new DateTime($value['adate']);
      $tomorr = $date->modify('+1 day');

      $return[$i]['start'] = $value['adate'];
      $return[$i]['end'] = $tomorr->format('Y-m-d');
      $return[$i]['point'] = $locationArr;
      $return[$i]['atype'] = $value['atype'];

      if($value['place_detail']=='NULL'){
        $return[$i]['title'] = "อำเภอ".$value['dist_name']." จังหวัด".$value['prov_name'];
      }else{
        $return[$i]['title'] = $value['place_detail'];
      }

      $i++;
    }
  }
  $h++;

}

$i = 0;
$return2 = '';

$buff1 = '';
$buff2 = '';
$buff3 = '';
foreach ($return as $value) {
  // print_r($value);
  // print "<br>";

  if($i==0){
    $buff1 = $value['start'];
    $buff2 = $value['point'];

    $return2[$i]['start'] = $value['start'];
    $return2[$i]['end'] = $value['end'];
    $return2[$i]['title'] = $value['title'];
    $return2[$i]['point'] = $value['point'];

    $optValue = array();
    if($value['atype']==25){
      $optValue['theme'] = "red";
    }else if($value['atype']==23){
      $optValue['theme'] = "blue";
    }else if($value['atype']==24){
      $optValue['theme'] = "orange";
    }

    $return2[$i]['options'] = $optValue;

    $i++;
  }else{
    if(($buff1==$value['start']) && ($buff2==$value['point'])){

    }else{
      $buff1 = $value['start'];
      $buff2 = $value['point'];

      $return2[$i]['start'] = $value['start'];
      $return2[$i]['end'] = $value['end'];
      $return2[$i]['title'] = $value['title'];
      $return2[$i]['point'] = $value['point'];

      $optValue = array();
      if($value['atype']==25){
        $optValue['theme'] = "red";
      }else if($value['atype']==23){
        $optValue['theme'] = "blue";
      }else if($value['atype']==24){
        $optValue['theme'] = "orange";
      }

      $return2[$i]['options'] = $optValue;

      $i++;
    }
  }
  // $return2[$i]['start'] = $value['start'];
  // $return2[$i]['end'] = $value['end'];
  // $return2[$i]['title'] = $value['title'];
  // $return2[$i]['point'] = $value['point'];


}

echo json_encode($return2);
$mongodb->close();
exit();
    // $cursor->sort(array('adate' => 1));

//
// $cursor->limit(1000);

// var_dump($cursor);
// exit();

// $i = 0;
// $return = '';
// $h = 0;
// foreach ($cursor as $item) {
//   if($h==1){
//     foreach ($item as $value) {
//       $locationArr = array();
//
//       $locationArr['lat'] = $value['lat'];
//       $locationArr['lon'] = $value['lng'];
//
//       $date = new DateTime($value['adate']);
//       $tomorr = $date->modify('+1 day');
//
//       $return[$i]['start'] = $value['adate'];
//       $return[$i]['end'] = $tomorr->format('Y-m-d');
//       $return[$i]['point'] = $locationArr;
//       //
//       $return[$i]['title'] = $value['prov_name'];
//       $i++;
//     }
//   }
//   $h++;
//
// }

$return2 = '';
$i = 0;
$dtem = '';
$ptemp = '';
foreach ($cursor as $value) {
  // print $value['start'];
  if($i==0){
    $dtem = $value['start'];
    $ptemp = $value['title'];
    $return2[$i]['start'] = $value['start'];
    $date = new DateTime($value['start']);
    $tomorr = $date->modify('+1 day');
    $return2[$i]['end'] = $tomorr->format('Y-m-d');
    $return2[$i]['title'] = $value['title'];
    $return2[$i]['point'] = $value['point'];



  }else{
    if(($dtem==$value['start']) && ($ptemp==$value['title'])){

    }else{
      $dtem = $value['start'];
      $ptemp = $value['title'];
      $return2[$i]['start'] = $value['start'];
      $date = new DateTime($value['start']);
      $tomorr = $date->modify('+1 day');
      $return2[$i]['end'] = $tomorr->format('Y-m-d');
      $return2[$i]['title'] = $value['title'];
      $return2[$i]['point'] = $value['point'];

      $optValue['theme'] = "red";
      $return2[$i]['options'] = $optValue;
    }
  }

  // print_r($value);
  // print "<br>";
  $i++;
}

// $c = 1;
// foreach ($return2 as $value) {
//   print $c." ";
//   print_r($value);
//   print "<br>";
//   $c++;
// }

echo json_encode($return2);
$mongodb->close();
?>
