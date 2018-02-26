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

?>
<head>
<title>Red-Pillow</title>
<link href='index.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

<div id='top'>
<h1>Red-Pillow | <?php echo $_GET['u']?></h1>
<small>You are connected as <span><a style='color:white;text-decoration:underline;' href='user.php?u=<?php echo $user?>'><span id='username'><?php echo $user?></span></a></span></small>
<a style='float:right' href='feed.php?log_out="yes"'><button id='logout_button'>Log Out</button></a>
</div>

<div style='text-align: center;height:100px;' id='userpage'><br>
<h2>See all your posts and delete some here.</h2>

</div>

<div id='errors'>
<?php
//If there is a file to upload then upload it ^_^
//Add the details to the posts table
	include('connect.php');
	if(isset($_FILES["file"]["name"])){
		//Get the last number of posts
		$sql = "select max(id) as post_num from posts";
		$res = $c->query($sql);
		$post_number = 0; //Use for name of file;
		while($row = $res->fetch_assoc()){
			$post_number = $row['post_num']+1;
		}
		//Update Database and upload file
		$dir = "posts/";	
		$_FILES['file']['name'] = "p". $post_number ;
		$file_name = basename($_FILES['file']['name']) . ".png";
		$target = $dir . $file_name;
		$title = htmlspecialchars($_POST['title']);
		
		$cat = $_POST['cat'];
		
		$stmt =$c->prepare( "insert into posts 
		(pic , title , uploader_id , cat)
		value ( ? , ? , ? , ?)");
		$stmt->bind_param("ssis", $file_name, $title, $user_id , $cat);
		
		if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
			echo "<div height='0px' id='uploaded'>The post is uploaded successfully!</div>";
			if($stmt->execute()){
				//Create table for comments
				$name_of_new_table = "comments".$post_number;
				$create_table_Sql = "
				create table $name_of_new_table(
				id int primary key auto_increment,
				comm varchar(255) not null,
				tp timestamp default current_timestamp not null,
				post_id int not null,
				poster varchar(255) not null
				)
				";
				$c->query($create_table_Sql);
				
				//Create table for likes
				$likes_table_name = "likes".$post_number;
				echo $create_likes = "
				create table ".$likes_table_name."( 
				id int auto_increment primary key,
				user_id int,
				user_name varchar(255) unique)";
				
				$c->query($create_likes);
				
			}else{
				//Delete file if exists
				echo "SQL problem!";
			}
		}else{
			echo "<div id='errors'>Nothing was uploaded !</div>";
		}
	}
	
?>
</div>
<br>
</div>

<div class='inline' id='cats'>
<h2>Categories</h2>
<hr>
<a href='pop.php'><div class='catdiv'>Best Recent</div></a>
<a href='feed.php'><div class='catdiv'>New</div></a><hr>
<a href='cats.php?cat=Funny'><div class='catdiv'>Funny</div></a>
<a href='cats.php?cat=Sad'><div class='catdiv'>Sad</div></a>
<a href='cats.php?cat=Awesome'><div class='catdiv'>Awesome</div></a>
<a href='cats.php?cat=Art'><div class='catdiv'>Art</div></a>
</div>	

<div id='posts' class='inline'>
<?php
	//Render all posts from one dude
	//Get his id
	$show_user = $_GET['u'];
	$get_id_sql = "select * from users where user_name='".$show_user."'";
	$id_res = $c->query($get_id_sql);
	$show_id = 0;
	while($row = $id_res->fetch_assoc()){
		$show_id = $row['id'];
	}
	if($id_res->num_rows == 0 || $show_id == 0){
		echo "User does not exist.<a href='feed.php'>Go Back..</a>";
	}else{
	$sql = "select * from posts where uploader_id=".$show_id;
	$res = $c->query($sql);
	while($row = $res->fetch_assoc()){
		$post_id = $row['id'];
		$post_pic = "posts/" . $row['pic'];
		$post_title = $row['title'];
		$post_uploader = $row['uploader_id'];
		$post_ts = $row['ts'];
		$post_path = "post.php?p=".$post_id;
		$liked_it = $row['likes'];
		
		$user_name_res = $c->query("select user_name as name from users where id=$post_uploader");
		while($row = $user_name_res->fetch_assoc()){
			$uploader_name = $row['name'];
		}
		
		echo "<div id='post".$post_id."' class='post'>";
		echo "<small><i>Posted by: ". $uploader_name . "</i></small><br>"; 
		
		echo "<p>".$post_title . "</p><br>";
		echo "<img width='100%' src='$post_pic'><br>";
		//Delete Button
		echo "<img width='40px' src='del.png' onclick='delPost(".$post_id.")'>";
		?>
		<script>
		//Create method delPost that alerts the post to delete
		function delPost(p){
			$.post('delete_post.php' , {"p" : p} , function(data){
				document.getElementById("post"+p).innerHTML = data;
			});
		}
		</script>
		<?php	
		
		//Likes
		echo "<img height='40px' src='like.png' onclick='like(".$post_id.")'><br>";
		echo "<span id='liked".$post_id."'></span><br>";
		echo "<span id='likes".$post_id."'>";
		
		//Render Likes
		
		echo "<span id='likes".$post_id."'>";
		echo "Likes : " . $liked_it;
		echo "<br></span>";
		
		//Comments
		echo "<a href='post.php?p=".$post_id."'><u>See all comments..</u></a><br>";
		$get_comments_sql = "select * from comments".$post_id. " limit 2";
		$get_comments_sql_res = $c->query($get_comments_sql);
		while($row = $get_comments_sql_res->fetch_assoc()){
			$poster = $row['poster'];
			$comm = $row['comm'];
			$tp = $row['tp'];
			echo "<b>$poster</b><small> -- $tp</small><br><span>$comm</span><br>";
		}
		echo "<small><i>Posted at: ". $post_ts . "</i></small><br></div>";

	}
	}
	
	
?>
</div>

<script>

var open = false;

var toggleUploadSection = function(){
	
	var div = $('#upload');
	if(open){
		open = false;
		div.animate({bottom:'-70px'});
	}else{
		div.animate({bottom:'0'});
		open = true;
	}
}

function like(p){
	var user = document.getElementById("username").innerHTML;
	$.post('likes.php' , {"p" : p , "username" : user} , function(data){
		document.getElementById("liked" + p).innerHTML = "You Liked It!";
		$.post('getlikes.php' , {'p':p} , function(data){
		document.getElementById("likes" + p).innerHTML = data;
		});
	});
	
}

</script>

</body>

</html>








