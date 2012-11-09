<?php
/**
 * Returns the list of all places
 */
 
  require_once(dirname(__FILE__)."/../model/dbconnect.php");
  require_once(dirname(__FILE__)."/../model/places.php");
  
  $conn = connect();  
  $result = get_all_places($conn);
  // echo json_encode($result); Test use
  //TODO: Sort place list based on distance
   
?>