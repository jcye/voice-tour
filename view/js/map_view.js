$("#page-map").live('pagebeforeshow', function(){
    // navigator.geolocation.getCurrentPosition(initialize);
	navigator.geolocation.getCurrentPosition(handle_geolocation_query_mapview, handle_errors);  
})

function handle_geolocation_query_mapview(position){ 
    $.getJSON('../control/get_nearby_places.php?lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data) {
        var mapOptions = {
          center: new google.maps.LatLng(currLat,currLon),
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);

        // My current location
        var image = 'http://www.google.com/gmm/images/blue_dot_circle.png';
        image.height = 20;
        image.width = 20;
        var marker = new google.maps.Marker({
                position: new google.maps.LatLng(currLat,currLon),
                map: map,
                icon: image
            });  
        marker.setMap(map);
        marker.setZIndex(998); 
        markersArray.push(marker);
    	$.each(data, function(index, place) {
            var marker_place = new MarkerWithLabel({
                    position: new google.maps.LatLng(place.lat,place.lon),
                    map: map,
                    url: 'location_detail.php?place_id='+place.place_id,
                });  
            var infowindow = new google.maps.InfoWindow({
                    content: "<a href='"+marker_place.url+"'>"+place.name+"</a>"
                });
            google.maps.event.addListener(marker_place, 'click', function() {
                if(preInfoWindow)
                    preInfoWindow.close();
                infowindow.open(map, marker_place);
                preInfoWindow = infowindow;
                preMarker = marker_place;

                //$.mobile.changePage(marker_place.url);
            });
            marker_place.setMap(map);
            markersArray.push(marker_place);
    	})
    });
}

// Set up Map
var markersArray = [];
var map; 
var infoWindow;
var preInfoWindow;
var preMarker;
if (navigator.geolocation)
{
    navigator.geolocation.getCurrentPosition(showPosition);
}
else{
    var currLat = 37.425 ;
    var currLon = -122.1673;
}

function showPosition(position) {
		currLat = position.coords.latitude;
		currLon = position.coords.longitude;
} 

// function initialize() {

//     //if (navigator.geolocation) {
//     //   navigator.geolocation.getCurrentPosition(showPosition);
//     //} 
//     var mapOptions = {
//       center: new google.maps.LatLng(currLat,currLon),
//       zoom: 14,
//       mapTypeId: google.maps.MapTypeId.ROADMAP
//     };
//     map = new google.maps.Map(document.getElementById("map_canvas"),
//         mapOptions);

//     // My current location
//     var image = 'http://www.google.com/gmm/images/blue_dot_circle.png';
//     image.height = 20;
//     image.width = 20;
//     var marker = new google.maps.Marker({
//             position: new google.maps.LatLng(currLat,currLon),
//             map: map,
//             icon: image
//         });  
//     marker.setMap(map);
//     marker.setZIndex(998); 
//     markersArray.push(marker);

// } 
