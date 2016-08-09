<?php
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

if(isset($_GET['place_id'])){
  $id = $_GET['place_id'];
}

$strSQL = "SELECT *
FROM
td3s_linked_data_test a
WHERE a.link_id = '".$id."' ";
$result = $db->select($strSQL,false,true);

if($result){
  ?>
  <div class="" style="background: #18C078; padding: 10px; font-size: 16px; margin: 0px; color: #fff; font-weight: bold; font-family: 'Kanit', sans-serif;">
    ข้อมูลเหตุการณ์บาดเจ็บ
  </div>

  <div style="padding: 10px; background: #f3f3f3; font-family: 'Kanit', sans-serif;">
    <strong>จังหวัด</strong> : <?php
    $strSQL = "SELECT Name FROM td3s_changwat WHERE Changwat = '".$result[0]['prov_id']."'";
    $resultC = $db->select($strSQL,false,true);
    if($resultC){ print $resultC[0]['Name']; }

    $strSQL = "SELECT Name FROM td3s_ampur WHERE Changwat = '".$result[0]['prov_id']."' and Ampur = '".$result[0]['district_id']."'";
    $resultC = $db->select($strSQL,false,true);
    if($resultC){ print " อำเภอ".$resultC[0]['Name']; }

    $strSQL = "SELECT Name FROM td3s_tumbon WHERE Changwat = '".$result[0]['prov_id']."' and Ampur = '".$result[0]['district_id']."' and Tumbon = '".$result[0]['tumbon_id']."'";
    $resultC = $db->select($strSQL,false,true);
    if($resultC){ print " ตำบล".$resultC[0]['Name']; }
    ?><br>
    <strong>ข้อมูลสถานที่</strong> : <?php print $result[0]['place_detail']; ?><br>
    <strong>เหตุการณ์</strong> :
      <?php
      switch ($result[0]['atype']) {
        case '1':
          print "อุบัติเหตุทางถนน";
          break;
        case '2':
          print "จมน้้ำ";
          break;
        case '3':
          print "พลัดตกหกล้ม";
          break;
        default:
          # code...
          break;
      };

      ?>
      <br>
      <strong>วัน-เวลา</strong> : <?php print $result[0]['adate']." ".$result[0]['atime']; ?><br>
      <strong>อายุ</strong> : <?php print $result[0]['pat_age']; ?> ปี<br>
  </div>
  <?php
}
?>
