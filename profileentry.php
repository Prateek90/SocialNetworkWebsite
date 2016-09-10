<?php
session_start();?>
<?php

//error_reporting(0);

include("connectdb.php");

$u_name=$_SESSION["u_name"];

$title=$_POST["title"];

$c_id=rand(10000,20000);

$desc=$_POST["desc"];

$insert_cid="INSERT INTO \"Assignment\".contentids(c_id, pages) VALUES ($c_id, 'profile_c');";

$result_cid=pg_query($conn,$insert_cid);

$insert_profile="INSERT INTO \"Assignment\".profile_c(u_name, c_id, title, description) VALUES ('$u_name', $c_id, '$title', '$desc');";

$result_diary=pg_query($conn,$insert_profile);


include("displayprofile.php");


?>