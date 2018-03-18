<?php
include('connect.php');

$id = $_POST['id'];
$liker = $_POST['liker'];
$is_liked = 0;

if($liker != ""){

//Check if you liked this post before
$sql = "select * from likes$id where user_name = '$liker'";
$res = $connect->query($sql);
if($res->num_rows > 0){
	$is_liked = 1;
}

if($is_liked == 0){//Like the post:
	//Insert  liker to the meme's likes table
	$sql = "insert into likes$id value('$liker')";
	$connect->query($sql);
	echo "You just liked it!";

}else{//Remove the like
	//Delete your name from the likes table
	$sql = "delete from likes$id where user_name = '$liker'";
	$connect->query($sql);
	echo "Removed your like.";
	
}

//Update likes on memes table
$new_likes_count = 0; //Variable for the amount of likes
$sql = "select count(user_name) as amount from likes$id";
$res = $connect->query($sql);
while($row = $res->fetch_assoc()){
	$new_likes_count = $row['amount'];
}
$sql = "update memes set likes = $new_likes_count where id = $id";
$connect->query($sql);
	
	
}else{
	echo "Log in to be able to likes posts.";
}

?>