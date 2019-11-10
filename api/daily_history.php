<?php

header('Content-type: application/json; charset=utf-8');

include("../includes/config.php");
  $result = $conn->query("SELECT * FROM daily_history");
  $dbdata = array();
  while ( $row = $result->fetch_assoc())  {
	$dbdata[]=$row;
  }
 echo json_encode($dbdata);
 
?>
