<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 

  <link rel="stylesheet" href="css/photoswipe.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />

  <script type="text/javascript" src="js/klass.min.js"></script>
  <script type="text/javascript" src="js/code.photoswipe-3.0.5.min.js"></script>
  <script src="js/jquery-1.8.2.min.js"></script>
  <script src="js/jquery.mobile-1.2.0.js"></script>
  <script src="js/jqm.page.params.js"></script>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBc_p4LziIoNet8zn0aonuI5_Tyek8VqTw&sensor=true"></script>
  <script type="text/javascript" src="js/map_view.js"></script>
  <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js"></script>
  <script type="text/javascript">
    // Set up PhotoSwipe with all anchor tags in the Gallery container
    /* 
      Overview: 
      ---------
      
      Demonstrates inline functionality with indicators. This demo sets the images using an array.
      There is nothing stopping you basing this on image dom elements like other examples.
      
      Also in this demo I "hardcode" the indicators into the markup. Again, there is nothing stopping
      you creating them as needed in the JavaScript.
    
    */
      (function(window, Util, PhotoSwipe){
      Util.Events.domReady(function(e){
        var instance, indicators; 
        instance = PhotoSwipe.attach(
          [
            { url: 'images/full/001.jpeg', caption: 'Image 001'},
            { url: 'images/full/002.jpeg', caption: 'Image 002'},
            { url: 'images/full/003.jpeg', caption: 'Image 003'}
          ],
          {
            target: window.document.querySelectorAll('#PhotoSwipeTarget')[0],
            preventHide: true,
            getImageSource: function(obj){
              return obj.url;
            },
            getImageCaption: function(obj){
              return obj.caption;
            }
          }
        );
        
        
        indicators = window.document.querySelectorAll('#Indicators span');
        
        // onDisplayImage - set the current indicator
        instance.addEventHandler(PhotoSwipe.EventTypes.onDisplayImage, function(e){
          
          var i, len;
          for (i=0, len=indicators.length; i<len; i++){
            indicators[i].setAttribute('class', '');
          }
          indicators[e.index].setAttribute('class', 'current');
          
        });
        
        instance.show(0);
        
      });
      
      
    }(window, window.Code.Util, window.Code.PhotoSwipe));
  </script>
</head>
    
<body>

<div id="page-location" data-role="page" data-add-back-btn="true">
  <div data-role="header">
  <a href="index.html#page-home" data-rel="back" data-icon="arrow-l">Back</a>
  <h1>TourVoice</h1>
    </div><!-- /header -->
    <div data-role="content"> 
    <!--
      <div id="PhotoSwipeTarget"></div>
      <div id="Indicators">
        <span></span>
        <span></span>
        <span></span>
      </div>
    -->
      <?php
        require_once (dirname(__FILE__)."/../control/get_place_by_id.php");
        foreach ($result as $place){
      ?>
          <img style="width:100%; height:150px" src = <?php echo $place['pic_url']; ?>></img>
          <audio autoplay="autoplay" controls="controls">
            <source src="audios/<?php echo $place['audio_url']; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
          &nbsp;&nbsp;
          <div onclick="isOnePlace = 1;"><a href="index.html#page-map">Routes</a></div>
          <div id="location_lat" style="display:none"><?php echo $place['lat']; ?></div>
          <div id="location_lon" style="display:none"><?php echo $place['lon']; ?></div>
          <h3 id="location_name"><?php echo $place['name']; ?></h3>
          <p id="location_intro"><?php echo $place['intro']; ?></p>
      <?php
        }
      ?>
    </div><!-- /content -->
    
    <div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
      <div data-role="navbar" data-grid="b">
        <ul>
          <li><a href="index.html#page-home"  data-icon="home">Home</a></li>
          <li><a href="index.html#page-list"  data-icon="grid">List</a></li>
          <li><a href="index.html#page-map" id="footer-map" data-icon="custom">Map</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

</body>

</html>

