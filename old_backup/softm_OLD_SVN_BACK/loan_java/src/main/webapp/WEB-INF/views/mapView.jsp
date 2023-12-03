<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
    <div id="map"></div>
    <script>
	var COMPAY_NAME = "서해박속낙지전문점";
    function initMap() {
        var myLatLng = {lat: -25.363, lng: 131.044};
        var myLatLng = {lat: 37.4813201, lng: 126.8475809};
        var myLatLng = {lat: 35.8597722, lng: 128.6273069};
            	
      var address = COMPAY_NAME;
  	  var geocoder = new google.maps.Geocoder();    	  
	  geocoder.geocode({'address': address}, function(results, status) {
	    if (status === google.maps.GeocoderStatus.OK) {
	        var map = new google.maps.Map(document.getElementById('map'), {
	            center: results[0].geometry.location,
	            scrollwheel: false,
	            zoom: 17
		       ,title: COMPAY_NAME	            
	        });	    	
	    	map.setCenter(results[0].geometry.location);
	        var coordInfoWindow = new google.maps.InfoWindow();
	        coordInfoWindow.setContent(createInfoWindowContent(results[0].geometry.location, map.getZoom(),COMPAY_NAME));
	        coordInfoWindow.setPosition(results[0].geometry.location);
	        coordInfoWindow.open(map);

	        map.addListener('zoom_changed', function() {
	          coordInfoWindow.setContent(createInfoWindowContent(results[0].geometry.location, map.getZoom(),COMPAY_NAME));
	          coordInfoWindow.open(map);
	        });	      
	    } else {
	      alert('Geocode was not successful for the following reason: ' + status);
	    }
	  });
	  

      }
    
    function createInfoWindowContent(latLng, zoom, companyNm) {
  	  var scale = 1 << zoom;

  	  var worldCoordinate = project(latLng);

  	  var pixelCoordinate = new google.maps.Point(
  	      Math.floor(worldCoordinate.x * scale),
  	      Math.floor(worldCoordinate.y * scale));

  	  var tileCoordinate = new google.maps.Point(
  	      Math.floor(worldCoordinate.x * scale / TILE_SIZE),
  	      Math.floor(worldCoordinate.y * scale / TILE_SIZE));

  	  return [
  		"" + companyNm + ""
//  		,
//   	    'LatLng: ' + latLng.lat + " , " + latLng.lng ,
//   	    'Zoom level: ' + zoom,
//   	    'World Coordinate: ' + worldCoordinate,
//   	    'Pixel Coordinate: ' + pixelCoordinate,
//   	    'Tile Coordinate: ' + tileCoordinate
  	  ].join('<br>');
  	}
    var TILE_SIZE = 256;
   // The mapping between latitude, longitude and pixels is defined by the web
   // mercator projection.
   function project(latLng) {
     var siny = Math.sin(latLng.lat * Math.PI / 180);

     // Truncating to 0.9999 effectively limits latitude to 89.189. This is
     // about a third of a tile past the edge of the world tile.
     siny = Math.min(Math.max(siny, -0.9999), 0.9999);

     return new google.maps.Point(
         TILE_SIZE * (0.5 + latLng.lng / 360),
         TILE_SIZE * (0.5 - Math.log((1 + siny) / (1 - siny)) / (4 * Math.PI)));
   }
      
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXrxD3jQbtWrI7g1DZV60eJ2mth2K3irw&callback=initMap"
        async defer></script>
<%@include file="/inc/footer.jsp" %>