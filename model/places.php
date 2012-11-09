<?php
/* Basic database operation with place table
*/

/*Insert place into place table*/
function insert_place($conn, $name, $intro, $lon, $lat, $pic_url, $audio_url){
	$name = mysql_real_escape_string($name);
	$intro = mysql_real_escape_string($intro);
	$pic_url = mysql_real_escape_string($pic_url);
	$audio_url = mysql_real_escape_string($audio_url);
	$sql = "INSERT INTO places(name, intro, lon, lat, pic_url, audio_url) VALUES ('$name', '$intro', '$lon', '$lat','$pic_url', '$audio_url')";
	return execute($sql, $conn);
}

/*Get place by id
  Return certain place*/
function get_place_by_id($conn, $place_id){
	$sql = sprintf("SELECT * FROM places WHERE place_id = %d", mysql_real_escape_string($place_id));
	$result = mysql_query($sql,$conn);
	$array = convert_array($result);
	return $array;
}

/*Get all place information
  Return: array of places
*/
function get_all_places($conn){
	$sql = "SELECT * FROM places";
	$result = mysql_query($sql,$conn);
	$array = convert_array($result);
	return $array;
}

?>

