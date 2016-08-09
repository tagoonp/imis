var tm;
var height = 400;
var myMapOptions;
var marker;
$(document).ready(function(){
  height = $('#map-canvas2').height();
  $('#mapcontainer').css('height', (height-200) + 'px');
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

  if($level==1){
    $.post("core/fetch-timemap-marker-mongo-province.php", { level: 1, sage: $('#')}, function(){},"json")
      .done(function(){
        console.log('Loading...');
      },"json")
      .always(function(data){
        marker = data;
        pinMarker();
      },"json");
  }else if($level==2){

  }else if($level==3){

  }else if($level==4){

  }

  // $.getJSON("core/fetch-timemap-marker-mongo-province.php")
  //   .done(function(){
  //     console.log('Loading...');
  //   })
  //   .always(function(data){
  //     marker = data;
  //     pinMarker();
  // });
}

function pinMarker(){
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
          Timeline.DateTime.WEEK,
          Timeline.DateTime.MONTH
      ]
  });

  // set the map to our custom style
  var gmap = tm.getNativeMap();
  gmap.setOptions(myMapOptions);
}
