<?php
include('start.php');

?>



<div id='main'>

<div id='welcome'>
<h2>Welcome to <span id='red'>Red-Pillow</span></h2><br>
<p>Remember ,<br> A day without a meme -<br> is a wasted day.</p><br>
<p>So what are you waiting for?</p><br>
<p>Here on Red-Pillow you can <a id='red' href='upload.php'>upload</a> and <a id='red' href='memes.php'>watch</a>
the best memes on the internet.<br> If you have a great
idea for a new meme,<br> just upload it here and 
people will decide if it's good enough to become
popular by liking it.</p><br>
<p>Create a new profile and become a meme creator today!</p>
</div>

<div id='signup'>
	<h2>Become a meme creator...</h2>
	<h3 style='padding:10px;' id='red'>Sign up:</h3><br>
	<form action='index.php' method='post'>
	<input name='user_name' placeholder='User Name' type='text'><br><br>
	<input name='email' placeholder='Email' type='text'><br><br>
	<input name='pass' placeholder='Password' type='password'>	<br><br>
	<input type='submit' value='Signup'>
	</form>
	<?php
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	//Form data
	$user_name = $_POST['user_name'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	
	//Insert to table
	$sql = "insert into users (user_name , email , pass)
	value( ? , ? , ? )";
	$stmt = $connect->prepare($sql);
	$stmt->bind_param('sss' , $user_name , $email , $pass);
	
	//If ok move to the ok/login page
	if($stmt->execute()){
		echo "<br>You are now registered! <br><a href='login'>Login</a>.";
	}else{
		echo "<br>Something went wrong!<br>
		Try another username or email.";
	}
	
	}
	?>
</div>

</div>
<br>
<a id='memeslink' href='memes.php'>Click for memes</a>
<br>
<br>
<br>
<br>
</body>

</html>





