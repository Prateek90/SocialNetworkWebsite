<?php

session_start();

include_once("connectdb.php");

$f_id=$_POST["f_id"];

//echo $f_id;

if(isset($_FILES['userfile'])){
	
	//print_r $_FILES['userfile'];
	$c_id=rand(20000,30000);
	
	$uploadfile=file_get_contents($_FILES['userfile']['name']);
	
	$escaped = pg_escape_bytea( $uploadfile );
	
	$insert_cid="INSERT INTO \"Assignment\".contentids(c_id, pages) VALUES ($c_id, 'folder_content');";

	$contentid=pg_query($conn,$insert_cid);
		
	$insert_pic="INSERT INTO \"Assignment\".folder_content(f_id, c_id, multi) VALUES ($f_id, $c_id,'{$escaped}');";
	
	$upload_pic=pg_query($conn,$insert_pic);
	
	//$insert_image="UPDATE \"Assignment\".folder_content SET multi='{$escaped}' WHERE f_id=$f_id and c_id=$c_id;";
	
	//$upload_image=pg_query($conn,$insert_image);
	
	//echo "$upload_image";
	
	/*if($upload_pic){
		echo "Image uploaded";
	}*/
	
	
	
}
if(isset($_POST["fname"])){
		header("Location:".$_POST["fname"]."?f_id=".$f_id);
	}


?>



