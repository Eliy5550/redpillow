<?php 
include('start.php'); 
?>
<br>
<a id='memeslink' href='memes.php'>Click for memes</a>
<br>
<br><br>
<div id='signup'>
	<h2>Red-Pillow</h2>
	<h3 style='padding:10px;' id='red'>Login:</h3><br>
	<form action='login.php' method='post'>
	<input name='user_name' placeholder='User Name' type='text'><br><br>
	<input name='pass' placeholder='Password' type='password'>	<br><br>
	<input type='submit' value='Log In'>
	</form>
	
	<?php
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	//Form data
	$user_name = htmlspecialchars($_POST['user_name']);
	$pass = htmlspecialchars($_POST['pass']);
	
	//Log in check 
	$sql = "select * from users where user_name = '$user_name' and pass = '$pass'";
	$result = $connect->query($sql);
	
	//If ok say so
	if($result->num_rows > 0){
		?>
		<script>
		$('#signup').html('Hello there Meme Creator <b id="red"><?php echo $user_name;?></b> !');
		</script>
		<?php
		echo "<br><a href='upload.php'><br>Click to upload a meme</a>";
		//Save session variables
		$_SESSION['user_name'] = $user_name;
	}else{
		echo "Try again";
	}
	
	}
	?>
	
</div>









