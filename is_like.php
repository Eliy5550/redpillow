<?php

$name = $_POST['name'];
$id = $_POST['id'];

include('connect.php');

$sql = "select * from likes$id where user_name = '$name'";

$res = $connect->query($sql);

if($res->num_rows > 0){
	echo "like.png";
}else{
	echo "dislike.png";

}

?>