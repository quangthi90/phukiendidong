var map, initLocation, browserSupportFlag, geocoder, infowindow, latitude, longitude, markersArray = [], defaulfLocation = new google.maps.LatLng(10.736208, 106.712816);
function handleNoGeolocation(a) {
  !0 == a ? alert("D\u1ecbch v\u1ee5 \u0111\u1ecbnh v\u1ecb \u0111\u1ecba l\u00fd c\u00f3 l\u1ed7i!") : alert("Tr\u00ecnh duy\u1ec7t kh\u00f4ng h\u1ed7 tr\u1ee3 \u0111\u1ecbnh v\u1ecb \u0111\u1ecba l\u00fd!");
  map.setCenter(defaulfLocation)
}
function initialize() {
  var a = {zoomControl:!0, zoomControlOptions:{style:google.maps.ZoomControlStyle.SMALL, position:google.maps.ControlPosition.RIGHT_TOP}, zoom:16, mapTypeId:google.maps.MapTypeId.ROADMAP};
  map = new google.maps.Map(document.getElementById("raovat_map_content"), a);
  navigator.geolocation ? (browserSupportFlag = !0, navigator.geolocation.getCurrentPosition(function(a) {
    initLocation = new google.maps.LatLng(a.coords.latitude, a.coords.longitude);
    latitude = a.coords.latitude;
    longitude = a.coords.longitude;
    addMarker(initLocation, "V\u1ecb tr\u00ed hi\u1ec7n t\u1ea1i c\u1ee7a b\u1ea1n", !0)
  }, function() {
    handleNoGeolocation(browserSupportFlag)
  })) : (browserSupportFlag = !1, handleNoGeolocation(browserSupportFlag))
}
function showMap(a, b, d, c, e) {
  var f = {zoomControl:!0, zoomControlOptions:{style:google.maps.ZoomControlStyle.SMALL, position:google.maps.ControlPosition.RIGHT_TOP}, zoom:16, mapTypeId:google.maps.MapTypeId.ROADMAP};
  map = new google.maps.Map(document.getElementById(c), f);
  a = new google.maps.LatLng(a, b);
  addMarker(a, d, e)
}
function findLocation(a, b) {
  geocoder || (geocoder = new google.maps.Geocoder);
  geocoder.geocode({address:a}, function(a, c) {
    c == google.maps.GeocoderStatus.OK ? (addMarker(a[0].geometry.location, a[0].formatted_address, b), setPositionRaoVatPost(a[0].geometry.location)) : alert("Kh\u00f4ng t\u00ecm th\u1ea5y \u0111\u1ecba ch\u1ec9 c\u1ea7n t\u00ecm")
  })
}
function btnMyLocation_Click() {
  map.setZoom(16);
  var a = "Vi tri cua ban</br>Vi do: " + latitude + "</br> kinh do: " + longitude, b = new google.maps.Marker({position:initLocation, map:map});
  (new google.maps.InfoWindow({content:a})).open(map, b)
}
function placeMarker(a) {
  var b = new google.maps.Marker({position:a, draggable:!0, animation:google.maps.Animation.DROP, map:map});
  markersArray.push(b);
  google.maps.event.addListener(b, "click", function(a) {
    b.setPosition(a.latLng);
    showInfoWindow(b)
  });
  google.maps.event.addListener(b, "dragstart", function() {
    infoWindow && infoWindow.close()
  });
  google.maps.event.addListener(b, "dragend", function(a) {
    b.setPosition(a.latLng);
    showInfoWindow(b)
  })
}
function addMarker(a, b, d) {
  var c = new google.maps.Marker({map:map});
  c.setPosition(a);
  markersArray.push(c);
  map.setCenter(a);
  infowindow || (infowindow = new google.maps.InfoWindow);
  var e;
  e = "<strong>" + b + "</strong></br></br>" + ('V\u0129 \u0111\u1ed9: <strong style="color:red;">' + a.lat() + "</strong></br>");
  e += 'Kinh \u0111\u1ed9: <strong style="color:red;">' + a.lng() + "</strong></br>";
  infowindow.setContent(e);
  google.maps.event.addListener(c, "click", function(a) {
    c.setPosition(a.latLng);
    infowindow.open(map, c)
  });
  !0 == d && (c.setDraggable(!0), google.maps.event.addListener(c, "dragstart", function(a) {
    c.setPosition(a.latLng)
  }), google.maps.event.addListener(c, "dragend", function(a) {
    c.setPosition(a.latLng);
    showInfoWindow(a.latLng, b);
    setPositionRaoVatPost(a.latLng);
    $("#message_updated").fadeIn("slow").delay(2E3).fadeOut("slow")
  }))
}
function setPositionRaoVatPost(a) {
  $("#location_lat").val(a.lat());
  $("#location_lng").val(a.lng())
}
function showInfoWindow(a, b) {
  var d;
  d = "<strong>" + b + "</strong></br></br>" + ('V\u0129 \u0111\u1ed9: <strong style="color:red;">' + a.lat() + "</strong></br>");
  d += 'Kinh \u0111\u1ed9: <strong style="color:red;">' + a.lng() + "</strong></br>";
  infowindow.setContent(d)
}
function setCookie(a, b, d) {
  var c = new Date;
  c.setDate(c.getDate() + d);
  b = escape(b) + (null == d ? "" : "; expires=" + c.toUTCString());
  document.cookie = a + "=" + b
}
function getCookie(a) {
  var b = null;
  document.cookie && (a = document.cookie.split(escape(a) + "="), 2 <= a.length && (b = a[1].split(";"), b = unescape(b[0])));
  return b
}
function delCookie(a) {
  document.cookie = a + "=; expires=Thu, 01-Jan-70 00:00:01 GMT;"
}
;
