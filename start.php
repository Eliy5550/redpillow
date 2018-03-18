<!DOCTYPE html>
<?php
session_start();
include('connect.php');

$user_name = "";
if(isset($_SESSION['user_name'])){
	$user_name = $_SESSION['user_name'];
}

?>
<html>
<head>
<title>Red-Pillow</title>
<link href='style.css' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function getHeart(id){
			//Updating the hearts on the page when liking / at the beginning.
			// * Called when rendering memes
			$.post("is_like.php" , 
			{
			"name" : "<?php echo $user_name;?>",
			"id" : id
			} , 
			function(data){
				document.getElementById('heart'+id)
				.src = data;
			});
			}
		function like(n){ //Adding a like and updating page w/ AJAX.
		// * Called when Liking memes
		var liker = "<?php echo $user_name?>";
			$.post(
			"like_meme.php"	,
			{"id" : n , "liker" : liker},
			function(data){ //Say what you did
				document.getElementById('a'+n).innerHTML = data;
				$.post("get_likes.php",
				{"id" : n},
				function(data){ //Tell how many likes the meme has
				document.getElementById('likes'+n).innerHTML = data;
				getHeart(n);
			});
			});
			
		}
		function delMeme(m){
			$.post("del_meme.php",
				{"id" : m},
				function(data){ //Delete post and say it.
				document.getElementById('meme'+m).innerHTML = data;
			});
		}
		function comment(id){
			$.post("comment_action.php" , {
				"id" : id , 
				"user_name" : "<?php echo $user_name;?>",
				"c_text" : document.getElementById("commentInput"+id).value
			} , function(data){
				document.getElementById("commentAlert"+id).innerHTML = data;
				$.post("get_comments.php" , {
					"id" : id
				} , 
				function(data){
				document.getElementById("comments_section"+id).innerHTML = data;
				});
			});
		}
	</script>
</head>
<body>

<div id='top'>
<h1>Red-Pillow</h1>
<?php
if($user_name == ""){
	echo "<a style='float:right;color:white' href='login.php' id='login'>Log in</a>";
}else{
	echo "<a href='user.php?u=$user_name' style='float:right;color:white'>My Profile : $user_name</a><br><a style='float:right;color:white' href='logout.php'>Log out</a>";
}

?>
</div>

<div id='navbar'>
	<a class='nav' href='index.php'>Home</a>
	<a class='nav' href='memes.php'>Memes</a>
	<a class='nav' href='upload.php'>Upload</a>
</div>







