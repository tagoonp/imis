$(function(){
  $('#btnGen').click(function(){
    initMap();
  });

  $('#txtProv').change(function(){
    $('.loadingDiv').show();
    $('.loadBG').show();

    $proval = $('#txtProv').val();

    $('#txtDistrict').empty();
    $('#txtDistrict').append($('<option>').text('--- เลือกอำเภอ ---').attr('value', ''));

    $('#txtTumbon').empty();
    $('#txtTumbon').append($('<option>').text('--- เลือกตำบล ---').attr('value', ''));

    var jqxhr = $.post('core/fetch-district.php', {prov_id: $proval}, function(data){}, "json");
    jqxhr.always(function(data){

      $('.loadingDiv').hide();
      $('.loadBG').fadeOut('fast', function(){});

      $('#txtDistrict').empty();
      $('#txtDistrict').append($('<option>').text('--- เลือกอำเภอ ---').attr('value', ''));
      $.each(data, function(i, value) {
            $('#txtDistrict').append($('<option>').text(value.pname).attr('value', value.id));
      });

    },"json");
  });

  $('#txtDistrict').change(function(){

    $('.loadingDiv').show();
    $('.loadBG').show();

    $proval = $('#txtProv').val();
    $distval = $('#txtDistrict').val();
    var jqxhr = $.post('core/fetch-tumbon.php', {prov_id: $proval, dist_id: $distval}, function(data){}, "json");
    jqxhr.always(function(data){

      $('.loadingDiv').hide();
      $('.loadBG').fadeOut('fast', function(){});

      $('#txtTumbon').empty();
      $('#txtTumbon').append($('<option>').text('--- เลือกตำบล ---').attr('value', ''));
      $.each(data, function(i, value) {
            $('#txtTumbon').append($('<option>').text(value.pname).attr('value', value.id));
      });

    },"json");
  });


});
