<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="css/photoswipe.css" />
  <link rel="stylesheet" href="css/style.css" />
  <script type="text/javascript" src="js/klass.min.js"></script>
  <script type="text/javascript" src="js/code.photoswipe-3.0.5.min.js"></script>
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
  <a href="#page-home" data-icon="arrow-l">Back</a>
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
          <img style="width:100%; height:100px" src = <?php echo $place['pic_url']; ?>></img>
          <audio id= "centered" controls="controls">
            <source src="audios/<?php echo $place['audio_url']; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
          <h3 id="location_name"><?php echo $place['name']; ?></h3>
          <p id="location_intro"><?php echo $place['intro']; ?></p>
      <?php
        }
      ?>
    </div><!-- /content -->
    
    <div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
      <div data-role="navbar" data-grid="c">
        <ul>
          <li><a href="index.php#page-home"  data-icon="home">Home</a></li>
          <li><a href="index.php#page-list"  data-icon="grid">List</a></li>
          <li><a href="index.php#page-map" id="footer-map" data-icon="custom">Map</a></li>
          <li><a href="index.php#page-setting" data-icon="gear">Setting</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

</body>

</html>

