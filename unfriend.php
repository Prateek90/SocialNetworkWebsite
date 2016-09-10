<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_GET["visited"];

$unfriend_query1="DELETE FROM \"Assignment\".friends WHERE u_name1='$u_name' and u_name2='$visited';";

$unfriend_execute1=pg_query($conn, $unfriend_query1);

$unfriend_query2="DELETE FROM \"Assignment\".friends WHERE u_name1='$visited' and u_name2='$u_name';";

$unfriend_execute2=pg_query($conn, $unfriend_query2);

header("Location:visitor_diary.php?visited=".$visited);

?>