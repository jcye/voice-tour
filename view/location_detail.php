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
  <script type="text/javascript">
    _window = window;
    _Util = window.Code.Util;
    _PhotoSwipe = window.Code.PhotoSwipe;

    function playImageShow() {
      place_id = $("#place_id").text();
      cover_url = $("#cover_image").text();
      pic_array = [];
      pic_array.push({url: cover_url, caption: 'Photo Gallery'});

      $.getJSON("../control/get_images_by_id.php?place_id="+place_id, function(data) {
        $.each(data, function(index, pic_url) {
          pic_array.push({url: "images/full/"+pic_url['pic_url'], caption: "Photo Gallery"});
        })

        var instance;
        instance = _PhotoSwipe.attach(
          pic_array,
          {
            target: _window.document.querySelectorAll('#PhotoSwipeTarget')[0],
            preventHide: true,
            getImageSource: function(obj){
              return obj.url;
            },
            getImageCaption: function(obj){
              return obj.caption;
            }
          }
        );
        instance.show(0);
      });
    }
  </script>
</head>
    
<body>

<div id="page-location" data-role="page" data-add-back-btn="true">
  <div data-role="header">
  <a id="place-back" href="index.html#page-home" data-rel="back" data-icon="arrow-l">Back</a>
  <h1>TourVoice</h1>
    </div>
    <div data-role="content"> 
    
      <div id="PhotoSwipeTarget"></div>
      <div id="Indicators">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <?php
        require_once (dirname(__FILE__)."/../control/get_place_by_id.php");    
        foreach ($result as $place){
      ?>
          <div id="place_id" style="display:none"><?php echo $place_id; ?></div>
          <div id="cover_image" style="display:none"><?php echo $place['pic_url']; ?></div>
          <audio autoplay="autoplay" id= "centered" controls="controls">
            <source src="audios/<?php echo $place['audio_url']; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
        </td>
        <td>
          <div onclick="isOnePlace = 1;"><a href="index.html#page-map" rel="external">Routes</a></div>
        </td>
      </tr></table>
          <div id="location_lat" style="display:none"><?php echo $place['lat']; ?></div>
          <div id="location_lon" style="display:none"><?php echo $place['lon']; ?></div>
          <h3 id="location_name"><?php echo $place['name']; ?></h3>
          <p id="location_intro"><?php echo $place['intro']; ?></p>
      <?php
        }
      ?>
    </div>
    
    <div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
      <div data-role="navbar" data-grid="b">
        <ul>
          <li><a id="place-footer-home" href="index.html#page-home"  data-icon="home" rel="external">Home</a></li>
          <li><a id="place-footer-list" href="index.html#page-list"  data-icon="grid" rel="external">List</a></li>
          <li><a id="place-footer-map" href="index.html#page-map" id="footer-map" data-icon="custom" rel="external">Map</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">
    playImageShow();
  </script>

</body>

</html>

