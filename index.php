<!DOCTYPE html>
<html>
<?php

session_start();

if(isset($_SESSION['user_name'])){
	header('Location: http://localhost/red-pillow/feed.php');
}

include('connect.php');

?>
<head>
<title>Red-Pillow | Log In</title>
<link href='index.css' rel='stylesheet'>
</head>

<body>

<div id='top'>
<h1>Red Pillow</h1>
<small>Memes , Videos , Gifs and FUN!</small>
</div>

<div id='center_wrap'>
<a href='signup.php'><button class='inline' id='signup_button'><h2>Sign Up<h2></button></a>

<div id='login' class='inline'>
<h2>Log in</h2><br>
<form action='index.php' method='post'>
<input value='<?php
if($_SERVER['REQUEST_METHOD']=='POST'){echo $_POST['username'];}?>
'autocomplete='off' type='text' name='username' placeholder='Username'><br><br>
<input autocomplete='off' type='password' name='password' placeholder='Password'>
<br><br><div style='height:0px;'><input id='submit_button' type='submit' value='Log In'></div>
</form><br>
</div>

<div id='errors'>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	if( empty($_POST['username'] )){
		echo "* Username is missing!<br>";
	}
	if( empty($_POST['password'] )){
		echo "* Password is missing!<br>";
	}
	
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$sql = "SELECT * FROM users where 
	user_name='$username' AND 
	pass='$password'";
	
	$res = $c->query($sql);
	
	
	if($res->num_rows > 0){
		echo "Connected!";
		while($row = $res->fetch_assoc()){
			$_SESSION['user_name'] = $row['user_name'];
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['email'] = $row['email'];
			header('Location: http://localhost/red-pillow/feed.php');
		}
	}else if($res->num_rows == 0 && $password != ""){
		echo "Wrong Username / Password !";
	}
}

?>
</div>
</div>

<br>

<div id='end'>
<h3>Memes are love.<br>Memes are life.</h3>
</div>

</body>

</html>