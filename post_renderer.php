<?php
class Post_renderer{
	
function Post_Renderer(){ //Empty Constractor
	
}

//sql for rendering and can_delete for delete ability on the meme
function post_render($sql , $can_delete){
	require('connect.php'); //Connection code
	
	
	
	$res = $connect->query($sql);
	while($row = $res->fetch_assoc()){ 
		?>
		<div id='meme<?php echo $row['id']?>' class='meme'>
		<br>
		<?php 
		//Render the id of meme (Temporary)
		echo $row['id'];
		?>
		
		<!-- Top of the meme block - Title + Uploader -->
		<p class='title'><?php echo $row['title']; ?> 
		<small>- By <?php echo $row['uploader'];?></small></p>
		<br><hr><br>
		
		<!-- The picture itself + path. -->
		<img class='pic' src='<?php echo $row['path'];?>'>
		<br><br>
		
		<!-- Heart -->
		<button style='border:none;background-color:white;' onclick='like(<?php echo $row['id'];?>)'>
		<img id='heart<?php echo $row['id'];?>' height='40px' src='dislike.png'>
		</button>
		
		<!-- Delete Icon -->
		<?php
		if($can_delete){
			?>
			<img onclick='delMeme(<?php echo $row['id'];?>)' height='40px' src='del.png'><br><br>
			<?php
		}
		?>
		
		<!-- Heart Script -->
		<script>
		getHeart(<?php echo $row['id'];?>);
		</script>
		
		<!-- Alert - Active when liking the meme. -->
		<p id='a<?php echo $row['id'];?>'></p>
		<br>
		
		<!-- How many likes -->
		<p id='likes<?php echo $row['id'];?>'>
		<?php echo $row['likes'];?> people liked this.</p>
		<br>
		
		<!-- Comment -->
		<form action='javascript:void(0);' onsubmit='comment(<?php echo $row['id'];?>)'>
		<input autocomplete='off' id='commentInput<?php echo $row['id'];?>' 
		placeholder='What do you think?' 
		style='border:2px solid lightgrey' 
		type='text'>
		<br>
		<span id='commentAlert<?php echo $row['id'];?>'></span>
		<br>
		</form>
		
		<!-- Show all comments -->
		<?php
		include_once('comments.php');
		$comments = new Comments();
		$comments->get_comments($row['id'] , "no");
		?>
		
		<!-- Tag -->
		<a href='memes.php?m=<?php echo $row['tag'];?>'>
		<?php echo $row['tag'];?></a><br>
		<br>
		
		<!-- Time Stamp -->
		<p class='ts'><?php echo $row['ts'];?></p>
		
		</div><br><br>
		<?php
	}
	?>
	
	<?php
}
}
?>