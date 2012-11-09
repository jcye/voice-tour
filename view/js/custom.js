/* 
/* home page 
	*/
$("#page-home").live('pagebeforeshow', function(){
	navigator.geolocation.getCurrentPosition(handle_geolocation_query_home, handle_errors);  
})
function handle_errors(error)  
{  
    switch(error.code)  
    {  
        case error.PERMISSION_DENIED: alert("user did not share geolocation data");  
        break;  
        case error.POSITION_UNAVAILABLE: alert("could not detect current position");  
        break;  
        case error.TIMEOUT: alert("retrieving position timed out");  
        break;  
        default: alert("unknown error");  
        break;  
    }  
} 
function handle_geolocation_query_home(position){  
    $.getJSON('../control/get_current_place.php?lat='+position.coords.latitude+'&lon='+position.coords.longitude, displayPlace);
}
function displayPlace(data) {
	$('#home-pic').attr("src", data.pic_url);
	$('#home-title').text("You are currently at "+data.name);
	$('#home-location-link').attr("href", "location_detail.php?place_id="+data.place_id);
} 

/* 
/* list page 
*/
	$("#page-list").live('pagebeforeshow', function(){
	navigator.geolocation.getCurrentPosition(handle_geolocation_query_list, handle_errors);  
})
function handle_geolocation_query_list(position){  
    $.getJSON('../control/get_nearby_places.php?lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data) {
    	curLon = position.coords.longitude;
   		curLat = position.coords.latitude;
    	$.each(data, function(index, place) {
    		distance = Math.sqrt(69.1*(curLat - place.lat)*69.1*(curLat - place.lat)+53.0*(curLon - place.lon)*53.0*(curLon - place.lon))/1600;
    		$('#place-list').append('<li> <a href="location_detail.php?place_id='+place.place_id+'">'+
							'<img style="width:100%; height:100%; padding: 1px" src="'+place.pic_url+'"/>'+
							'<h3>'+place.name+'</h3>'+
							'<p>'+distance+' miles</p></a></li>');
    	})
    	$('#place-list').listview('refresh');
    });
}