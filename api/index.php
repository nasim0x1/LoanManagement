<?php
header('Content-type: application/json; charset=utf-8');
include("../includes/config.php");

$capital = "SELECT * FROM information";
$sth = $conn->query($capital);
$total_capital=mysqli_fetch_array($sth);


$capital = "SELECT COUNT(*) as total_client FROM client";
$sth = $conn->query($capital);
$client=mysqli_fetch_array($sth);

$data = array(array($total_capital),array($client));


 echo json_encode($data);
 
?>
