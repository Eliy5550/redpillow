<?php 
include('start.php');
if($user_name == ""){
	?>
	<script>
	//Tell the user to log in:
	$(document).ready(function(){
		$("#signup").html("<a href='login.php'>Log in first.</a>");
	});
	</script>
	<?php
}
?>
<br><br>
<div id='signup'>
	<h2>Red-Pillow</h2>
	<h3 style='padding:10px;' id='red'>Upload a meme:</h3><br>
	<form action='upload.php' method='post' enctype='multipart/form-data'>
	<input autocomplete='off' name='title' placeholder='Title (optional)' type='text'><br><br>
	<input autocomplete='off' name='file' type='file'><br><br>
	<select name='cat'>
	<option value='Funny' selected='selected'>Funny</option>
	<option value='Awesome'>Awesome</option>
	<option value='Gaming'>Gaming</option>
	<option value='WTF'>WTF</option> 
	</select><br><br>
	<input autocomplete='off' name='tag' placeholder='Tag  (optional)' type='text'><br><br>
	<input type='submit' value='Upload'><br><br>
	</form>
	
	<?php
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	//Form data	and other variables
	$title = $_POST['title'];
	$tag = $_POST['tag'];
	$meme_number = 0;
	$uploader = "Eliy5550";
	$path = ""; // To be changed.
	$cat = $_POST['cat'];;
	
	//Get meme number
	$get_meme_num_sql = "select max(id) as max_id from memes";
	$meme_num_res = $connect->query($get_meme_num_sql);
	while($r = $meme_num_res->fetch_assoc()){
		$max_id = $r['max_id'];
		$meme_number = $r['max_id'] +1 ;
	}
	
	//Upload a file
	$ext = pathinfo($_FILES['file']['name'] , PATHINFO_EXTENSION);
	$path = "memes/p".$meme_number.".".$ext;
	if(move_uploaded_file($_FILES['file']['tmp_name']
	, $path)){
		echo "Your meme was uploaded successfully!<br>";
		
		//Insert into the memes table
		$stmt = $connect->prepare
		("insert into memes(title , path , tag , uploader , cat)
		value( ? , ? , ? , ? , ?)");
		$stmt->bind_param('sssss' , $title , $path , $tag , $uploader , $cat);
		$stmt->execute();
		
		//Create likes table
		$likes_table = "
		create table likes".$meme_number."(
		user_name varchar(255) not null
		)";
		$connect->query($likes_table);
		
		//Create comments table
		require('comments.php');
		$comments = new Comments();
		$comments->create_comments($meme_number);
	}
	
	}
		
	?>
	<p><a href='memes.php?m=new'>Click to see the newest memes!</a></p>
</div>













