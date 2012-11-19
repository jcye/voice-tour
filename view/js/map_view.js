var isOnePlace;


$("#page-map").live('pagebeforeshow', function(){

    if(isOnePlace==1){
        navigator.geolocation.getCurrentPosition(handle_geolocation_route_mapview, handle_errors); 

    }else{
        navigator.geolocation.getCurrentPosition(handle_geolocation_query_mapview, handle_errors);      
    }
 
})


var pre_renderer;
var pre_marker;
var renderer;
// get route from previous marker to marker_palce
function getRoute(){
        // Directions
        renderer = new google.maps.DirectionsRenderer({
            'draggable': true
        });
        renderer.setMap(map);
        
    

        // Uncomment the following to add a directions pane
        service = new google.maps.DirectionsService();
                  
        service.route({
            'origin': srcMarker.getPosition(),
            'destination': dstMarker.getPosition(),
            'travelMode': google.maps.DirectionsTravelMode.BICYCLING
        }, function (result, status) {
            
            //console.log("The route between the two points is");
            //debug = result;
            //console.log(debug);

            
            if (status == 'OK') renderer.setDirections(result);
                srcMarker.setMap(null);
                  

                if (pre_renderer) {
                    pre_renderer.setMap(null);

                    if(isOnePlace!=1){
                        pre_marker.setMap(map);
                    }

                }
                pre_marker = dstMarker;
                pre_renderer = renderer;
                dstMarker.setMap(null);


                isOnePlace = 0;

        })
        if(preInfoWindow)
            preInfoWindow.close();



}

function mapInit(){
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
        srcMarker = marker;
 
}


function handle_geolocation_route_mapview(position){  

    $.getJSON('../control/get_nearby_places.php?lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data) {
        mapInit();

        srcMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(currLat,currLon),
                        map: map
                    });      
        dstMarker = new MarkerWithLabel({
                        position: new google.maps.LatLng(document.getElementById('location_lat').innerHTML,document.getElementById('location_lon').innerHTML),
                        map: map
                    });

        getRoute();
        for (var i = 1; i < markersArray.length; i++ ) {
            markersArray[i].setMap(null);
        }   

        map.setCenter(srcMarker.getPosition(), 14);


    });
}


function handle_geolocation_query_mapview(position){  


    $.getJSON('../control/get_nearby_places.php?lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data) {
    mapInit();
        curLon = position.coords.longitude;
        curLat = position.coords.latitude;

        $.each(data, function(index, place) {

            var marker_place = new MarkerWithLabel({
                    position: new google.maps.LatLng(place.lat,place.lon),
                    map: map,
                    url: 'location_detail.php?place_id='+place.place_id,
                });  

            var place_pic = "<img height='50' width='50' src='"+place.pic_url+"'>";
            var place_name = "<h6>"+place.name+"</h6>";
            var place_url = "<a href='"+marker_place.url+"'>Introduction</a>&nbsp;&nbsp;";
            var place_route = "<button onclick='getRoute()'>Get Routes</button>";

            var content = place_pic + place_name + place_url + place_route;
            var infowindow = new google.maps.InfoWindow({
                    content: content
                });
     

            google.maps.event.addListener(marker_place, 'click', function() {

                if(preInfoWindow)
                    preInfoWindow.close();
                infowindow.open(map, marker_place);
                preInfoWindow = infowindow;


                dstMarker = marker_place;
                //$.mobile.changePage(marker_place.url);
        
            });// end of mouse click

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
var srcMarker;
var dstMarker;
var showPicture = 1;


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
