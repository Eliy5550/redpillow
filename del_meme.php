<?php
require('connect.php');

$id = $_POST['id'];

$sql = "delete from memes where id=$id";
$connect->query($sql);
$sql = "drop table likes$id";
$connect->query($sql);
$sql = "drop table comments$id";
$connect->query($sql);
unlink("memes/p$id");

echo "You have deleted this post.";

?>