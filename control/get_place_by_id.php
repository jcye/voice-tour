<?php
/**
 * Returns one place
 */
 
  require_once(dirname(__FILE__)."/../model/dbconnect.php");
  require_once(dirname(__FILE__)."/../model/places.php");
  
  $conn = connect();  
  $place_id = $_GET['place_id'];
  $result = get_place_by_id($conn, $place_id);
  // echo json_encode($result); Test use
?>