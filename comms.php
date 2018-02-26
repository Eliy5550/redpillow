<?php

$post_id = $_GET['p'];

$get_comments_sql = "select * from comments".$post_id. " limit 2";
		$get_comments_sql_res = $c->query($get_comments_sql);
		while($row = $get_comments_sql_res->fetch_assoc()){
			$poster = $row['poster'];
			$comm = $row['comm'];
			$tp = $row['tp'];
			echo "<b>$poster</b><small> -- $tp</small><br><span>$comm</span><br>";
		}
		echo "<small><i>Posted at: ". $post_ts . "</i></small><br></div>";

?>	