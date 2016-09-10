<?php

session_start();

include_once("connectdb.php");

$u_name = $_SESSION["u_name"];

$visitor = $_SESSION["visited"];

$reject_query = "DELETE FROM \"Assignment\".friend_req WHERE receiver_id='$u_name' and sender_id='$visitor';";

$result_reject=pg_query($conn, $reject_query);

if($_POST["query_sel"]==1)
	header("Location:visitor_diary.php?visited=".$visited);
else if($_POST["query_sel"]==2)
	header("Location:pendingreq.php");

?>