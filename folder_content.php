<?php
session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

if(isset($_SESSION["visited"])){

$visited=$_SESSION["visited"];	
	
}else{
	
	$visited=$u_name;
	
}

$f_id=$_GET["f_id"];


$folderc_query="SELECT f_id,c_id,multi, title, description, time_stamp FROM \"Assignment\".folder_content where f_id=$f_id;";

$result_content=pg_query($conn , $folderc_query);

$profile_pic=$_SESSION["profilepic"];

$i=0;
while($row=pg_fetch_assoc($result_content)){
	//unlink("temp.jpg");
?>
<html>
	<body>

		<?php echo $row['title'];?><br>
		<?php echo $row['description'];?><br>
		<?php 
			$_SESSION["profilepic"]=$row["multi"];
			
			$i = $i + 1;
			
			$pitchure=$row["multi"];

			$unescape=pg_unescape_bytea($pitchure);

			$file_name="temp".$i.".jpg";

			$img=fopen($file_name, 'w');

			fwrite($img, $unescape);

			fclose($img);

		?>
		<img src=<?php echo $file_name;?> alt="unable to upload picture">
		<form action="foldercontententry.php" method="post">
			<input type="hidden" name="cid" value=<?php echo $row["c_id"];?>>
			<input type="hidden" name="f_id" value=<?php echo $f_id;?>>
			<button type="submit" name="delete">Delete content</button>
		</form>
	</body>
</html>

<html>
	<body>
		<form action="comments.php" method="post">
				Write Comment:<input type="text" name="comment"><br>
				<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
				<input type="hidden" name="owner_id" value=<?php echo $visited;?>>
				<input type="hidden" name="content_id" value=<?php echo $row["c_id"];?>>
				<input type="hidden" name="f_id" value=<?php echo $f_id;?>>
				<input type="hidden" name="page" value="folder_content.php">
				<input type="submit" name="submit">
			</form>
			</body>
		</html>
<?php 
		$c_id=$row["c_id"];
		$disp_comment="SELECT commentor_id, time_stamp, content FROM \"Assignment\".comments where content_id=$c_id ; ";
		$result_comment=pg_query($conn, $disp_comment);

		while($row_comment=pg_fetch_assoc($result_comment)){
		$commentor=$row_comment["commentor_id"];
		$queryscreen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$commentor';";
		$screen_query=pg_query($conn, $queryscreen);
		$result_screen=pg_fetch_assoc($screen_query);
		$screen_name1=$result_screen["screen_name"];	
			
			
			?>
		
		<html>
			<body>
				<?php echo $screen_name1.":"; echo $row_comment['content'];?><br>
			</body>
		</html>
			
		<?php	
		}


}
/*while($i>0){
	unlink("temp".$i.".jpg");
	$i=$i-1;
}*/

$_SESSION["profilepic"]=$profile_pic;
?>
<html>
	<body>
		<form  enctype="multipart/form-data" action="uploadpic.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="300000">
				<input type="hidden" name="f_id" value=<?php echo $f_id;?>>
				<input type="hidden" name="fname" value="folder_content.php">
				UploadPhoto:<input name="userfile" type="file" size="25">
				<input type="submit" value="Upload" >
		</form>
	</body>
</html>