<?php
/**
 * Returns images for one place
 */
 
  require_once(dirname(__FILE__)."/../model/dbconnect.php");
  require_once(dirname(__FILE__)."/../model/images.php");
  
  $conn = connect();  
  $place_id = $_GET['place_id'];
  $result = get_images($conn, $place_id); 
  echo json_encode($result);

?>