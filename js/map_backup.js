var map;
var geocoder;
function initMap(){
  geocoder = new google.maps.Geocoder();
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
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      streetViewControl: false,
      zoom: 7
  });

  // fetchServicearea();

  setTimeout(function(){
    fetchMarker();
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
  $.post("core/fetch-marker.php" , function(data) {
    var maxVal = data[0].numcount;
    var maxRad = 500000/Number(maxVal);

    for (var i = 0; i < data.length; i++) {
      var cityCircle = new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0,
      strokeWeight: 0,
      fillColor: '#FF0000',
      fillOpacity: 0.7,
      map: map,
      center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
      radius: Math.sqrt(data[i].numcount) * maxRad
      // radius:  20000
    });
    }
  }, "json");
}

function fetchMarkerWithCondition(zoomlevel){
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
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      streetViewControl: false,
      zoom: zoomlevel
  });

  $maxRad = 10000;
  if($('#txtLevel').val()==4){
    $maxRad = 1000;
  }else if($('#txtLevel').val()==3){
    $maxRad = 6000;
  }else if($('#txtLevel').val()==1){
    $maxRad = 10000;
  }else if($('#txtLevel').val()==5){
    $maxRad = 1000;
  }

  // $maxRad = $maxRad * (50 * (16 - map.getZoom())/7) * 0.01;

  // alert($maxRad);
  $.post("core/fetch-marker-condition.php" , {
    txtLevel: $('#txtLevel').val()
  },function(data) {
    // alert(data.length);
      $maxVal = data[0].numcount;
      if($('#txtLevel').val()==2){
        var maxVal = data[0].numcount;
        $maxRad = 500000/Number(maxVal);
        for (var i = 0; i < data.length; i++) {
          var cityCircle = new google.maps.Circle({
          strokeColor: '#FF0000',
          strokeOpacity: 0,
          strokeWeight: 0,
          fillColor: '#FF0000',
          fillOpacity: 0.7,
          map: map,
          center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
          radius:  Math.sqrt(data[i].numcount) * $maxRad
          });
        }
      }else if($('#txtLevel').val()==5){
        if(map.getZoom()>13){
          $maxRad = 400;
        }else{
          $maxRad = 400;
        }
        for (var i = 0; i < data.length; i++) {
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
          var cityCircle = new google.maps.Circle({
          strokeColor: '#FF0000',
          strokeOpacity: 0,
          strokeWeight: 0,
          fillColor: '#FF0000',
          fillOpacity: 0.7,
          map: map,
          center: {lat: Number(data[i].lat), lng: Number(data[i].lng)},
          radius:  ($maxRad * ((100/$maxVal)/data[i].numcount)) * 4
        });
      }



    }
  }, "json");

  // map.addListener('zoom_changed', function() {
  //   fetchMarkerWithCondition(map.getZoom());
  // });
}
