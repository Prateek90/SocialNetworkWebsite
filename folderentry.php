<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

if(isset($_POST["privacy"])){
	
	$f_id=$_POST["f_id"];
	
	$privacy=$_POST["privacy_setting"];
	
	$change="UPDATE \"Assignment\".folders SET privacy_setting='$privacy' WHERE f_id=$f_id;";
	
	$change_privacy=pg_query($conn,$change);
	
	header("Location:displayfolder.php");
	
}

else if(isset($_POST["delete"]))
{
	$f_id=$_POST["fid"]; 
	

	
	$folder_content="DELETE FROM \"Assignment\".folder_content WHERE f_id=$f_id;";
	
	$folder_query=pg_query($conn, $folder_content);
	
	$folder="DELETE FROM \"Assignment\".folders WHERE f_id=$f_id;";
	
	$folder_q=pg_query($conn, $folder);

	header("Location:displayfolder.php");
	
}
else{
$f_id=rand(100,1000);

$folder_name=$_POST["foldername"];

$query="INSERT INTO \"Assignment\".folders(u_name, f_id, folder_name) VALUES ('$u_name', $f_id, '$folder_name');";

$q_ex=pg_query($conn, $query);

header("Location:displayfolder.php");
}
?>