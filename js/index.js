$(document).ready(function(){
  var height = $('#map-canvas').height();
  // var displayPanelHeight = (0.63 * height);
  var displayPanelHeight = (height);

  $('.displayPanel').css('height', displayPanelHeight + 'px');
  // $('#sidebar-wrapper').css('height', displayPanelHeight + 'px');
  // console.log(displayPanelHeight + 50);
  setTimeout(function(){
    initMap();
  },1000);
});

var csrftoken = $.cookie('csrftoken');

function csrfSafeMethod(method) {
    // these HTTP methods do not require CSRF protection
    return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}

$.ajaxSetup({
    beforeSend: function(xhr, settings) {
        if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
            xhr.setRequestHeader("X-CSRFToken", csrftoken);
        }
    }
});

$(function(){
  $('#login').click(function(){
    $("#overlay").fadeToggle("",function(){ // แสดงส่วนของ overlay
            $('body').css('overflow-y','hidden');
            $(".doctor_show").slideToggle("",function(){ // แสดงส่วนของ เนื้อหา popup
              alert('asd');
                if($(this).css("display")=="block"){        // ถ้าเป็นกรณีแสดงข้อมูล
                 $.post("core/login-screen.php",{},function(data){
                     $(".msg_data").html(data);

                 });
                }
            });
    });
  });

  $('#btnGen').click(function(){
    if($("#chItems").is(':checked') || $("#chIs").is(':checked')){
      if($("#chRoad").is(':checked') || $("#chWater").is(':checked') || $("#chFall").is(':checked')){
        $('#btnGen').blur();
        initMap();
      }else{
        $('#btnGen').blur();
        swal("ขออภัย!", "กรุณาเลือกฐานประเภทเหตุการณ์ในการกรองข้อมูล!", "warning")
      }
    }else{
      $('#btnGen').blur();
      swal("ขออภัย!", "กรุณาเลือกฐานข้อมูลในการกรองข้อมูล!", "warning")
    }
  });

  // $('#txtLevel').change(function(){
  //   initMap();
  // });

  // $('.cb').click(function(){
  //   initMap();
  // });
});
