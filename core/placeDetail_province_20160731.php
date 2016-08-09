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

$ageStart = $_POST['ageStart'];
$ageEnd = $_POST['ageEnd'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$itemcb = $_POST['itemcb'];
$iscb = $_POST['iscb'];
$eventType = $_POST['eventtype'];
$buff = explode(',' , $eventType);
$eventType = implode("','" , $buff);

$strSQL = "SELECT * FROM td3s_changwat WHERE Changwat = '".$id."'";
$result = $db->select($strSQL,false,true);

if($result){
  ?>
  <div class="" style="background: #18C078; padding: 10px; font-size: 16px; margin: 0px; color: #fff; font-weight: bold; font-family: 'Kanit', sans-serif;">
    ข้อมูลสถานที่
  </div>

  <div style="padding: 10px; background: #f3f3f3; font-family: 'Kanit', sans-serif;">
    <strong>จังหวัด</strong> : <?php print $result[0]['Name']; ?>
    <table width="300" border="1" cellspacing="2" cellpadding="0" style="margin-top: 10px;">
      <tr>
        <td width="50%" style="padding: 5px;"><img src="images/mr100p.png" alt="" width="13"  />&nbsp;&nbsp;อุบัติเหตุทางถนน</td>
        <td style="padding: 5px;">
          <?php
          $numrow = "0 ราย";
          foreach ($buff as $value) {
            if($value==1){
              $strSQL = "SELECT count(*) numrow
              FROM td3s_linked_data_test
              WHERE
              prov_id = '".$id."' and atype = '1'
              and adate between '".$dateStart."' and '".$dateEnd."'
              and pat_age between '".$ageStart."' and '".$ageEnd."'
              and is_is = '".$itemcb."'
              and is_items = '".$iscb."'";
              $resultNum = $db->select($strSQL,false,true);
              if($resultNum){
                $numrow = $resultNum[0]['numrow']." ราย";
              }
            }
          }

          print $numrow;

          ?>
        </td>
      </tr>
      <tr>
        <td width="50%" style="padding: 5px;"><img src="images/mb100p.png" alt="" width="13"  />&nbsp;&nbsp;จมน้้ำ</td>
        <td style="padding: 5px;">
          <?php
          $numrow = "0 ราย";
          foreach ($buff as $value) {
            if($value==2){
              $strSQL = "SELECT count(*) numrow
              FROM td3s_linked_data_test
              WHERE
              prov_id = '".$id."' and atype = '2'
              and adate between '".$dateStart."' and '".$dateEnd."'
              and pat_age between '".$ageStart."' and '".$ageEnd."'
              and is_is = '".$itemcb."'
              and is_items = '".$iscb."'";
              $resultNum = $db->select($strSQL,false,true);
              if($resultNum){
                $numrow = $resultNum[0]['numrow']." ราย";
              }
            }
          }

          print $numrow;

          ?>
        </td>
      </tr>
      <tr>
        <td width="50%" style="padding: 5px;"><img src="images/my100p.png" alt=""  width="13" />&nbsp;&nbsp;พลัดตกหกล้ม</td>
        <td style="padding: 5px;">
          <?php
          $numrow = "0 ราย";
          foreach ($buff as $value) {
            if($value==3){
              $strSQL = "SELECT count(*) numrow
              FROM td3s_linked_data_test
              WHERE
              prov_id = '".$id."' and atype = '3'
              and adate between '".$dateStart."' and '".$dateEnd."'
              and pat_age between '".$ageStart."' and '".$ageEnd."'
              and is_is = '".$itemcb."'
              and is_items = '".$iscb."'";
              $resultNum = $db->select($strSQL,false,true);
              if($resultNum){
                $numrow = $resultNum[0]['numrow']." ราย";
              }
            }
          }

          print $numrow;

          ?>
        </td>
      </tr>
    </table>
  </div>
  <?php
}
?>
