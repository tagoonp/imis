<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Injury Mapping Information System : IMIS</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

    <!-- Include JS file -->
    <script type="text/javascript" src="libraries/jquery/jquery.js"></script>
    <script type="text/javascript" src="libraries/bootstrap/js/bootstrap.js"></script>
    <!-- <script src="libraries/jquery/jquery-3.1.0.js" type="text/javascript"></script> -->
    <script src="libraries/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Include CSS file -->
    <link rel="stylesheet" type="text/css" href="libraries/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="libraries/wizn/css/wizn.css" />
    <link rel="stylesheet" href="libraries/font-awesome/css/font-awesome.min.css">
    <link href="libraries/bootstrap/css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="libraries/sweetalert/dist/sweetalert.css">

    <link rel="stylesheet" href="css/style.css" charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,200&subset=thai,latin' rel='stylesheet' type='text/css'>
  </head>
  <nav class="navbar navbar-default navbar-fix-top" style="margin-bottom: 0px; z-index: 99999;">
    <div class="container-fluid">
      <div class="navbar-header" style="font-size: 0.6em;">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand link-a" href="#" style="font-weight: 400; font-size: 3.3em;"><img src="images/RTIlogo.png" alt="" style="height: 40px; margin-top: -10px;"/></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li><a class="link-a" href="./"><i class="fa fa-home"></i> หน้าหลัก</a></li>
          <li><a class="link-a" href="timemap.php"><i class="fa fa-clock-o"></i> TimeMap</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li id="login"><a href="#" class="link-a" ><i class="fa fa-lock"></i> เข้าสู่ระบบ</a>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
  <div id="infoPane" class="infoPanel shadow2">
    <span id="infoSpan"></span>
  </div>
  <body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" style="margin-top: -5px;">
            <div class="" style="padding: 8px; background: #C1C1C1;  position: relative; padding-top: 16px; color: #fff; border: solid; border-width: 0px 0px 1px 0px; border-color: #ccc;">
              <i class="fa fa-gear"></i> ตั้งค่าการกรองข้อมูล
            </div>
            <div class="" style="padding: 0px 10px; padding-top: 5px; position: relative; ">
              <span style="font-size: 1.0em;">ระดับพื้นที่การแสดงผล : </span>
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12">
                  <select class="form-control" name="txtLevel" id="txtLevel">
                    <option value="1" selected="">จังหวัด</option>
                    <option value="2">อำเภอ</option>
                    <option value="3">ตำบล</option>
                    <option value="4">พิกัด</option>
                  </select>
                </div>
              </div>

            </div>
            <div class="" style="padding: 0px 10px; padding-top: 0px; position: relative;">
              <!-- <span style="font-size: 1.0em;">ช่วงเวลา : </span> -->
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12" style="padding-top: 5px;">
                  <table width="100%">
                    <tr>
                      <td width="40%" style="padding: 5px 0px 0px 0px;">
                        จากวันที่
                      </td>
                      <td width="60%" style="padding: 0px 0px 0px 5px;">
                        <input class="form-control" type="date" name="txtStart" id="txtStart" data-date="" data-date-format="DD MMMM YYYY" value="2013-01-01" style="border: solid 1px; border-color: #ccc;"  ></input>
                      </td>
                    </tr>
                    <tr>
                      <td width="40%" style="padding: 5px 0px 0px 0px;">
                        ถึงวันที่
                      </td>
                      <td width="60%" style="padding: 5px 0px 0px 5px;">
                        <input class="form-control" type="date" name="txtEnd" id="txtEnd" data-date="" data-date-format="DD MMMM YYYY" value="2013-12-31" style="border: solid 1px; border-color: #ccc;"  ></input>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>

            </div>

            <div class="" style="padding: 0px 10px; padding-top: 5px; position: relative;">
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-5" style="padding-top: 10px;">
                  <span style="font-size: 1.0em;"><i class="fa fa-info-circle" title="กรอก -1 ในช่องอายุเริ่มต้นเพื่อนับทุกรายการที่ไม่สามารถระบุอายุได้" style="cursor:pointer; color: red;"></i> ช่วงอายุ :  </span>
                </div>
                <div class="col-sm-7">
                  <table width="100%">
                    <tr>
                      <td width="50%" style="padding: 5px 5px 5px 0px;">
                        <input type="text" class="form-control" name="name" id="txtAgestart" value="0" >
                      </td>
                      <td width="50%" style="padding: 5px 0px 5px 5px;">
                        <input type="text" class="form-control" name="name" id="txtAgeend" value="100" >
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="" style="padding: 0px 10px; padding-top: 5px; position: relative;">
              <div class="row">
                <div class="col-sm-5">
                  <span style="font-size: 1.0em;">ฐานข้อมูล : </span>
                </div>
                <div class="col-sm-7">
                  <input type="checkbox" name="name" id="chItems" class="cb" value="1" checked="" > <span style="font-size: 0.9em;">ITEMS</span>&nbsp;&nbsp;
                  <input type="checkbox" name="name" id="chIs" class="cb" value="1" checked=""> <span style="font-size: 0.9em;">IS</span>
                </div>
              </div>
            </div>

            <div class="" style="padding: 0px 10px; padding-top: 5px; position: relative;">
              <span style="font-size: 1.0em;">ประเภทเหตุการณ์ : </span>
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12" style="padding-top: 0px;">
                  <input type="checkbox" name="chRoad" id="chRoad" class="cb" value="" checked="" > <span style="font-size: 0.9em;">อุบัติเหตุทางถนน</span>&nbsp;<input type="checkbox" class="cb" name="chWater" id="chWater" value="" checked=""> <span style="font-size: 0.9em;">จมน้้ำ</span>&nbsp;<input type="checkbox"  class="cb" name="chFall" id="chFall" value="" checked=""> <span style="font-size: 0.9em;">พลัดตกหกล้ม</span>
                </div>
              </div>
            </div>

            <div class="" style="padding: 0px 10px; padding-top: 5px; position: relative;">
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12">
                  <button type="button" name="btnGen" id="btnGen" class="btn btn-danger btn-block">แสดงผลข้อมูล</button>
                </div>
              </div>
            </div>

            <div class="" style="padding: 8px; background: #C1C1C1; position: relative; padding-top: 10px; margin-top: 10px; color: #fff; border: solid; border-width: 1px 0px 1px 0px; border-color: #ccc;">
              <i class="fa fa-th-list"></i> จำนวน
            </div>
            <div class="" style="padding: 0px 0px; padding-top: 0px; position: relative; ">
              <table class="table">
                <thead>
                  <tr>
                    <th style=" border:none;">

                    </th>
                    <th style="font-weight: 400; font-size: 0.8em; border:none;">
                      จำนวน<br>เหตุการณ์
                    </th>
                    <th style="font-weight: 400; font-size: 0.8em; border:none;">
                      จำนวน<br>ผู้บาดเจ็บ
                    </th>
                    <th style="font-weight: 400; font-size: 0.8em; border:none;">
                      จำนวน<br>ผู้เสียชีวิต
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="font-weight: 400; font-size: 0.8em;">
                      <img src="images/mr100p.png" alt="" width="10" /> อุบัติเหตุทางถนน
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result1_1">0</span>
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result1_2">0</span>
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result1_3">0</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-weight: 400; font-size: 0.8em;">
                      <img src="images/mb100p.png" alt="" width="10" /> จมน้้ำ
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result2_1">0</span>
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result2_2">0</span>
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result2_3">0</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-weight: 400; font-size: 0.8em;">
                      <img src="images/my100p.png" alt="" width="10" /> พลัดตกหกล้ม
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result3_1">0</span>
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result3_2">0</span>
                    </td>
                    <td style="font-size: 0.8em;">
                      <span id="result3_3">0</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="z-index: 99999; padding-left: 15px; padding-top: 0px; width: 100px;">
            <div class="container-fluid" style="padding: 0px;">
              <div class="row">
                  <div class="col-lg-12"  style="padding: 0px; margin: 0px;">
                    <button type="button" name="button" id="menu-toggle" class="btn btn-danger" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-gear"></i></button>
                  </div>
              </div>
            </div>

        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <div id="map-canvas"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAewI1LswH0coZUPDe8Pvy39j4sbxmgCZU" async defer></script>
    <div class="doctor_show">
      <div class="msg_data">
        <!--เนื้อหาใน popup message-->
      </div>
    </div>
  </body>
</html>


<div class="loadingDiv">
  <div class="msg_data2">
    <img src="images/progressLoad.gif" alt="" width="100%" />
  </div>
</div>

<div class="loadBG"></div>

<script src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/map.js"></script>
<!-- <MarkerCluster imagePath="libraries/markercluster/images/m" /> -->
<!-- <script	src="libraries/markercluster/src/markerclusterer.js"></script> -->
<script>
    $("#menu-toggle").click(function(e) {
      $("#menu-toggle").blur();
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
