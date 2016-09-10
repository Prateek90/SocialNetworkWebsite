<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_GET["visited"];

$title=$_GET["title"];

$c_id=rand(1000,10000);

$insert_cid="INSERT INTO \"Assignment\".contentids(c_id, pages) VALUES ($c_id, 'diary_c');";

$result_cid=pg_query($conn,$insert_cid);


$post_query="INSERT INTO \"Assignment\".diary_c(u_name, title, postedby, c_id) VALUES ('$visited', '$title', '$u_name',$c_id);";

$post_execute=pg_query($conn, $post_query);

header("Location:visitor_diary.php?visited=".$visited);

?>