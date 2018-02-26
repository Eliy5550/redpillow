<!DOCTYPE html>
<html>
<?php

?>
<head>
<title>Red Pillow | Sign Up</title>
<link href='index.css' rel='stylesheet'>
</head>

<body>

<div id='top'>
<h1>Red Pillow | Sign Up</h1>
<small>Create an account in red pillow here:</small>
<a style='float:right' href='index.php'><button id='logout_button'>Log In</button></a>
</div>

<br>
<br>
<br>
<br>
<div id='login'>
<h2>Sign Up</h2><br>
<form action='signup.php' method='post'>
<input placeholder='Username' autocomplete='off' name='username' type='text' required><br><br>
<input id='email' placeholder='Email' autocomplete='off' name='email' type='email' required><br><br>
<input placeholder='Password' autocomplete='off' name='password' type='password' required><br><br>
<div style='height:0px;'><input id='submit_button' type='submit' value='Sign Up'></div>
</form>
<br>
<br>
<br>
<br>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
include('connect.php');

$new_user_name = $_POST['username'];
$new_email = $_POST['email'];
$new_password = $_POST['password'];

$stmt = $c->prepare("insert into users (user_name , email , pass) 
values(? , ? , ?)");
echo "<br>";
$stmt->bind_param("sss" , $new_user_name , $new_email , $new_password);

if($stmt->execute()){
	echo "<div id='created'>You have successfully created a user at red pillow!<br>
	<a href='index.php'>Log in</a> now !</div>";
}else{
	echo "<div id='errors'>Bad stuff</div>";
}
$c->close();
}


?>
<br>
<br>
</div>
<div id='end'>
<h3>Memes are love.<br>Memes are life.</h3>
</div>


</body>

</html>