<?php
session_start();

include_once("header.html");

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$disp_diary = "SELECT * FROM \"Assignment\".diary_c where u_name='$u_name';";

$diary_result=pg_query($conn, $disp_diary);

//$disp_comment="SELECT commentor_id, owner_id, time_stamp, content_id, content, multi FROM \"Assignment\".comments where content_id=;";

while ($row = pg_fetch_assoc($diary_result)){ 
 ?>
 
 <html>
	<body>
		<?php echo $row['title'];?><br>
		<?php echo $row['description'];?><br>
		<?php
		$c_id=$row['c_id'];
		$disp_comment="SELECT commentor_id, time_stamp, content FROM \"Assignment\".comments where content_id=$c_id ; ";
		?>
		<html>
			<body>
				<div>
				<form action="diaryentry.php" method="post">
					Change Privacy Setting:<input type="text" name="privacy">
					<input type="hidden" name="cid" value=<?php echo $c_id;?>>
					<button type="submit" name="change">change</button>
				</form>
				</div>
				<div>
				<form action="diaryentry.php" method="post">
					<input type="hidden" name="cid" value=<?php echo $c_id;?>>
					<input type="hidden" name="delete" value=1>
					<button type="submit" name="del">Delete Post</button>
				</form>
				</div>
			</body>
		</html>		
		
		<?php
		$result_comment=pg_query($conn, $disp_comment);
		while($row_comment=pg_fetch_assoc($result_comment)){
			$commentor_id=$row_comment["commentor_id"];
			$name="Select screen_name from \"Assignment\".\"USER\" where u_name='$commentor_id';";
			$result_name=pg_query($conn,$name);
			$result_n=pg_fetch_assoc($result_name);
			$screen_name=$result_n["screen_name"];
			?>
		
		<html>
			<body>
				<?php echo $screen_name.":"; echo $row_comment['content'];?><br>
			</body>
		</html>
			
		<?php	
		}
		?>
		
		<form action="comments.php" method="post">
			Write Comment:<input type="text" name="comment"><br>
			<input type="hidden" name="commentor_id" value=<?php echo $_SESSION["u_name"];?>>
			<input type="hidden" name="owner_id" value=<?php echo $_SESSION["u_name"];?>>
			<input type="hidden" name="content_id" value=<?php echo $c_id;?>>
			<input type="hidden" name="page" value="displaydiary.php">
			<input type="submit" name="submit">
		</form>
	</body>
</html>
<?php
}

$query_pic="Select image from \"Assignment\".\"USER\" where u_name='$u_name';";
$pic_query=pg_query($conn,$query_pic);

$result_pic=pg_fetch_assoc($pic_query);

$_SESSION["profilepic"]=$result_pic["image"];

//$pic=$_SESSION["profilepic"];


include("picdisplay.php");

?>
<html>
	<body>
		<div>
		<form action="diaryentry.php" method="post">
			What's on your mind?:<input type="text" name="title">
			<button type="submit">POST</button>
		</form>
		</div>
		<div>
			<form  enctype="multipart/form-data" action="diaryentry.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="300000">
				UploadPhoto:<input name="userfile" type="file" size="25">
				<input type="submit" value="Upload" >
			</form>
		</div>
	</body>
</html>

