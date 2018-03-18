<?php

require('comments.php');

$comments = new Comments();
$comments->get_comments($_POST['id'] , "no");

?>