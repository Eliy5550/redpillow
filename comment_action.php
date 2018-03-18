<?php
	//Got a comment request:
	require('comments.php');
	$comments = new Comments();
	//Form data
	$id = $_POST['id'];
	$c_text = $_POST['c_text'];
	$user_name = $_POST['user_name'];
	if($user_name == ""){
		echo "Log in to be able to comment.";
	}else{	
		require('connect.php');
		$sql = 'insert into coments1 (c_text , uploader) value("c_text" , "Eliy5550")';
		$comments->add_comment($id , $c_text , $user_name);
		echo "The comment was uploaded!";
	}
	
?>