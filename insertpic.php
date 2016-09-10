<?php

session_start();

if(isset($_FILES['userfile'])){
	
	//print_r $_FILES['userfile'];
	
	$uploadfile=file_get_contents($_FILES['userfile']['name']);
	
	$escaped = pg_escape_bytea( $uploadfile );
	
	$insert_image="UPDATE \"Assignment\".diary_c SET image='{$escaped}' WHERE u_name='$u_name';";
	
	$upload_image=pg_query($conn,$insert_image);
	
	//echo "$upload_image";
	
	if($upload_image){
		echo "Image uploaded";
		$image_fetch=pg_query($conn,"Select image from \"Assignment\".diary_c where u_name='$u_name'");
		$raw=pg_unescape_bytea(pg_fetch_result($image_fetch,0,0));
		$file_name="newimage.jpg";
		$img = fopen($file_name, 'wb') or die("cannot open image\n");
		fwrite($img, $raw) or die("cannot write image data\n");
		fclose($img);
		//header("Content-type: image/jpeg");
		echo "<IMG SRC=\"newimage.jpg\"></br>";	
	}
	else{
		echo "Error uploading file";
	}
}
?>