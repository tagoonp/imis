<?php

$mongodb = new MongoClient();
$db = $mongodb->imis;
$collection = $db->linkeddata;

if(isset($_GET['place_id'])){
  $id = $_GET['place_id'];
}

$buff = explode(",", $id);

$ageStart = $_POST['ageStart'];
$ageEnd = $_POST['ageEnd'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
// $itemcb = $_POST['itemcb'];
// $iscb = $_POST['iscb'];
// $eventType = $_POST['eventtype'];
// $buff = explode(',' , $eventType);
// $eventType = implode("','" , $buff);
$evtArr = array();
if($_POST['evt1']==true){
  $evtArr[] = 25;
}

if($_POST['evt2']==true){
  $evtArr[] = 23;
}

if($_POST['evt3']==true){
  $evtArr[] = 24;
}


$cursor = $collection->find(array("province" => intval($buff[0]), "district" => intval($buff[1])));
$cursor->limit(1);
$provName = '';
foreach ($cursor as $value) {
  $provName = $value['prov_name']." อำเภอ".$value['dist_name'];
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
    <thead>
      <tr>
        <th>

        </th>
        <th>
          ผู้บาดเจ็บ
        </th>
        <th>
           เสียชีวิต
        </th>
      </tr>
    </thead>
    <tbody style="font-weight: 300;">
      <tr>
        <td>
          <img src="images/mr100p.png" alt="" width="13"  /> อุบัติเหตุทางถนน
        </td>
        <td>
          <?php
          // print $_POST['evt1'];
          if($_POST['evt1']=='true'){
            $cursor = $collection->count(
            array( '$and' =>
                array(
                  array('province' => intval($buff[0])),
                  array('district' => intval($buff[1])),
                  array('age' => array('$gte' => intval($ageStart), '$lte' => intval($ageEnd))),
                  array('adate' => array('$gte' => $dateStart, '$lte' => $dateEnd)),
                  array('atype' => 25)
                )
              )
            );
            print number_format($cursor);
          }else{
            print "0";
          }

          ?>
        </td>
        <td>
          <?php
          if($_POST['evt1']=='true'){
            $cursor = $collection->count(
            array( '$and' =>
                array(
                  array('province' => intval($buff[0])),
                  array('district' => intval($buff[1])),
                  array('age' => array('$gte' => intval($ageStart), '$lte' => intval($ageEnd))),
                  array('adate' => array('$gte' => $dateStart, '$lte' => $dateEnd)),
                  array('atype' => 25),
                  array('status' => 1)
                )
              )
            );
            print number_format($cursor);
          }else{
            print "0";
          }

          ?>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/mb100p.png" alt="" width="13"  /> จมน้้ำ
        </td>
        <td>
          <?php
          if($_POST['evt2']=='true'){
            $cursor = $collection->count(
            array( '$and' =>
                array(
                  array('province' => intval($buff[0])),
                  array('district' => intval($buff[1])),
                  array('age' => array('$gte' => intval($ageStart), '$lte' => intval($ageEnd))),
                  array('adate' => array('$gte' => $dateStart, '$lte' => $dateEnd)),
                  array('atype' => 23)
                )
              )
            );
            print number_format($cursor);
          }else{
            print "0";
          }

          ?>
        </td>
        <td>
          <?php
          if($_POST['evt2']=='true'){
            $cursor = $collection->count(
            array( '$and' =>
                array(
                  array('province' => intval($buff[0])),
                  array('district' => intval($buff[1])),
                  array('age' => array('$gte' => intval($ageStart), '$lte' => intval($ageEnd))),
                  array('adate' => array('$gte' => $dateStart, '$lte' => $dateEnd)),
                  array('atype' => 23),
                  array('status' => 1)
                )
              )
            );
            print number_format($cursor);
          }else{
            print "0";
          }

          ?>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/my100p.png" alt=""  width="13" /> พลัดตกหกล้ม
        </td>
        <td>
          <?php
          if($_POST['evt3']=='true'){
            $cursor = $collection->count(
            array( '$and' =>
                array(
                  array('province' => intval($buff[0])),
                  array('district' => intval($buff[1])),
                  array('age' => array('$gte' => intval($ageStart), '$lte' => intval($ageEnd))),
                  array('adate' => array('$gte' => $dateStart, '$lte' => $dateEnd)),
                  array('atype' => 24)
                )
              )
            );
            print number_format($cursor);
          }else{
            print "0";
          }

          ?>
        </td>
        <td>
          <?php
          if($_POST['evt3']=='true'){
            $cursor = $collection->count(
            array( '$and' =>
                array(
                  array('province' => intval($buff[0])),
                  array('district' => intval($buff[1])),
                  array('age' => array('$gte' => intval($ageStart), '$lte' => intval($ageEnd))),
                  array('adate' => array('$gte' => $dateStart, '$lte' => $dateEnd)),
                  array('atype' => 24),
                  array('status' => 1)
                )
              )
            );
            print number_format($cursor);
          }else{
            print "0";
          }

          ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<?php
$mongodb->close();
?>
