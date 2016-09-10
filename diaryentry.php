<?php
session_start();

include("connectdb.php");


$u_name=$_SESSION["u_name"];

if(isset($_POST["privacy"]))
{
	$c_id=$_POST["cid"];
	
	//echo "inside privacy";
	$privacy=$_POST["privacy"];
	
	$update_privacy="UPDATE \"Assignment\".diary_c SET privacy_setting='$privacy' WHERE u_name='$u_name'and c_id=$c_id;";
	
	$update_query=pg_query($conn, $update_privacy);
	
	header("Location:displaydiary.php");
}
if(isset($_POST["delete"]))
{
	
	$c_id=$_POST["cid"];
	
	$delete_post="DELETE FROM \"Assignment\".diary_c WHERE c_id=$c_id;";
	
	$delete_query=pg_query($conn, $delete_post);
	
	$del_cid="Delete from \"Assignment\".contentids where c_id=$c_id;";
	
	$del_query=pg_query($conn, $del_cid);
	
	$del_comments = "Delete from \"Assignment\".comments where content_id=$c_id;";
	
	$delcom_query=pg_query($conn, $del_comments);
	//echo "inside";
	
	header("Location:displaydiary.php");
	
}

if(isset($_POST["title"])){
	
$title=$_POST["title"];

$c_id=rand(1000,10000);

$insert_cid="INSERT INTO \"Assignment\".contentids(c_id, pages) VALUES ($c_id, 'diary_c');";

$result_cid=pg_query($conn,$insert_cid);

$insert_diary="INSERT INTO \"Assignment\".diary_c(u_name, title, c_id) VALUES ('$u_name', '$title', $c_id);";

$result_diary=pg_query($conn,$insert_diary);

//include("displaydiary.php");
}
if(isset($_FILES['userfile'])){
	
	//print_r $_FILES['userfile'];
	
	$uploadfile=file_get_contents($_FILES['userfile']['name']);
	
	$escaped = pg_escape_bytea( $uploadfile );
	
	$insert_image="UPDATE \"Assignment\".\"USER\" SET image='{$escaped}' WHERE u_name='$u_name';";
	
	$upload_image=pg_query($conn,$insert_image);
	
	//echo "$upload_image";
	
	if($upload_image){
		echo "Image uploaded";
		/*$image_fetch=pg_query($conn,"Select image from \"Assignment\".\"USER\" where u_name='$u_name'");
		$raw=pg_unescape_bytea(pg_fetch_result($image_fetch,0,0));
		$file_name="newimage.jpg";
		$img = fopen($file_name, 'wb') or die("cannot open image\n");
		fwrite($img, $raw) or die("cannot write image data\n");
		fclose($img);
		//header("Content-type: image/jpeg");
		echo "<IMG SRC=\"newimage.jpg\"></br>";	
	}
	else{
		echo "Error uploading file";*/
	}
	
	//include("displaydiary.php");
	
}

header("Location:displaydiary.php");


?>