<link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css" charset="utf-8">
<div class="" style="margin: 20px;">
  <form class="" name="loginForm" id="LoginForm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style=" color: #06c; padding-top: 15px; " align="center" >
          <img src="images/map-icon.png" alt="" width="100" /><h3 style="font-family: 'Kanit', sans-serif; padding-top: 10px; ">เข้าสู่ระบบ</h3>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" name="txtUsername" id="txtUsername" class="form-control" style="width: 265px;" placeholder="ชื่อบัญชีผู้ใช้" autofocus="">
        </td>
      </tr>
      <tr>
        <td style="padding-top: 10px;">
          <input type="password" name="txtPassword" id="txtPassword" class="form-control" style="width: 265px;" placeholder="รหัสผ่าน">
        </td>
      </tr>
      <tr>
        <td style="padding-top: 10px;">
          <button type="submit" name="btnLogin" id="btnLogin" class="btn btn-primary" style="width:265px;">เข้าสู่ระบบ</button>
          <button type="button" name="btnCancle" id="btnCancle" class="btn btn-primary" style="width:265px;">ยกเลิก</button>
        </td>
      </tr>
      <tr>
        <td style="padding-top: 10px; padding-bottom: 10px;">
          <div class="text-center">
            <!-- <a href="register.html" class="link-b">ลงทะเบียนร่วมเครือข่าย</a> | <a href="forgotpassword.html"  class="link-b">ลืมรหัสผ่าน ?</a> -->
            <a href="forgotpassword.html"  class="link-b">ลืมรหัสผ่าน ?</a>
          </div>
        </td>
      </tr>
    </table>
  </form>
</div>


<script type="text/javascript">
  $(function(){

    $('#btnCancle').click(function(){
      $("#overlay").fadeToggle();
			$(".doctor_show").slideToggle();
    });

    $('#LoginForm').submit(function(){
      var check = 0;
      $("#overlay").fadeToggle();
      $(".doctor_show").slideToggle();
      $('.form-control').removeClass('ms-required');

      if($('#txtUsername').val()==''){
        $('#txtUsername').addClass('ms-required');
        check++;
      }

      if($('#txtPassword').val()==''){
        $('#txtPassword').addClass('ms-required');
        check++;
      }

      if(check!=0){
        return false;
      }else{
        $.post("core/authentication.php", {
          username: $('#txtUsername').val(),
          password: $('#txtPassword').val()
          },
          function(result){
            if(result=='Y'){
              window.location = 'core/redirect_user.php?aut_t=1';
            }else{
              swal("ขออภัย!", "ไม่พบข้อมูลบัญชีผู้ใช้ดังกล่าว หรือ รหัสผ่านผิดพลาด!" + result, "warning");
            }
          }
        );
        return false;
      }
      return false;
    });


    $('#txtUsername').keyup(function(){
      if($('#txtUsername').val()!=''){
        $('#txtUsername').removeClass('required');
      }
    });

    $('#txtPassword').keyup(function(){
      if($('#txtPassword').val()!=''){
        $('#txtPassword').removeClass('required');
      }
    });

  });
</script>
<style media="screen">
  .ms-required{
    border-color: red;
  }
</style>
