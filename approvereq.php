<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];
if($_POST["query_sel"]==1){
$visited=$_SESSION["visited"];

$approve_query="UPDATE \"Assignment\".friend_req SET flag=1 WHERE sender_id='$u_name' and receiver_id='$visited';";

if(isset($_POST["query_sel"])){

//$val=$_POST["query_sel"];

$approve_query="UPDATE \"Assignment\".friend_req SET flag=1 WHERE receiver_id='$u_name' and sender_id='$visited';";
}


$result_approve=pg_query($conn, $approve_query);

if($result_approve)
	echo "YES";


	header("Location:visitor_diary.php?visited=".$visited);
}
else if($_POST["query_sel"]==2){
	
$visited=$_POST["visited"];

//$approve_query="UPDATE \"Assignment\".friend_req SET flag=1 WHERE sender_id='$u_name' and receiver_id='$visited';";


$approve_query="UPDATE \"Assignment\".friend_req SET flag=1 WHERE receiver_id='$u_name' and sender_id='$visited';";



$result_approve=pg_query($conn, $approve_query);
	header("Location:pendingreq.php");
}

?>