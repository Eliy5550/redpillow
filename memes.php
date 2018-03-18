<?php
include('start.php');
include('meme_cats.php');
?>
<br>
<br>
<form id='find_memes' action='memes.php' method='get'>
	<input autocomplete='off' id='find' placeholder='Search Memes' style='vertical-align:bottom;' type='text' name='m'>
	<button type='submit'><img height='45px' src='search.png'></button>
</form><br><br>
<script>
document.getElementById("find").focus();
</script>
<?php


//If no get var - Show popular memes
if(!isset($_GET['m'])){
	$_GET['m'] = "popular";
}

//What memes to show
$memes = $_GET['m'];

//Choose SQL for page
	$sql = "";
	if($memes == "new"){
	$sql = "select * from memes order by id desc";
	echo "<h3 style='text-align:left;margin-left:15%;'>Showing latest uploads:</h3><br><br>";
	}else if($memes == "popular"){
	echo "<h3 style='text-align:left;margin-left:15%;'>Showing popular memes:</h3><br><br>";
	//Get the date from 7 days ago
	$last_week = date('Y-m-d' , strtotime('-7 day'));
	$sql = "select * from memes where ts > '$last_week' order by likes desc";
	}else{
		echo "<h3 style='text-align:left;margin-left:15%;'>Search results and tags for - '$memes'</h3><br><br>";
		$sql = "select * from memes where tag like '%$memes%' or title like '%$memes%' or cat like '%$memes%'";
	}
	
	//Render the post with the Post_Renderer object.
	require('post_renderer.php');
	$post_renderer = new Post_Renderer($sql);
	$post_renderer->post_render($sql , false);
	
?>