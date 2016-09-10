<?php
session_start();

include_once("connectdb.php");

if(isset($_POST["delete"])){
	
	$c_id=$_POST["cid"];
	
	$comment="DELETE FROM \"Assignment\".comments WHERE c_id=$c_id;";
	
	$com_query=pg_query($conn, $comment);
	
	$content="DELETE FROM \"Assignment\".contentids WHERE c_id=$c_id;";

	$content_ex=pg_query($conn, $content);
	
	$query="DELETE FROM \"Assignment\".folder_content WHERE c_id=$c_id;";
	
	$query_ex=pg_query($conn,$query);
	
	header("Location:folder_content.php?f_id=".$_POST["f_id"]);
	
}

?>