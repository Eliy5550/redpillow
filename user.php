<?php
include('start.php');
include('meme_cats.php');
echo "<br><br>";
require('post_renderer.php');

$post_renderer = new Post_Renderer();
$user_name = $_SESSION['user_name'];
$sql = "select * from memes where uploader = '$user_name' order by id desc";

$post_renderer->post_render($sql , true);

?>
