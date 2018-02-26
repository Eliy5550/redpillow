<?php

//Get likes
$pos = $_POST['p'];
include('connect.php');

$sql = "select * from likes".$pos;

$res = $c->query($sql);

echo $res->num_rows . " people liked this post.<br>";

$c->close();

?>