<!DOCTYPE html> 
<html>

<head>
	<title>TourVoice</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/photoswipe.css" />

	<script src="js/jquery-1.8.2.min.js"></script>
	<script src="js/jquery.mobile-1.2.0.js"></script>
	<script src="js/jqm.page.params.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBc_p4LziIoNet8zn0aonuI5_Tyek8VqTw&sensor=true"></script>
	<script type="text/javascript" src="js/map_view.js"></script>
	<script type="text/javascript">
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

	</script>

</head> 

<body>

<!-- Start of first page: #one -->
<div data-role="page" id="page-home">

	<div data-role="header">
		<h1>TourVoice</h1>
	</div><!-- /header -->
	<div data-role="content">
		<img id="home-pic" style="width:100%; height:100px"></img>
		<h4>Welcome! <span id="home-username"></span></h4>
		<h4 id="home-title"></h4>
		<p><a id="home-location-link" data-role="button" data-theme="e">Start Listening</a></p>	
		<p><a href="#page-list" data-role="button" data-rel="dialog" data-transition="pop">Find a Tourist Spot</a></p>
	</div><!-- /content -->
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" data-grid="c">
			<ul>
				<li><a href="#page-home" id="key" data-icon="custom">Home</a></li>
				<li><a href="#page-list" id="beer" data-icon="custom">List</a></li>
				<li><a href="#page-map" id="coffee" data-icon="custom">Map</a></li>
				<li><a href="#page-setting" id="skull" data-icon="custom">Setting</a></li>
			</ul>
		</div>
	</div>
</div>
</div><!-- /page one -->




<div data-role="page" id="page-list">

	<div data-role="header">
		<a href="index.html" data-icon="back">Back</a>
		<h1>Nearby</h1>
	</div><!-- /header -->
	<div data-role="content">	
		<div class="content-primary">	
		<ul id="place-list" data-role="listview">
		</ul>
		</div><!--/content-primary -->	
	</div><!-- /content -->
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" data-grid="c">
			<ul>
				<li><a href="#page-home" id="key" data-icon="custom">Home</a></li>
				<li><a href="#page-list" id="beer" data-icon="custom">List</a></li>
				<li><a href="#page-map" id="coffee" data-icon="custom">Map</a></li>
				<li><a href="#page-setting" id="skull" data-icon="custom">Setting</a></li>
			</ul>
		</div>
	</div>
</div>
</div><!-- /page two -->





<div data-role="page" id="page-map">
	<div data-role="header">
		<a href="index.html" data-icon="back">Back</a>
		<h1>Nearby</h1>
	</div><!-- /header -->

	<div id="map_canvas" style="width:350px; height:400px; top:10px; left:10px"></div>

	
	</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" data-grid="c">
			<ul>
				<li><a href="#page-home" id="key" data-icon="custom">Home</a></li>
				<li><a href="#page-list" id="beer" data-icon="custom">List</a></li>
				<li><a href="#page-map" id="coffee" data-icon="custom">Map</a></li>
				<li><a href="#page-setting" id="skull" data-icon="custom">Setting</a></li>
			</ul>
		</div>
	</div>
	</div>
</div><!-- /page three -->




<div data-role="page" id="page-setting">
	<div data-role="header">
		<a href="index.html" data-icon="back">Back</a>
		<h1>Forms</h1>

	</div><!-- /header -->

	<div data-role="content">	
		<p></p>
		<ul data-role="listview" data-inset="true" data-filter="true">
			<li><a href="#">Barack Obama</a></li>
			<li><a href="#">Mitt Romney</a></li>
			<li><a href="#">Peta Lindsay</a></li>
			<li><a href="#">Rocky Anderson</a></li>
			<li><a href="#">Virgil Goode</a></li>
			<li><a href="#">Jill Stein</a></li>
			<li><a href="#">Gary Johnson</a></li>
		</ul>
		
		<ul data-role="listview" data-inset="true">
			<li class="taphold">Tap and hold me</li>
			<li class="tap">Tap me</li>			
			<li class="swiperight">Swipe me right</li>
			<li class="swipeleft">Swipe me left</li>
		</ul>
		
		<a href="#" data-role="button" data-icon="star">Star button</a>

		<div data-role="collapsible">
		   <h3>I'm a header</h3>
		   <p>I'm the collapsible content. By default I'm closed, but you can click the header to open me.</p>
		</div>
	
	<form action="submit.php" method="post">
		<div data-role="fieldcontain">
	     <label for="foo">Text Input:</label>
	     <input type="text" name="name" id="foo" value=""  />
		</div>
	
		<div data-role="fieldcontain">
		<fieldset data-role="controlgroup">
	    	<legend>Gender:</legend>
	         	<input type="radio" name="gender" id="radio-female" value="f" />
	         	<label for="radio-female">Female</label>
	
	         	<input type="radio" name="gender" id="radio-male" value="m" />
	         	<label for="radio-male">Male</label>
	    </fieldset>
	    </div>
	
		<div data-role="fieldcontain">
		<label for="flip-s">Server status:</label>
		<select name="flip-s" id="flip-s" data-role="slider">
			<option value="off">Off</option>
			<option value="on">On</option>
		</select>
	    </div>
	
	    <div data-role="fieldcontain">
		<label for="slider">Max bandwidth:</label>
		<input type="range" name="slider" id="slider" value="0" min="0" max="100" />
	    </div>
	
		<div data-role="fieldcontain">
			<label for="select-choice-x" class="select">Shipping:</label>
			<select name="select-shipper" id="select-choice-x" >
				<option></option>
				<option value="standard">Standard</option>
				<option value="rush">Rush</option>
				<option value="express">Express</option>
				<option value="overnight">Overnight</option>
			</select>
		</div>
		<div class="ui-block-b"><button type="submit" data-theme="a">Submit</button></div>

	</form>
	</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
		<ul>
				<li><a href="#page-home" id="key" data-icon="custom">Home</a></li>
				<li><a href="#page-list" id="beer" data-icon="custom">List</a></li>
				<li><a href="#page-map" id="coffee" data-icon="custom">Map</a></li>
				<li><a href="#page-setting" id="skull" data-icon="custom">Setting</a></li>
		</ul>
		</div>
	</div>
	
	<script type="text/javascript">
		$('#filter').live( 'pageinit',function(event){
			$(".taphold").on('taphold', function(event){
				alert("You tapped and held");
			});
			
			$(".tap").on('tap', function(event){
				alert("You tapped!");
			});
			
			$(".swiperight").on('swiperight', function(event){
				event.stopImmediatePropagation();
				alert("You swiped right!");
			});
			
			$(".swipeleft").on('swipeleft', function(event){
				event.stopImmediatePropagation() 
				alert("You swiped left!");
			});
		});
	</script>	

</div>

