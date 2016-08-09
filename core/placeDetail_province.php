<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);

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
// $itemcb = $_POST['itemcb'];
// $iscb = $_POST['iscb'];
// $eventType = $_POST['eventtype'];
// $buff = explode(',' , $eventType);
// $eventType = implode("','" , $buff);

$strSQL = "SELECT prov_name FROM link_data_table WHERE province = '".$id."' LIMIT 0,1 ";
$result = $db->select($strSQL,false,true);

?>
<div class="" style="background: #18C078; padding: 10px; font-size: 16px; margin: 0px; color: #fff; font-weight: bold; font-family: 'Kanit', sans-serif;">
  ข้อมูลสถานที่ <font color="yellow">จังหวัด<?php print $result[0]['prov_name']; ?></font>
</div>
<?php
if($result){
  ?>
  <div class="" style="background: #fff; padding: 10px; font-size: 14px; margin: 0px; color: #888; font-weight: bold; font-family: 'Kanit', sans-serif;">

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
            อุบัติเหตุทางถนน
          </td>
          <td>
            <?php
            $strSQL = "SELECT count(*) as recordnum FROM link_data_table WHERE province = '".$id."' and atype = '25' ";
            $result2 = $db->select($strSQL,false,true);
            if($result2){
              print number_format($result2[0]['recordnum']);
            }else {
              print "0";
            }
            ?>
          </td>
          <td>
            <?php
            $strSQL = "SELECT count(*) as recordnum FROM link_data_table WHERE province = '".$id."' and status = '1' and atype = '25' ";
            $result2 = $db->select($strSQL,false,true);
            if($result2){
              print number_format($result2[0]['recordnum']);
            }else {
              print "0";
            }
            ?>
          </td>
        </tr>
        <tr>
          <td>
            จมน้้ำ
          </td>
          <td>
            <?php
            $strSQL = "SELECT count(*) as recordnum FROM link_data_table WHERE province = '".$id."' and atype = '23' ";
            $result2 = $db->select($strSQL,false,true);
            if($result2){
              print number_format($result2[0]['recordnum']);
            }else {
              print "0";
            }
            ?>
          </td>
          <td>
            <?php
            $strSQL = "SELECT count(*) as recordnum FROM link_data_table WHERE province = '".$id."' and status = '1' and atype = '23' ";
            $result2 = $db->select($strSQL,false,true);
            if($result2){
              print number_format($result2[0]['recordnum']);
            }else {
              print "0";
            }
            ?>
          </td>
        </tr>
        <tr>
          <td>
            พลัดตกหกล้ม
          </td>
          <td>
            <?php
            $strSQL = "SELECT count(*) as recordnum FROM link_data_table WHERE province = '".$id."' and atype = '24' ";
            $result2 = $db->select($strSQL,false,true);
            if($result2){
              print number_format($result2[0]['recordnum']);
            }else {
              print "0";
            }
            ?>
          </td>
          <td>
            <?php
            $strSQL = "SELECT count(*) as recordnum FROM link_data_table WHERE province = '".$id."' and status = '1' and atype = '24' ";
            $result2 = $db->select($strSQL,false,true);
            if($result2){
              print number_format($result2[0]['recordnum']);
            }else {
              print "0";
            }
            ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}else{
  ?>
  <div class="" style="background: #fff; padding: 10px; font-size: 14px; margin: 0px; color: #888; font-weight: bold; font-family: 'Kanit', sans-serif;">
    ไม่พบข้อมูล <?php print $strSQL; ?>
  </div>
  <?php
}

?>
