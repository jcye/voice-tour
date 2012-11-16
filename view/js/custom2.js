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
    if (navigator.geolocation) {
        dist = distance(currLat, currLon, data.lat, data.lon);
        $('#home-title').html("Welcome! You are near "+data.name+" within "+dist);
        $('#home-location-link').attr("href", "location_detail2.php?place_id="+data.place_id);
    }else{
        $('#home-title').html("Welcome! Here is the introduction of "+data.name);
        $('#home-location-link').attr("href", "location_detail2.php?place_id="+data.place_id);
    }

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
        $('#place-list li').remove();
    	$.each(data, function(index, place) {
    		//distance = Math.sqrt(69.1*(curLat - place.lat)*69.1*(curLat - place.lat)+53.0*(curLon - place.lon)*53.0*(curLon - place.lon))/1600;
            dist = distance(curLat, curLon, place.lat, place.lon);
    		$('#place-list').append('<li> <a href="location_detail2.php?place_id='+place.place_id+'">'+
							'<img style="width:100%; height:100%; padding: 1px" src="'+place.pic_url+'"/>'+
							'<h3>'+place.name+'</h3>'+
							'<p>'+dist+'</p></a></li>');
    	})
    	$('#place-list').listview('refresh');
    });
}
function distance(lat1,lon1,lat2,lon2) {
    var R = 6371; // km (change this constant to get miles)
    var dLat = (lat2-lat1) * Math.PI / 180;
    var dLon = (lon2-lon1) * Math.PI / 180;
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;
    if (d>1) return Math.round(d)+"km";
    else if (d<=1) return Math.round(d*1000)+"m";
    return d;
}
