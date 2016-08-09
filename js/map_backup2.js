var map;
var geocoder;
var my_Marker = [];
function initMap(){
  var usRoadMapType = new google.maps.StyledMapType([
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
  map = new google.maps.Map(document.getElementById('map-canvas'), {
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
      streetViewControl: false,
      zoom: 6
  });

  map.mapTypes.set('usroadatlas', usRoadMapType);
  map.setMapTypeId('usroadatlas');

  // fetchServicearea();

  setTimeout(function(){
    fetchMarker();
    fetchMarkerValue1();
    fetchMarkerValue2();
    fetchMarkerValue3();
  },1000);

}

function fetchServicearea(){
  $.post("core/fetch-servicearea.php" , function(data) {
    $.each(data,function(i,k){
            $('#txtSA').append($('<option>', {
                value: data[i].sa_id,
                text: data[i].sa_name
            }));
    });
  }, "json");
}

function fetchMarker(){
  $maxRad = 28000;
  $.post("core/fetch-marker.php" , function(data) {
    $maxVal = data[0].numcount;
    $maxRad = $maxVal;
    
    var icon = 'images/p0.png';

    for (var i = 0; i < data.length; i++) {
      $maxRad = (Number(data[i].numcount) * 100)/$maxRad;
      if(($maxRad >= 0 ) && ($maxRad < 10)){
        icon = 'images/p0.png';
      }else if(($maxRad >= 11 ) && ($maxRad < 20)){
        icon = 'images/p1.png';
      }else if(($maxRad >= 21 ) && ($maxRad < 40)){
        icon = 'images/p2.png';
      }else if(($maxRad >= 41 ) && ($maxRad < 60)){
        icon = 'images/p3.png';
      }else if(($maxRad >= 61 ) && ($maxRad < 80)){
        icon = 'images/p4.png';
      }else if($maxRad >= 81 ){
        icon = 'images/p5.png';
      }

      var Marker = new google.maps.Marker({
        position: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
        map: map,
        icon: icon
      });
    }
  }, "json");


}

function fetchMarkerValue1(){
  $newData = [];
  // $.post("core/fetch-marker-value1.php" , function(data) {
  //   for (var i = 0; i < data.length; i++) {
  //     // $('#result' + (i+1) + '_1').text(data[i].numcount);
  //     $newData.push(data[i].numcount);
  //   }
  // }, "json");

  $.getJSON("core/fetch-marker-value1.php")
    .done(function(){
      console.log('Loading...');
    })
    .always(function(data){
      // console.log(data.length);
      for (var i = 0; i < data.length; i++) {
          $newData.push(data[i].numcount);
      }
      // setTimeout(function(data){
      //   setValue1($newData);
      // },1000);
      setValue1($newData);
    });

  // setTimeout(function(data){
  //   setValue1($newData);
  // },3000);
}

function fetchMarkerValueCondition1(){
  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';



  var eventType = [];

  if(!$("#chItems").is(':checked')){
    $itemcb = 'No';
  }
  if(!$("#chIs").is(':checked')){
    $iscb = 'No';
  }
  if($("#chRoad").is(':checked')){

  }else{
    $isRoad = 'No';
  }
  if($("#chWater").is(':checked')){

  }else{
    $isWater = 'No';
  }
  if($("#chFall").is(':checked')){

  }else{
    $isFall = 'No';
  }

  $newData = [];
  $.post("core/fetch-marker-value-condition-1.php" ,{
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    isRoad: $isRoad,
    isWater: $isWater,
    isFall: $isFall
  }, function(data) {
    // console.log(JSON.stringify(data));
    // for (var i = 0; i < data.length; i++) {
    //   $newData.push(data[i].numcount);
    // }
    //
    // setTimeout(function(data){
    //   setValue1($newData);
    // },3000);


  }, "json")
  .done(function(){
    console.log('Loading...');
  })
  .always(function(data){
    // console.log(data.length);
    for (var i = 0; i < data.length; i++) {
        $newData.push(data[i].numcount);
    }
    // setTimeout(function(data){
      setValue1($newData);
    // },1000);
  });

  // $.getJSON("core/fetch-marker-value-condition-1.php", {
  //   txtLevel: $('#txtLevel').val(),
  //   ageStart: $('#txtAgestart').val(),
  //   ageEnd: $('#txtAgeend').val(),
  //   dateStart: $('#txtStart').val(),
  //   dateEnd: $('#txtEnd').val(),
  //   itemcb: $itemcb,
  //   iscb: $iscb,
  //   isRoad: $isRoad,
  //   isWater: $isWater,
  //   isFall: $isFall
  // }, "json")
  // .done(function(data){
  //   console.log(data.length);
  //   for (var i = 0; i < data.length; i++) {
  //       $newData.push(data[i].numcount);
  //   }
  //   setValue1($newData);
  // })
  // .fail(function(){
  //   console.log('fail');
  // });
}

function setValue1(data){
  for (var i = 0; i < data.length; i++) {
    // if(i==0){
    //   if(Number($('#result1_1').text()) > data[i]){
    //     $('#result' + (i+1) + '_1').text(data[i]);
    //   }else{
    //
    //   }
    // }else{
      $('#result' + (i+1) + '_1').text(data[i]);
    // }
  }
}
function fetchMarkerValue2(){
  $.post("core/fetch-marker-value2.php" , function(data) {
    // console.log(JSON.stringify(data));
    for (var i = 0; i < data.length; i++) {
      $('#result' + (i+1) + '_2').text(data[i].numcount);
    }
  }, "json");
}

function fetchMarkerValueCondition2(){
  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';

  var eventType = [];

  if(!$("#chItems").is(':checked')){
    $itemcb = 'No';
  }
  if(!$("#chIs").is(':checked')){
    $iscb = 'No';
  }
  if($("#chRoad").is(':checked')){

  }else{
    $isRoad = 'No';
  }
  if($("#chWater").is(':checked')){

  }else{
    $isWater = 'No';
  }
  if($("#chFall").is(':checked')){

  }else{
    $isFall = 'No';
  }

  for (var i = 0; i < 3; i++) {
    $('#result' + (i+1) + '_2').text(0);
  }

  $.post("core/fetch-marker-value-condition-2.php" ,{
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    isRoad: $isRoad,
    isWater: $isWater,
    isFall: $isFall
  }, function(data) {
    console.log(JSON.stringify(data));
    for (var i = 0; i < data.length; i++) {
      $('#result' + (i+1) + '_2').text(data[i].numcount);
    }
  }, "json");
}

function fetchMarkerValue3(){
  $.post("core/fetch-marker-value3.php" , function(data) {
    console.log(JSON.stringify(data));
    for (var i = 0; i < data.length; i++) {
      $('#result' + (i+1) + '_3').text(data[i].numcount);
    }
  }, "json");
}

function fetchMarkerValueCondition3(){
  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';

  var eventType = [];

  if(!$("#chItems").is(':checked')){
    $itemcb = 'No';
  }
  if(!$("#chIs").is(':checked')){
    $iscb = 'No';
  }
  if($("#chRoad").is(':checked')){

  }else{
    $isRoad = 'No';
  }
  if($("#chWater").is(':checked')){

  }else{
    $isWater = 'No';
  }
  if($("#chFall").is(':checked')){

  }else{
    $isFall = 'No';
  }

  for (var i = 0; i < 3; i++) {
    $('#result' + (i+1) + '_3').text(0);
  }

  $.post("core/fetch-marker-value-condition-3.php" ,{
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    isRoad: $isRoad,
    isWater: $isWater,
    isFall: $isFall
  }, function(data) {
    console.log(JSON.stringify(data));
    for (var i = 0; i < data.length; i++) {
      $('#result' + (i+1) + '_3').text(data[i].numcount);
    }
  }, "json");
}

function fetchMarkerWithCondition(zoomlevel){
  var usRoadMapType = new google.maps.StyledMapType([
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

  map = new google.maps.Map(document.getElementById('map-canvas'), {
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
      streetViewControl: false,
      zoom: 6
  });

  map.mapTypes.set('usroadatlas', usRoadMapType);
    map.setMapTypeId('usroadatlas');

  $maxRad = 28000;

  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';

  var eventType = [];

  if(!$("#chItems").is(':checked')){
    $itemcb = 'No';
  }
  if(!$("#chIs").is(':checked')){
    $iscb = 'No';
  }
  if($("#chRoad").is(':checked')){
    eventType.push(1);
  }
  if($("#chWater").is(':checked')){
    eventType.push(2);
  }
  if($("#chFall").is(':checked')){
    eventType.push(3);
  }

  $.post("core/fetch-marker-condition.php" , {
    txtLevel: $('#txtLevel').val(),
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    eventtype: eventType
  },function(data) {
    // alert(data.length);
      $maxVal = data[0].numcount;
      $maxRad = $maxVal;

      if($('#txtLevel').val()==2){
        for (var i = 0; i < data.length; i++) {
          $maxRad = (Number(data[i].numcount) * 100)/$maxRad;

          if(($maxRad >= 0 ) && ($maxRad < 10)){
            $maxRad = 10000;
          }else if(($maxRad >= 11 ) && ($maxRad < 20)){
            $maxRad = 16000;
          }else if(($maxRad >= 21 ) && ($maxRad < 40)){
            $maxRad = 19000;
          }else if(($maxRad >= 41 ) && ($maxRad < 60)){
            $maxRad = 22000;
          }else if(($maxRad >= 61 ) && ($maxRad < 80)){
            $maxRad = 25000;
          }else if($maxRad >= 81 ){
            $maxRad = 28000;
          }

          var cityCircle = new google.maps.Circle({
          strokeColor: '#FF0000',
          strokeOpacity: 0,
          strokeWeight: 0,
          fillColor: '#FF0000',
          fillOpacity: 0.7,
          map: map,
          center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
          // radius:  Math.sqrt(data[i].numcount) * $maxRad
          radius:  $maxRad
          });
        }
      }else if($('#txtLevel').val()==5){
        for (var i = 0; i < data.length; i++) {
          $maxRad = (Number(data[i].numcount) * 100)/$maxRad;

          if(($maxRad >= 0 ) && ($maxRad < 10)){
            $maxRad = 10000;
          }else if(($maxRad >= 11 ) && ($maxRad < 20)){
            $maxRad = 16000;
          }else if(($maxRad >= 21 ) && ($maxRad < 40)){
            $maxRad = 19000;
          }else if(($maxRad >= 41 ) && ($maxRad < 60)){
            $maxRad = 22000;
          }else if(($maxRad >= 61 ) && ($maxRad < 80)){
            $maxRad = 25000;
          }else if($maxRad >= 81 ){
            $maxRad = 28000;
          }

          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0,
            strokeWeight: 0,
            fillColor: '#FF0000',
            fillOpacity: 0.5,
            map: map,
            center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
            radius:  $maxRad
          });
        }
      }else if($('#txtLevel').val()==4){
        for (var i = 0; i < data.length; i++) {
          $maxRad = (Number(data[i].numcount) * 100)/$maxRad;

          if(($maxRad >= 0 ) && ($maxRad < 10)){
            $maxRad = 2000;
          }else if(($maxRad >= 11 ) && ($maxRad < 20)){
            $maxRad = 2500;
          }else if(($maxRad >= 21 ) && ($maxRad < 40)){
            $maxRad = 3000;
          }else if(($maxRad >= 41 ) && ($maxRad < 60)){
            $maxRad = 3500;
          }else if(($maxRad >= 61 ) && ($maxRad < 80)){
            $maxRad = 4000;
          }else if($maxRad >= 81 ){
            $maxRad = 4500;
          }

          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0,
            strokeWeight: 0,
            fillColor: '#FF0000',
            fillOpacity: 0.5,
            map: map,
            center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
            radius:  $maxRad
          });
        }
      }else{
        for (var i = 0; i < data.length; i++) {
          $maxRad = (Number(data[i].numcount) * 100)/$maxRad;

          if(($maxRad >= 0 ) && ($maxRad < 10)){
            $maxRad = 10000;
          }else if(($maxRad >= 11 ) && ($maxRad < 20)){
            $maxRad = 16000;
          }else if(($maxRad >= 21 ) && ($maxRad < 40)){
            $maxRad = 19000;
          }else if(($maxRad >= 41 ) && ($maxRad < 60)){
            $maxRad = 22000;
          }else if(($maxRad >= 61 ) && ($maxRad < 80)){
            $maxRad = 25000;
          }else if($maxRad >= 81 ){
            $maxRad = 28000;
          }

          var cityCircle = new google.maps.Circle({
          strokeColor: '#FF0000',
          strokeOpacity: 0,
          strokeWeight: 0,
          fillColor: '#FF0000',
          fillOpacity: 0.7,
          map: map,
          center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
          // radius:  ($maxRad * ((100/$maxVal)/data[i].numcount)) * 4
          radius:  $maxRad
        });
      }



    }
  }, "json");
}

function fetchMarkerWithCondition5(zoomlevel){
  map = new google.maps.Map(document.getElementById('map-canvas'), {
      center: {lat: 13.7251097, lng: 100.3529094},
      scrollwheel: true,
      mapTypeControl: true,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        mapTypeIds: [
          google.maps.MapTypeId.ROADMAP,
          google.maps.MapTypeId.TERRAIN
        ],
        position: google.maps.ControlPosition.TOP_RIGHT,

      },
      streetViewControl: false,
      zoom: 6,
      // styles: [
			// 			{
			// 				"featureType": "landscape.natural",
			// 				"elementType": "geometry.fill",
			// 				"stylers": [
			// 					{
			// 						"visibility": "on"
			// 					},
			// 					{
			// 						"color": "#e0efef"
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "poi",
			// 				"elementType": "all",
			// 				"stylers": [
			// 					{
			// 						"visibility": "off"
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "poi",
			// 				"elementType": "geometry.fill",
			// 				"stylers": [
			// 					{
			// 						"visibility": "on"
			// 					},
			// 					{
			// 						"hue": "#1900ff"
			// 					},
			// 					{
			// 						"color": "#c0e8e8"
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "road",
			// 				"elementType": "geometry",
			// 				"stylers": [
			// 					{
			// 						"lightness": 100
			// 					},
			// 					{
			// 						"visibility": "simplified"
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "road",
			// 				"elementType": "labels",
			// 				"stylers": [
			// 					{
			// 						"visibility": "on"
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "transit",
			// 				"elementType": "labels",
			// 				"stylers": [
			// 					{
			// 						"visibility": "off"
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "transit.line",
			// 				"elementType": "geometry",
			// 				"stylers": [
			// 					{
			// 						"visibility": "on"
			// 					},
			// 					{
			// 						"lightness": 700
			// 					}
			// 				]
			// 			},
			// 			{
			// 				"featureType": "water",
			// 				"elementType": "all",
			// 				"stylers": [
			// 					{
			// 						"color": "#7dcdcd"
			// 					}
			// 				]
			// 			}
			// 		]
  });

  $max = 500;

  $itemcb = 'Yes';
  $iscb = 'Yes';
  $isRoad = 'Yes';
  $isWater = 'Yes';
  $isFall = 'Yes';

  var eventType = [];

  if(!$("#chItems").is(':checked')){
    $itemcb = 'No';
  }
  if(!$("#chIs").is(':checked')){
    $iscb = 'No';
  }
  if($("#chRoad").is(':checked')){
    eventType.push(1);
  }
  if($("#chWater").is(':checked')){
    eventType.push(2);
  }
  if($("#chFall").is(':checked')){
    eventType.push(3);
  }

  $.post("core/fetch-marker-condition2.php" ,
  {
    txtLevel: 5,
    ageStart: $('#txtAgestart').val(),
    ageEnd: $('#txtAgeend').val(),
    dateStart: $('#txtStart').val(),
    dateEnd: $('#txtEnd').val(),
    itemcb: $itemcb,
    iscb: $iscb,
    eventtype: eventType
  },function(data) {

    $max = data[0].numcount;
    for (var i = 0; i < data.length; i++) {
      $dataLent = data[i].numcount;
      $pct = (($dataLent * 100)/$max);
      // console.log($pct + ' ' + data[i].lat + ' ' + data[i].lng);
      if(data[i].atype == 1){
        if(($pct >= 0 ) && ($pct < 10)){
          $icon = 'images/mr0p.png';
        }else if(($pct >= 11 ) && ($pct < 20)){
          $icon = 'images/mr10p.png';
        }else if(($pct >= 21 ) && ($pct < 40)){
          $icon = 'images/mr40p.png';
        }else if(($pct >= 41 ) && ($pct < 60)){
          $icon = 'images/mr60p.png';
        }else if(($pct >= 61 ) && ($pct < 80)){
          $icon = 'images/mr80p.png';
        }else if($pct >= 81 ){
          $icon = 'images/mr100p.png';
        }
        markerRoadAccident(i, $icon, data[i].lat, data[i].lng, data[i].province, data[i].district, data[i].tumbon);
      }else if(data[i].atype == 2){
        if(($pct >= 0 ) && ($pct < 10)){
          $icon = 'images/mb0p.png';
        }else if(($pct >= 11 ) && ($pct < 20)){
          $icon = 'images/mb10p.png';
        }else if(($pct >= 21 ) && ($pct < 40)){
          $icon = 'images/mb40p.png';
        }else if(($pct >= 41 ) && ($pct < 60)){
          $icon = 'images/mb60p.png';
        }else if(($pct >= 61 ) && ($pct < 80)){
          $icon = 'images/mb80p.png';
        }else if($pct >= 81 ){
          $icon = 'images/mb100p.png';
        }
        markerWaterAccident(i, $icon, data[i].lat, data[i].lng, data[i].province, data[i].district, data[i].tumbon);
      }else if(data[i].atype == 3){
        if(($pct >= 0 ) && ($pct < 33)){
          $icon = 'images/my0p.png';
        }else if(($pct >= 33 ) && ($pct < 67)){
          $icon = 'images/my60p.png';
        }else if($pct >= 67 ){
          $icon = 'images/my100p.png';
        }
        markerFallAccident(i, $icon, data[i].lat, data[i].lng, data[i].province, data[i].district, data[i].tumbon);
      }
    }
  }, "json");
}

function markerRoadAccident(i, icon,lat,lng,province,district,tumbon){
  // alert('a');
  var markerLatLng = new google.maps.LatLng(lat,lng);
  my_Marker[i] = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      icon: icon
      // title: placename + ' : à¸ˆà¸³à¸™à¸§à¸™ ' + numrow // à¹à¸ªà¸”à¸‡ title à¹€à¸¡à¸·à¹ˆà¸­à¹€à¸­à¸²à¹€à¸¡à¸²à¸ªà¹Œà¸¡à¸²à¸­à¸¢à¸¹à¹ˆà¹€à¸«à¸™à¸·à¸­
  });
}

function markerWaterAccident(i, icon,lat,lng,province,district,tumbon){
  var markerLatLng = new google.maps.LatLng(lat,lng);
  my_Marker[i] = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      icon: icon
      // title: placename + ' : à¸ˆà¸³à¸™à¸§à¸™ ' + numrow // à¹à¸ªà¸”à¸‡ title à¹€à¸¡à¸·à¹ˆà¸­à¹€à¸­à¸²à¹€à¸¡à¸²à¸ªà¹Œà¸¡à¸²à¸­à¸¢à¸¹à¹ˆà¹€à¸«à¸™à¸·à¸­
  });
}

function markerFallAccident(i, icon,lat,lng,province,district,tumbon){
  var markerLatLng = new google.maps.LatLng(lat,lng);
  my_Marker[i] = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      icon: icon
      // title: placename + ' : à¸ˆà¸³à¸™à¸§à¸™ ' + numrow // à¹à¸ªà¸”à¸‡ title à¹€à¸¡à¸·à¹ˆà¸­à¹€à¸­à¸²à¹€à¸¡à¸²à¸ªà¹Œà¸¡à¸²à¸­à¸¢à¸¹à¹ˆà¹€à¸«à¸™à¸·à¸­
  });
}
