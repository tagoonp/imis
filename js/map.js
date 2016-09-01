var map;
var geocoder;
var my_Marker = [];
var infowindow = [];
// var infoWindow;
var infowindowTmp;
var temp_marker = [];
var circle = [];
var mr = 100;
var mrr = [];
var usRoadMapType;
var circleTitle = [];
var nc;

function initMap(){

  $('.loadingDiv').show();
  $('.loadBG').show();

  circle = [];
  circleTitle = [];
  mrr = [];

  $('#infoPane').fadeOut('fast', function(){});

  usRoadMapType = new google.maps.StyledMapType([
						{
							"featureType": "landscape.natural",
							"elementType": "geometry.fill",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"color": "#e0efef"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "geometry.fill",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"hue": "#1900ff"
								},
								{
									"color": "#c0e8e8"
								}
							]
						},
						{
							"featureType": "road",
							"elementType": "geometry",
							"stylers": [
								{
									"lightness": 100
								},
								{
									"visibility": "simplified"
								}
							]
						},
						{
							"featureType": "road",
							"elementType": "labels",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "transit",
							"elementType": "labels",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "transit.line",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"lightness": 700
								}
							]
						},
						{
							"featureType": "water",
							"elementType": "all",
							"stylers": [
								{
									"color": "#7dcdcd"
								}
							]
						}
					], {name: 'Custom'});

  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map($('#map-canvas')[0], {
      center: {lat: 13.7251097, lng: 100.3529094},
      scrollwheel: true,
      mapTypeControl: true,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        mapTypeIds: [
          google.maps.MapTypeId.ROADMAP,
          'usroadatlas',
          google.maps.MapTypeId.TERRAIN,
          google.maps.MapTypeId.SATELLITE,
          google.maps.MapTypeId.HYBRID
        ],
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      streetViewControl: true,
      zoom: 6
  });

  map.mapTypes.set('usroadatlas', usRoadMapType);
  map.setMapTypeId('usroadatlas');

  setTimeout(function(){
    fetchMarker();
    fetchMarkerValue1();
    fetchMarkerValue2();
    fetchMarkerValue3();
  },1000);

  if($('#txtLevel').val()!='4'){
    google.maps.event.addListener(map, 'zoom_changed', function () {
      for (var i = 0; i < circle.length; i++) {
          var p = Math.pow(2, (21 - map.getZoom()));
          var cr = circle[i].getRadius() / p / 0.00027;
          circle[i].setRadius( p * mrr[i] * 0.00027);
      }
    });
  }


}

function fetchMarker(){
  $maxRad = 2800;

  $urlsd = './core/fetch-marker-province.php';
  $level = $('#txtLevel').val();
  switch($level){
    case '1': $urlsd = 'core/fetch-marker-province.php'; break; //ระดับจังหวัด
    case '2': $urlsd = 'core/fetch-marker-district.php'; break; //ระดับอำเภอ
    case '3': $urlsd = 'core/fetch-marker-tumbon.php'; break; //ระดับจังหวัด
    case '4': $urlsd = './core/fetch-marker-mongo.php'; break; //ระดับจังหวัด
    default: console.log('Invalid level filtering');
  }

  $items = 'false';$is = 'false';
  $road = 'false';$water = 'false';$fall = 'false';

  if($("#chItems").is(':checked')){ $items = 'true'; }
  if($("#chIs").is(':checked')){ $is = 'true'; }
  if($("#chRoad").is(':checked')){ $road = 'true'; }
  if($("#chWater").is(':checked')){ $water = 'true'; }
  if($("#chFall").is(':checked')){ $fall = 'true'; }

  // if($level==4){
  //   console.log('Level4');
  // }

  setTimeout(function(){
    // var jqxhr = $.post($urlsd , {sdate: $('#txtStart').val() , edate: $('#txtEnd').val(), sage: $('#txtAgestart').val() ,eage: $('#txtAgeend').val() , itemsdb: $items, isdb: $is, evt1: $road , evt2: $water , evt3: $fall } , function(data) {
    var jqxhr = $.post($urlsd, {  sdate: $('#txtStart').val() , edate: $('#txtEnd').val(), sage: $('#txtAgestart').val() ,eage: $('#txtAgeend').val(), evt1: $road , evt2: $water , evt3: $fall , dbitems: $items, dbis: $is } ,function(data) {

    },"json");

    jqxhr.fail(function(err){
      setTimeout(function(){
        $('.loadingDiv').hide();
        $('.loadBG').fadeOut('fast', function(){});
      },5000);
      console.log(err);
      swal("การเชื่อมต่อฐานข้อมูลล้มเหลว");
    });

    jqxhr.always(function(data){
      setTimeout(function(){
        $('.loadingDiv').hide();
        $('.loadBG').fadeOut('fast', function(){});
      },5000);

          if(data.length==0){
            swal("ไม่พบข้อมูล");
          }else{
            $max = 0;
            for (var i = 0; i < data.length; i++) {
              if(i==0){
                $max = data[0].num;
              }else{
                if(data[0].num > $max){
                  $max = data[0].num;
                }
              }
            }

            $maxVal = $max;
            $maxRad = $maxVal;
            mr = $maxVal + ($maxVal * 0.27);
            setTimeout(function(){

              var icon = 'images/p0.png';

              for (var i = 0; i < data.length; i++) {
                $maxRad = (Number(data[i].num) * 100)/$maxVal;
                $color = '#FF0000';

                if($level==4){
                  if(data[i].atype=='25'){
                    icon = 'images/mr0p.png';
                  }else if(data[i].atype=='23'){
                    icon = 'images/mb40p.png';
                  }else if(data[i].atype=='24'){
                    icon = 'images/my60p.png';
                  }

                  $maxRad = 500;

                  var markerLatLng = new google.maps.LatLng(Number(data[i].lat), Number(data[i].lng));
                  my_Marker[i] = new google.maps.Marker({
                      position: markerLatLng,
                      map: map,
                      icon: icon
                  });

                  circleTitle.push((data[i].prov));
                  circle.push(my_Marker[i]);

                  (function(circle, i) {
                      // add click event
                      google.maps.event.addListener(circle[i], 'click', function(evt) {
                        $('#infoSpan').html('<img src="images/spinner.gif" width="100%">');

                        if($('#infoPane').css('display')=='none'){
                          $('#infoPane').fadeIn('fast', function(){});
                        }

                        $url_infocontent = 'core/placeDetail_mongo.php?place_id=' + circleTitle[i];

                        $dbitems = 'false'; $dbis = 'false';
                        $road = 'false'; $water = 'false'; $fall = 'false';
                        $Allis = 'Yes';

                        if($("#chItems").is(':checked')){ $dbitems = 'true'; }
                        if($("#chIs").is(':checked')){ $dbis = 'true'; }
                        if(!$("#chAge").is(':checked')){ $Allis = 'No'; }
                        if($("#chRoad").is(':checked')){ $road = 'true'; }
                        if($("#chWater").is(':checked')){ $water = 'true'; }
                        if($("#chFall").is(':checked')){ $fall = 'true'; }

                        // console.log(circleTitle[i]);
                        var jqxhr = $.post($url_infocontent,  {    id: circleTitle[i]    },function(result){ });

                        jqxhr.always(function(data){
                          $('#infoSpan').html(data);
                        });

                      }); //End eventListener
                  })(circle, i);

                // End level type 4
                }else{
                  if(($maxRad >= 0 ) && ($maxRad < 20)){
                    // $maxRad = 1300;
                    switch($level){
                      case '1': $maxRad = 1300; break;
                      case '2': $maxRad = 900; break;
                      case '3': $maxRad = 600; break;
                    }
                  }else if(($maxRad >= 21 ) && ($maxRad < 40)){
                    // $maxRad = 1800;
                    switch($level){
                      case '1': $maxRad = 1800; break;
                      case '2': $maxRad = 1000; break;
                      case '3': $maxRad = 800; break;
                    }
                  }else if(($maxRad >= 41 ) && ($maxRad < 60)){
                    // $maxRad = 2300;
                    switch($level){
                      case '1': $maxRad = 2300; break;
                      case '2': $maxRad = 1200; break;
                      case '3': $maxRad = 1000; break;
                    }
                  }else if(($maxRad >= 61 ) && ($maxRad < 80)){
                    switch($level){
                      case '1': $maxRad = 3000; break;
                      case '2': $maxRad = 1500; break;
                      case '3': $maxRad = 1200; break;
                    }
                  }else if($maxRad >= 81 ){
                    switch($level){
                      case '1': $maxRad = 4000; break;
                      case '2': $maxRad = 2000; break;
                      case '3': $maxRad = 1500; break;
                    }
                  }

                  var p = Math.pow(2, (21 - map.getZoom()));

                  var cityCircle = new google.maps.Circle({
                    strokeColor: '',
                    strokeOpacity: 0,
                    strokeWeight: 0,
                    fillColor: $color,
                    fillOpacity: 0.7,
                    map: map,
                    center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
                    radius: p * $maxRad * 0.00027
                  });

                  circleTitle.push((data[i].prov));

                  mrr.push($maxRad);
                  circle.push(cityCircle);

                  (function(circle, i) {
                      // add click event
                      google.maps.event.addListener(circle[i], 'click', function(evt) {
                        $('#infoSpan').html('<img src="images/spinner.gif" width="100%">');

                        if($('#infoPane').css('display')=='none'){
                          $('#infoPane').fadeIn('fast', function(){});
                        }

                        for (var j = 0; j < circle.length; j++) {
                          circle[j].setOptions({
                            fillColor: '#FF0000',
                            fillOpacity: 0.7
                          });
                        }

                        circle[i].setOptions({
                          fillColor: '#FF9200',
                          fillOpacity: 0.9
                        });

                        if($('#txtLevel').val()==1){
                          $url_infocontent = 'core/placeDetail_province_mongo.php?place_id=' + circleTitle[i];
                        }else if($('#txtLevel').val()==2){
                          $url_infocontent = 'core/placeDetail_district_mongo.php?place_id=' + circleTitle[i];
                        }else if($('#txtLevel').val()==3){
                          $url_infocontent = 'core/placeDetail_tabmon_mongo.php?place_id=' + circleTitle[i];
                        }else if($('#txtLevel').val()==4){
                          $url_infocontent = 'core/placeDetail_mongo.php?place_id=' + circleTitle[i];
                        }

                        // console.log(circleTitle[i]);

                        $items = 'false';$dbis = 'false';
                        $road = 'false';$water = 'false';$fall = 'false';
                        $Allis = 'Yes';

                        if($("#chItems").is(':checked')){ $items = 'true'; }
                        if($("#chIs").is(':checked')){ $dbis = 'true'; }
                        if($("#chRoad").is(':checked')){ $road = 'true'; }
                        if($("#chWater").is(':checked')){ $water = 'true'; }
                        if($("#chFall").is(':checked')){ $fall = 'true'; }

                        var jqxhr = $.post($url_infocontent,
                          {
                            dateStart: $('#txtStart').val() ,
                            dateEnd: $('#txtEnd').val(),
                            ageStart: $('#txtAgestart').val() ,
                            ageEnd: $('#txtAgeend').val(),
                            dbitems: $items,
                            dbis: $dbis,
                            evt1: $road ,
                            evt2: $water ,
                            evt3: $fall
                          },
                          function(result){
                        });

                        jqxhr.always(function(data){
                          $('#infoSpan').html(data);
                        });

                      }); //End eventListener
                  })(circle, i);

                }

              }


            }, 1000);
          }

    }, "json");
  },5000);
}

function setI(i){
  // console.log(i);
  nc = i;
}

function showArrays(evt){
  // console.log(nc);
  var contentString = 'asd' + nc;
  infoWindow.setContent(contentString);
  infoWindow.setPosition(evt.latLng);
  infoWindow.open(map);
}

function HandleInfoWindow(latLng, content) {
    infoWindow.setPosition(latLng);
    infoWindow.setContent(content)
    infoWindow.open(map);
    // console.log(i);
}

function addInfowindow(marker, infowindow, i, map, infowindowTmp){
  // process multiple info windows
                    (function(marker, i) {
                        // add click event
                        google.maps.event.addListener(marker, 'click', function() {
                          if(infowindowTmp){ // ให้ตรวจสอบว่ามี infowindow ตัวไหนเปิดอยู่หรือไม่
                              infowindow.close();  // ถ้ามีให้ปิด infowindow ที่เปิดอยู่
                          }

                          // infowindow = new google.maps.InfoWindow({
                          //       content: 'Hello, World!!'
                          // });

                          infowindow.open(map, marker);
                          infowindowTmp = i;
                        });
                    })(marker, i);
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

  var jqxhr = $.post('core/fetch-marker-value1.php',{
  // var jqxhr = $.post('http://104.155.215.92/imis/core/fetch-marker-value1.php',{
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    isall: $isAll,
    eventtype: $eventType.toString()
  }, function(data){}, "json");

  jqxhr.fail(function(err){
    // for (var i = 0; i < 3; i++) {
    //     $('#result' + (i+1) + '_1').text(err);
    // }
    // console.log(err);
  });

  jqxhr.always(function(data){
    // console.log(data);
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



  var jqxhr = $.post('core/fetch-marker-value2.php',{
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    isall: $isAll,
    eventtype: $eventType.toString()
  }, function(data){}, "json");

  jqxhr.fail(function(err){
    for (var i = 0; i < 3; i++) {
        $('#result' + (i+1) + '_2').text(err);
    }
  });

  jqxhr.always(function(data){
    // console.log(data[1].numcount);
    // console.log(data);
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

  $eventType = [];

  for (var i = 0; i < 3; i++) {
      $('#result' + (i+1) + '_3').text('Processing..');
  }

  if(!$("#chItems").is(':checked')){ $itemcb = 'No'; }
  if(!$("#chIs").is(':checked')){ $iscb = 'No'; }
  if($("#chRoad").is(':checked')){ $eventType.push(25); }
  if($("#chWater").is(':checked')){ $eventType.push(23); }
  if($("#chFall").is(':checked')){ $eventType.push(24); }



  var jqxhr = $.post('core/fetch-marker-value3.php',{
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    eventtype: $eventType.toString()
  }, function(data){}, "json");

  jqxhr.fail(function(err){
    console.log(err);
  });

  jqxhr.always(function(data){
    // console.log(data[1].numcount);
    // console.log(data);
    for (var i = 0; i < data.length; i++) {
        $('#result' + (i+1) + '_3').text(data[i].numcount);
    }
  });
}

function markerRoadAccident(i, icon,lat,lng,province,district,tumbon){
  // alert('a');
  var markerLatLng = new google.maps.LatLng(lat,lng);
  my_Marker[i] = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      icon: icon
  });
}

function markerWaterAccident(i, icon,lat,lng,province,district,tumbon){
  var markerLatLng = new google.maps.LatLng(lat,lng);
  my_Marker[i] = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      icon: icon
  });
}

function markerFallAccident(i, icon,lat,lng,province,district,tumbon){
  var markerLatLng = new google.maps.LatLng(lat,lng);
  my_Marker[i] = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      icon: icon
  });
}

function initLog(){
  // เรียกใช้คุณสมบัติ ระบุตำแหน่ง ของ html 5 ถ้ามี
	if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(function(position){
				var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        var cLat = position.coords.latitude;
        var cLng = position.coords.longitude;
			},function() {
				// คำสั่งทำงาน ถ้า ระบบระบุตำแหน่ง geolocation ผิดพลาด หรือไม่ทำงาน
			});
	}else{
		 // คำสั่งทำงาน ถ้า บราวเซอร์ ไม่สนับสนุน ระบุตำแหน่ง
	}
}
