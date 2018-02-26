<!DOCTYPE html>
<html>
<?php

session_start();

if(!isset($_SESSION['user_name'])){
	header('Location: http://localhost/red-pillow/');
}


$user = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];

if(isset($_GET['log_out'])){
	session_destroy();
	header('Location: http://localhost/red-pillow/index.php');
}



$post_id = "";
if(isset($_POST['comment'])){
	include('connect.php');
	$post_table = "comments".$_GET['p'];
	$stmt = $c->prepare("insert into $post_table (comm , post_id , poster) 
	value(?,?,?)");
	$comm = $_POST['comment'];
	$post_id = $_GET['p'];
	$poster = $user;
	$stmt->bind_param('sis' , $comm , $post_id , $poster);
	if($stmt->execute()){
		echo "OK!";
	}
	
	header('Location: http://localhost/red-pillow/post.php?p='.$post_id);
}



?>
<head>
<title>Red-Pillow</title>
<link href='index.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

<div id='top'>
<h1>Red-Pillow | Show Post</h1>
<small>You are connected as <span><a style='color:white;text-decoration:underline;' href='user.php?u=<?php echo $user?>'><span id='username'><?php echo $user?></span></a></span></small>
<a style='float:right' href='feed.php?log_out="yes"'><button id='top_button'>Log Out</button></a>
</div>


<div class='inline' id='cats'>
<h2>Categories</h2>
<hr>
<a href='feed.php'><div class='catdiv'>Home</div></a><hr>
<a href='cats.php?cat=Funny'><div class='catdiv'>Funny</div></a>
<a href='cats.php?cat=Sad'><div class='catdiv'>Sad</div></a>
<a href='cats.php?cat=Awesome'><div class='catdiv'>Awesome</div></a>
<a href='cats.php?cat=Art'><div class='catdiv'>Art</div></a>
</div>	

<div id='posts' class='inline'>

<?php
	//Render 1 post
	include('connect.php');
	$post_to_show = $_GET['p'];
	$sql = "select * from posts where id = $post_to_show";
	$res = $c->query($sql);
	$post_ts= "";
	while($row = $res->fetch_assoc()){
		$post_id = $row['id'];
		$post_pic = "posts/" . $row['pic'];
		$post_title = $row['title'];
		$post_uploader = $row['uploader_id'];
		$post_ts = $row['ts'];

		$user_name_res = $c->query("select user_name as name from users where id=$post_uploader");
		while($row = $user_name_res->fetch_assoc()){
			$uploader_name = $row['name'];
		}
		
		echo "<div class='post'>";
		echo "<small><i>Posted by: ". $uploader_name . "</i></small><br>"; 

		echo "<p>".$post_title . "</p><br>";
		echo "<img width='300px' src='$post_pic'><br>";
		
		echo "<br><b><u>Comments:</u></b><br><br>";
		?>
		<form method='post' action='post.php?p=<?php echo $_GET['p']?>'>
		<input name='comment' style='padding:5px;' placeholder='Comment Here'> <input type='submit'>
		</form><br>
		<?php
		
		//Get Likes
		echo "<span id='likes".$post_id."'>";
		$get_likes_sql = "select * from likes".$post_id;
		$likes_res = $c->query($get_likes_sql);
		echo $likes_res->num_rows . " people liked this post!<br>";
		echo "</span>";
		
		//Get Comments!
		$get_comments_sql = "select * from comments".$post_id;
		$get_comments_sql_res = $c->query($get_comments_sql);
		while($row = $get_comments_sql_res->fetch_assoc()){
			$poster = $row['poster'];
			$comm = $row['comm'];
			$tp = $row['tp'];
			echo "<b>$poster</b><small> -- $tp</small><br><span>$comm</span><br>";
		}
		
	}
	
?>


<?php echo "<small style='float:right;'><i>Posted at: ". $post_ts . "</i></small><br>";?>

</div>
</div>

</body>

</html>




