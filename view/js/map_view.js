	// Set up Map
      var markersArray = [];
      var currLat = 37.484568564 ;
      var currLon = -122.148;

      var map; 
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
		          zoom: 10,
		          mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
		        map = new google.maps.Map(document.getElementById("map_canvas"),
		            mapOptions);
		        var image = 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc6/275013_100000981942170_4422755_q.jpg';
		        image.height = 20;
		        image.width = 20;
		        var marker = new google.maps.Marker({
		                position: new google.maps.LatLng(currLat,currLon),
		                map: map,
		                icon: image
		            });  
		        marker.setMap(map);
		        
		        markersArray.push(marker);

		        var marker0 = new google.maps.Marker({
		                position: new google.maps.LatLng(currLat-0.01,currLon+0.01),
		                map: map
		        });  
		        marker0.setMap(map);
		        
		        markersArray.push(marker0);

		        var marker4 = new google.maps.Marker({
		                position: new google.maps.LatLng(currLat-0.031,currLon+0.091),
		                map: map
		        });  
		        marker4.setMap(map);
		        
		        markersArray.push(marker4);

		        var marker5 = new google.maps.Marker({
		                position: new google.maps.LatLng(currLat-0.11,currLon+0.031),
		                map: map,
		                url: '#Tour'
		        });  

		        google.maps.event.addListener(marker5, 'click', function() {
			      window.location.href = marker5.url;
			    });

		        marker5.setMap(map);
		        
		        markersArray.push(marker5);


	      } 
 
        var timer = 100;

		window.onload = function changeQuantity(){
			initialize();

			if (window.DeviceMotionEvent==undefined) {
				showPicture = 0;
				document.getElementById('bessie').style.display = 'block';

		    } else {
		    	window.ondevicemotion = function(event) {
		    	document.getElementById('bill').style.display = 'block';
				
		    		ax = event.accelerationIncludingGravity.x;
		    		ay = event.accelerationIncludingGravity.y;

			        var gravity = Math.abs(event.accelerationIncludingGravity.x)+Math.abs(event.accelerationIncludingGravity.y)+Math.abs(event.accelerationIncludingGravity.z);
			        timer = timer+1;
			        if(gravity>30 && timer >100)
			        {
			          timer = 0;
			          for (var i = 0; i < markersArray.length; i++ ) {
			              markersArray[i].setMap(null);
			          }

			        }
		    	}
		    }

		}