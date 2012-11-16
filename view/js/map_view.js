

$("#page-map").live('pagebeforeshow', function(){
	navigator.geolocation.getCurrentPosition(handle_geolocation_query_mapview, handle_errors);  
})

function handle_geolocation_query_mapview(position){  
    $.getJSON('../control/get_nearby_places.php?lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data) {
    	curLon = position.coords.longitude;
   		curLat = position.coords.latitude;

    	$.each(data, function(index, place) {

            var marker_place = new MarkerWithLabel({
                    position: new google.maps.LatLng(place.lat,place.lon),
                    map: map,
                    url: 'location_detail.php?place_id='+place.place_id,
                    //labelContent: place.name,
                    //labelAnchor: new google.maps.Point(22, 0),
                    //labelClass: "labels", // the CSS class for the label
                    //labelStyle: {opacity: 0.75}
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



if (navigator.geolocation)
{
    navigator.geolocation.getCurrentPosition(showPosition);
}
else{
    var currLat = 37.425 ;
    var currLon = -122.1673;
}

 
var map; 
var infoWindow;
var preInfoWindow;
var preMarker;
var showPicture = 1;


	function showPosition(position) {
			currLat = position.coords.latitude;
			currLon = position.coords.longitude;
	} 

    function initialize() {

	    //if (navigator.geolocation) {
	    //   navigator.geolocation.getCurrentPosition(showPosition);
	    //} 
        var mapOptions = {
          center: new google.maps.LatLng(currLat,currLon),
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);

    

        infowindow = new google.maps.InfoWindow();


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


        var boxText = document.createElement("div");
        boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: yellow; padding: 5px;";
        boxText.innerHTML = "City Hall, Sechelt<br>British Columbia<br>Canada";

        var myOptions = {
             content: boxText
            ,disableAutoPan: false
            ,maxWidth: 0
            ,pixelOffset: new google.maps.Size(-140, 0)
            ,zIndex: null
            ,boxStyle: { 
              background: "url('tipbox.gif') no-repeat"
              ,opacity: 0.9
              ,width: "50px"
             }
            ,closeBoxMargin: "10px 2px 2px 2px"
            ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
            ,infoBoxClearance: new google.maps.Size(1, 1)
            ,isHidden: false
            ,pane: "floatPane"
            ,enableEventPropagation: false
        };




  } 

var timer = 100;

window.onload = function changeQuantity(){
	initialize();

	if (window.DeviceMotionEvent==undefined) {
		showPicture = 0;

    } else {
    	window.ondevicemotion = function(event) {
		
    		ax = event.accelerationIncludingGravity.x;
    		ay = event.accelerationIncludingGravity.y;

	        var gravity = Math.abs(event.accelerationIncludingGravity.x)+Math.abs(event.accelerationIncludingGravity.y)+Math.abs(event.accelerationIncludingGravity.z);
	        timer = timer+1;
	        if(gravity>30 && timer >100)
	        {
	          timer = 0;
	          for (var i = 1; i < markersArray.length; i++ ) {
	              markersArray[i].setMap(null);
	          }

	        }
    	}
    }

}