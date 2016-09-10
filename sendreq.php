<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_SESSION["visited"];

$query_friendreq="INSERT INTO \"Assignment\".friend_req(sender_id, receiver_id) VALUES ('$u_name','$visited');";

$result_friendreq=pg_query($conn,$query_friendreq);

if($result_friendreq){
	echo "Friend Request sent";
	
	header("Location:email.php");
}
?>