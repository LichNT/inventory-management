var map = new google.maps.Map(document.getElementById('map-canvas'),{
  center:{
    lat: +document.getElementById('lat').value,
    lng: +document.getElementById('long').value
  },
  zoom:15
});
var marker = new google.maps.Marker({
  position: {
    lat: +document.getElementById('lat').value,
    lng: +document.getElementById('long').value
  },
  map: map,
  draggable: true
});
var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
google.maps.event.addListener(searchBox,'places_changed',function(){
  var places = searchBox.getPlaces();
  var bounds = new google.maps.LatLngBounds();
  var i, place;
  for(i=0; place=places[i];i++){
    bounds.extend(place.geometry.location);
    marker.setPosition(place.geometry.location);
  }
  map.fitBounds(bounds);
  map.setZoom(15);
});
google.maps.event.addListener(marker,'position_changed',function(){
  console.log(marker.getPosition());
  var lat = marker.getPosition().lat();
  var lng = marker.getPosition().lng();
  $('#lat').val(lat);
  $('#long').val(lng);
});
$('#long').change(function () {
  var map = new google.maps.Map(document.getElementById('map-canvas'),{
    center:{
      lat: +document.getElementById('lat').value,
      lng: +document.getElementById('long').value
    },
    zoom:15
  });
  var marker = new google.maps.Marker({
    position: {
      lat: +document.getElementById('lat').value,
      lng: +document.getElementById('long').value
    },
    map: map,
    draggable: true
  });
  var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
  google.maps.event.addListener(searchBox,'places_changed',function(){
    var places = searchBox.getPlaces();
    var bounds = new google.maps.LatLngBounds();
    var i, place;
    for(i=0; place=places[i];i++){
      bounds.extend(place.geometry.location);
      marker.setPosition(place.geometry.location);
    }
    map.fitBounds(bounds);
    map.setZoom(15);
  });
  google.maps.event.addListener(marker,'position_changed',function(){
    console.log(marker.getPosition());
    var lat = marker.getPosition().lat();
    var lng = marker.getPosition().lng();
    $('#lat').val(lat);
    $('#long').val(lng);
  });
});

$('#lat').change(function () {
  var map = new google.maps.Map(document.getElementById('map-canvas'),{
    center:{
      lat: +document.getElementById('lat').value,
      lng: +document.getElementById('long').value
    },
    zoom:15
  });
  var marker = new google.maps.Marker({
    position: {
      lat: +document.getElementById('lat').value,
      lng: +document.getElementById('long').value
    },
    map: map,
    draggable: true
  });
  var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
  google.maps.event.addListener(searchBox,'places_changed',function(){
    var places = searchBox.getPlaces();
    var bounds = new google.maps.LatLngBounds();
    var i, place;
    for(i=0; place=places[i];i++){
      bounds.extend(place.geometry.location);
      marker.setPosition(place.geometry.location);
    }
    map.fitBounds(bounds);
    map.setZoom(15);
  });
  google.maps.event.addListener(marker,'position_changed',function(){
    console.log(marker.getPosition());
    var lat = marker.getPosition().lat();
    var lng = marker.getPosition().lng();
    $('#lat').val(lat);
    $('#long').val(lng);
  });
});
