<?php
  /**
  * Returns the nearest place
  */
  require_once(dirname(__FILE__)."/../model/dbconnect.php");
  require_once(dirname(__FILE__)."/../model/places.php");
  $conn = connect();  
  $lon = $_GET['lon'];
  $lat = $_GET['lat'];
  $thresh = 10000;
  //$sql = "select * from places where (69.1*(".$lat." - lat)*69.1*(".$lat." - lat)+53.0*(".$lon." - lon)*53.0*(".$lon." - lon)) < ".$thresh;
  $sql = "select * from places order by (69.1*(".$lat." - lat)*69.1*(".$lat." - lat)+53.0*(".$lon." - lon)*53.0*(".$lon." - lon))";
  $result = mysql_query($sql,$conn);
  $array = convert_array($result);
  $place = $array[0];
  echo json_encode($place);
?>