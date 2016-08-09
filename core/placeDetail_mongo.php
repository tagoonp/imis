<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);

$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;

// $id = 90;
if(isset($_GET['place_id'])){
  $id = $_GET['place_id'];
}

// $buff = explode(",", $id);

// $ageStart = $_POST['ageStart'];
// $ageEnd = $_POST['ageEnd'];
// $dateStart = $_POST['dateStart'];
// $dateEnd = $_POST['dateEnd'];
// $itemcb = $_POST['itemcb'];
// $iscb = $_POST['iscb'];
// $eventType = $_POST['eventtype'];
// $buff = explode(',' , $eventType);
// $eventType = implode("','" , $buff);
// $evtArr = array();
// if($_POST['evt1']==true){
//   $evtArr[] = 25;
// }
//
// if($_POST['evt2']==true){
//   $evtArr[] = 23;
// }
//
// if($_POST['evt3']==true){
//   $evtArr[] = 24;
// }


$cursor = $collection->find(array("record_id" => intval($id)));
$cursor->limit(1);
$provName = '';
$atype = 'ไม่สามารถระบุได้';
$aevent = '-'; $aage= 'ไม่สามารถระบุได้'; $gender = 'ไม่สามารถระบุได้';
foreach ($cursor as $value) {
  $provName = $value['prov_name'];
  if($value['dist_name']!=''){
      $provName .= " อำเภอ".$value['dist_name'];
  }

  if($value['tumbon_name']!=''){
      $provName .= " ตำบล".$value['tumbon_name'];
  }

  if($value['place_detail']!=''){
      $provName .= "<br>ข้อมูลอื่นๆ : ".$value['place_detail'];
  }

  switch ($value['atype']) {
    case '25': $atype = 'อุบัติเหตุทางถนน' ; break;
    case '23': $atype = 'จมน้้ำ' ; break;
    case '24': $atype = 'พลัดตกหกล้ม' ; break;
  }

  $aevent = $value['adate']." ".$value['atime'];

  if($value['age'] > 0){
    $aage = $value['age'];
  }

  $gender = $value['gender'];

}
?>
<div class="" style="background: red; padding: 10px; font-size: 16px; margin: 0px; color: #000; font-weight: bold; font-family: 'Kanit', sans-serif;">
  ข้อมูลสถานที่ <br>
  <span style="font-size: 0.8em;">
    <font color="#fff">จังหวัด<?php print $provName; ?></font>
  </span>
</div>
<div class="" style="background: #fff; padding: 10px; font-size: 14px; margin: 0px; color: #000; font-weight: bold; font-family: 'Kanit', sans-serif;">
  <table class="table table-condensed table-borderless" style="margin-top: 2px;">
    <tbody style="font-weight: 300;">
      <tr>
        <td>
          <strong>วัน-เวลา</strong>
        </td>
        <td>
          <?php
          print $aevent;
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>ประเภทเหตุการณ์</strong>
        </td>
        <td>
          <?php
            print $atype;
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>อายุ</strong>
        </td>
        <td>
          <?php
            print $aage;
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>เพศ</strong>
        </td>
        <td>
          <?php
            print $gender;
          ?>
        </td>
      </tr>

    </tbody>
  </table>
</div>
