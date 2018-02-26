<?php

$p_id = $_POST['p'];
include('connect.php');

$c->query("DELETE FROM posts WHERE id=".$p_id);
$c->query("DROP TABLE comments".$p_id);
$c->query("DROP TABLE likes".$p_id);

echo "<br>Post was deleted!<br>";

$c->close();
?>