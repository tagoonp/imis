var tm;
var height = 400;
var myMapOptions;
var marker;
var map;
$(document).ready(function(){
  height = $('#map-canvas2').height();
  $('#mapcontainer').css('height', (height-200) + 'px');

  // $('.loadingDiv').show();
  // $('.loadBG').show();

  fetchProvince();
  setTimeout(function(){
    initMap_null();
    // fetchMarkerValue1();
    // fetchMarkerValue2();
    // fetchMarkerValue3();
  },3000);
  // initMap_null();

});

function initMap(){
  myMapOptions = {
      zoomControl: true,
      zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL
      },
      scrollwheel: true
  };

  $level = $('#txtLevel').val();

  $items = 'false';$is = 'false';
  $road = 'false';$water = 'false';$fall = 'false';

  if($("#chItems").is(':checked')){ $items = 'true'; }
  if($("#chIs").is(':checked')){ $is = 'true'; }
  if($("#chRoad").is(':checked')){ $road = 'true'; }
  if($("#chWater").is(':checked')){ $water = 'true'; }
  if($("#chFall").is(':checked')){ $fall = 'true'; }

  if($('#txtProv').val()==''){
    //Alert กรุณาเลือกจังหวัด
    swal('กรุณาเลือกจังหวัด');
  }else if($('#txtDistrict').val()==''){
    //Query หมุดตามจังหวัดนั้น
    fetchMarkerValue1();
    fetchMarkerValue2();
    fetchMarkerValue3();

    var jqxhr = $.post("core/fetch-timemap-marker-mongo-province.php", {
       level: 1,
       province: $('#txtProv').val(),
       district: $('#txtDistrict').val(),
       tumbon: $('#txtTumbon').val(),
       sdate: $('#txtStart').val() ,
       edate: $('#txtEnd').val(),
       sage: $('#txtAgestart').val() ,
       eage: $('#txtAgeend').val(),
       evt1: $road ,
       evt2: $water ,
       evt3: $fall
     }, function(data){},"json");

      jqxhr .done(function(){
        console.log('Loading...');
      },"json");

      jqxhr.always(function(data){

        setTimeout(function(){
          $('.loadingDiv').hide();
          $('.loadBG').fadeOut('fast', function(){});
        },5000);

        marker = data;
        pinMarker(marker);
      },"json");

  }else if($('#txtTumbon').val()==''){
    //Query หมุดตามจังหวัด และอำเภอนั้น
    fetchMarkerValue1();
    fetchMarkerValue2();
    fetchMarkerValue3();

    var jqxhr = $.post("core/fetch-timemap-marker-mongo-district.php", {
       level: 1,
       province: $('#txtProv').val(),
       district: $('#txtDistrict').val(),
       tumbon: $('#txtTumbon').val(),
       sdate: $('#txtStart').val() ,
       edate: $('#txtEnd').val(),
       sage: $('#txtAgestart').val() ,
       eage: $('#txtAgeend').val(),
       evt1: $road ,
       evt2: $water ,
       evt3: $fall
     }, function(data){},"json");

      jqxhr .done(function(){
        console.log('Loading...');
      },"json");

      jqxhr.always(function(data){

        setTimeout(function(){
          $('.loadingDiv').hide();
          $('.loadBG').fadeOut('fast', function(){});
        },5000);

        marker = data;
        pinMarker(marker);
      },"json");
  }else{
    //Query หมุดตามจังหวัด อำเภอ และตำบลนั้น
    var jqxhr = $.post("core/fetch-timemap-marker-mongo-tumbon.php", {
       level: 1,
       province: $('#txtProv').val(),
       district: $('#txtDistrict').val(),
       tumbon: $('#txtTumbon').val(),
       sdate: $('#txtStart').val() ,
       edate: $('#txtEnd').val(),
       sage: $('#txtAgestart').val() ,
       eage: $('#txtAgeend').val(),
       evt1: $road ,
       evt2: $water ,
       evt3: $fall
     }, function(data){},"json");

      jqxhr .done(function(){
        console.log('Loading...');
      },"json");

      jqxhr.always(function(data){

        setTimeout(function(){
          $('.loadingDiv').hide();
          $('.loadBG').fadeOut('fast', function(){});
        },5000);

        marker = data;
        pinMarker(marker);
      },"json");
    fetchMarkerValue1();
    fetchMarkerValue2();
    fetchMarkerValue3();
  }
}

function initMap_null(){

  myMapOptions = {
      zoomControl: true,
      zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL
      },
      scrollwheel: true
  };
}

function pinMarker(marker){
  // console.log(JSON.stringify(marker));
  tm = TimeMap.init({
      mapId: "map",               // Id of map div element (required)
      timelineId: "timeline",     // Id of timeline div element (required)
      options: {
          mapType: "physical",
          eventIconPath: "../images/",
          centerMapOnItems: false,
          mapZoom: 5
      },

      datasets: [
          {
              id: "artists",
              title: "Artists",
              theme: "orange",
              // note that the lines below are now the preferred syntax
              type: "basic",

              options: {
                items: marker
              }
          }
      ],
      bandIntervals: [
          // Timeline.DateTime.WEEK,
          // Timeline.DateTime.MONTH
          Timeline.DateTime.DAY,
          Timeline.DateTime.WEEK
      ]
  });

  // set the map to our custom style
  var gmap = tm.getNativeMap();
  gmap.setOptions(myMapOptions);
}

function fetchMarkerValue1(){
  $newData = [];

  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';
  $isAll = 'Yes';

  $eventType = [];

  for (var i = 0; i < 3; i++) {
      $('#result' + (i+1) + '_1').text('Processing..');
  }

  if(!$("#chItems").is(':checked')){ $itemcb = 'No'; }
  if(!$("#chIs").is(':checked')){ $iscb = 'No'; }
  if(!$("#chAge").is(':checked')){ $isAll = 'No'; }
  if($("#chRoad").is(':checked')){ $eventType.push(25); }
  if($("#chWater").is(':checked')){ $eventType.push(23); }
  if($("#chFall").is(':checked')){ $eventType.push(24); }

  var jqxhr = $.post('core/fetch-marker-value1-tm.php',{
  // var jqxhr = $.post('http://104.155.215.92/imis/core/fetch-marker-value1.php',{
    province: $('#txtProv').val(),
    district: $('#txtDistrict').val(),
    tumbon: $('#txtTumbon').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    dbis: $iscb,
    eventtype: $eventType.toString()
  }, function(data){}, "json");

  jqxhr.fail(function(err){
    console.log(err);
  });

  jqxhr.always(function(data){
    console.log(data);
    for (var i = 0; i < data.length; i++) {
        $('#result' + (i+1) + '_1').text(data[i].numcount);
    }
  });
}

function fetchMarkerValue2(){
  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';
  $isAll = 'Yes';

  $eventType = [];

  for (var i = 0; i < 3; i++) {
      $('#result' + (i+1) + '_2').text('Processing..');
  }

  if(!$("#chItems").is(':checked')){ $itemcb = 'No'; }
  if(!$("#chIs").is(':checked')){ $iscb = 'No'; }
  if(!$("#chAge").is(':checked')){ $isAll = 'No'; }
  if($("#chRoad").is(':checked')){ $eventType.push(25); }
  if($("#chWater").is(':checked')){ $eventType.push(23); }
  if($("#chFall").is(':checked')){ $eventType.push(24); }



  var jqxhr = $.post('core/fetch-marker-value2-tm.php',{
    province: $('#txtProv').val(),
    district: $('#txtDistrict').val(),
    tumbon: $('#txtTumbon').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    dbis: $iscb,
    eventtype: $eventType.toString()
  }, function(data){}, "json");

  jqxhr.fail(function(err){
    for (var i = 0; i < 3; i++) {
        $('#result' + (i+1) + '_2').text(err);
    }
  });

  jqxhr.always(function(data){
    for (var i = 0; i < data.length; i++) {
        $('#result' + (i+1) + '_2').text(data[i].numcount);
    }
  });


}



function fetchMarkerValue3(){

  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';
  $isAll = 'Yes';

  $eventType = [];

  for (var i = 0; i < 3; i++) {
      $('#result' + (i+1) + '_3').text('Processing..');
  }

  if(!$("#chItems").is(':checked')){ $itemcb = 'No'; }
  if(!$("#chIs").is(':checked')){ $iscb = 'No'; }
  if($("#chRoad").is(':checked')){ $eventType.push(25); }
  if($("#chWater").is(':checked')){ $eventType.push(23); }
  if($("#chFall").is(':checked')){ $eventType.push(24); }



  var jqxhr = $.post('core/fetch-marker-value3-tm.php',{
    province: $('#txtProv').val(),
    district: $('#txtDistrict').val(),
    tumbon: $('#txtTumbon').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    dbis: $iscb,
    eventtype: $eventType.toString()
  }, function(data){}, "json");

  jqxhr.fail(function(err){
    console.log(err);
  });

  jqxhr.always(function(data){
    console.log(data);
    for (var i = 0; i < data.length; i++) {
        $('#result' + (i+1) + '_3').text(data[i].numcount);
    }
  });
}


function fetchProvince(){
  var jqxhr = $.post('core/fetch-province.php', function(data){}, "json");
  jqxhr.always(function(data){
    $.each(data, function(i, value) {
          $('#txtProv').append($('<option>').text(value.pname).attr('value', value.id));
    });

  },"json");
}
