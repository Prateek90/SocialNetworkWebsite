<?php

session_start();

include_once("connectdb.php");

$commentor_id=$_POST["commentor_id"];

$owner_id=$_POST["owner_id"];

$content_id=$_POST["content_id"];

$content=$_POST["comment"];



//echo $content;

$insert_comment="INSERT INTO \"Assignment\".comments(commentor_id, owner_id, content_id, content) VALUES ('$commentor_id', '$owner_id', $content_id, '$content');";

$comment_query=pg_query($conn, $insert_comment);

/*if($comment_query){
	echo "comment inserted";
}
else{
	echo "Insertion failed";
}*/

$page=$_POST["page"];

if(!strcmp($page,'folder_content.php')){
	$f_id=$_POST["f_id"];
	//echo "abcd";
	header("Location:".$page."?f_id=".$f_id);
	exit();
}

//header("Location:".$page."?visited=".$owner_id);

?>