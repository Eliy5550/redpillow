<?php

class Comments{

function Comments(){
	
}

function create_comments($id){
	include('connect.php');
	$sql = "
	create table comments$id (id int primary key auto_increment,
	c_text mediumtext not null,
	uploader varchar(255) not null,
	ts timestamp not null default current_timestamp
	)";
	$connect->query($sql);
	}

function add_comment($id , $comment , $uploader){
	include('connect.php');
	$sql = "insert into comments$id (c_text , uploader)
	value ('$comment' , '$uploader')";
	$connect->query($sql);
}

function del_comment($c_id , $t_id){
	include('connect.php');
	$sql = "delete from comments$t_id where id=$c_id";
	$connect->query($sql);
}

function del_comments_table($id){
	include('connect.php');
	$sql = "drop table comments$id";
	$connect->query($sql);
}

function get_comments($id , $show){
	include('connect.php');
	if($show == "all"){
	$sql = "select * from comments$id order by id desc";
	}else{
	$sql = "select * from comments$id order by id desc limit 2";
	}
	
	$res = $connect->query($sql);
	echo "<div id='comments_section".$id."'>";
	while($row = $res->fetch_assoc()){
		$c_id = $row['id'];
		$c_text = $row['c_text'];
		$uploader = $row['uploader'];
		$ts = $row['ts'];
		
		echo "<div class='comment'><b>$uploader</b> : <br>
		$c_text<br>
		<small>$ts</small></div><br><br>";
		
	}
	echo "</div>";
}









}
?>