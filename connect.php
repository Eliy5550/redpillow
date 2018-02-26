<?php

$s = "localhost";
$u = "eliy5550";
$p = "Ee9518552";
$db = "redpillow";

$c = new mysqli($s , $u , $p , $db);

if($c->connect_error){
	echo "Can't connect to the Database!";
}

?>
