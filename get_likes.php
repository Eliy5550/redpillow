<?php
include('connect.php');

$likes_amount = 0;
$id = $_POST['id'];

$sql = "select * from memes where id = $id";
$res = $connect->query($sql);
while($row = $res->fetch_assoc()){
	$likes_amount = $row['likes'];
}

echo "$likes_amount people liked this.";

?>