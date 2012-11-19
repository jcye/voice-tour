<?php
/* Basic database operation with image table
*/

/*Get images by id
  Return certain place*/
function get_images($conn, $place_id){
	$sql = sprintf("SELECT pic_url FROM images WHERE place_id = %d", mysql_real_escape_string($place_id));
	$result = mysql_query($sql,$conn);
	$array = convert_array($result);
	return $array;
}

?>

