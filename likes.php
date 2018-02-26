<?php
//Likes

include('connect.php');
$p = $_POST['p'];
$user = $_POST['username'];

$sql = "
insert into likes".$p." (
user_id , user_name
) value(
1,
'".$user."'
)
";

$c->query($sql);

$sql = "select count(id) as c from likes".$p;
$likes_count = 0;
$res = $c->query($sql);
while($row = $res->fetch_assoc()){
	$likes_count = $row['c'];
}

$sql = "
update posts set likes=".$likes_count." where id=".$p."
";

$c->query($sql);

$c->close();

?>



