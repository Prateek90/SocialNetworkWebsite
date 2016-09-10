<?php

session_start();

?>

<html>
	<body>
		<form action="visitor_diary.php" method="get">
		<input type="hidden" name="visited" value=<?php echo $_SESSION["visited"];?>>
		<button type="submit">Diary</button>
		</form>
		<a href="visitor_folder.php">Folder</a>
		<a href="displaydiary.php">Home</a>
	</body>
</html>

<?php

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_SESSION["visited"];

$result = "SELECT relationship FROM \"Assignment\".friends where u_name1='$u_name' and u_name2='$visited';";

$result_relation = pg_query($conn, $result);

$ret_profile="SELECT * FROM \"Assignment\".profile_c where u_name='$visited'";

$profile_result=pg_query($conn, $ret_profile);

$relationship='FOF';

if(!strcmp($result_relation['relationship'],'Friend')){

	while($row=pg_fetch_assoc($profile_result)){
	?>

	<html>
		<body>
	
		<?php echo $row["title"]?><br>
		<?php echo $row["description"]?><br>
	
		<?php
			/*$c_id=$row['c_id'];
			$disp_comment="SELECT commentor_id, time_stamp, content FROM \"Assignment\".comments where content_id=$c_id ; ";
			$result_comment=pg_query($conn, $disp_comment);
			while($row_comment=pg_fetch_assoc($result_comment)){?>
		
			<html>
				<body>
					<?php echo $row_comment['commentor_id'].":"; echo $row_comment['content'];?><br>
				</body>
			</html>
			
		<?php	
		}*/
		/*?>
		
		<form action="comments.php" method="post">
			Write Comment:<input type="text" name="comment"><br>
			<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
			<input type="hidden" name="owner_id" value=<?php echo $visited;?>>
			<input type="hidden" name="content_id" value=<?php echo $c_id;?>>
			<input type="hidden" name="page" value="visitor_profile.php">
			<input type="submit" name="submit">
		</form>
		</body>
	</html>

	<?*/
	}
	
	
}
else {
	
	$query_relation="Select u_name2 from \"Assignment\".friends where u_name1='$u_name'";
	
	$query_friends=pg_query($conn,$query_relation);
	
	if(!pg_num_rows($query_friends)){
			$relationship='E';
	}
	else{
		
		while($row_friend=pg_fetch_assoc($query_friends)){
			
			$uname2=$row_friend["u_name2"];
			
			$query_findrelation="Select * from \"Assignment\".friends where u_name1='$uname2' and u_name2='$visited'";
			
			$query_findrel=pg_query($conn,$query_findrelation);
			
			if(pg_num_rows($query_findrel)){
				$relationship='FOF';
				break;
			}
			else{
				$relationship='E';
			}
		}
		
	}
	
	
	if($relationship=='FOF'){
		
		while($row=pg_fetch_assoc($profile_result)){
			if($row['privacy_setting']=='Friend'){
				continue;
			}
	?>

	<html>
		<body>
	
		<?php echo $row["title"]?><br>
		<?php echo $row["description"]?><br>
	
		<?php
		/*$c_id=$row['c_id'];
		$disp_comment="SELECT commentor_id, time_stamp, content FROM \"Assignment\".comments where content_id=$c_id ; ";
		$result_comment=pg_query($conn, $disp_comment);
		while($row_comment=pg_fetch_assoc($result_comment)){?>
		
		<html>
			<body>
				<?php echo $row_comment['commentor_id'].":"; echo $row_comment['content'];?><br>
			</body>
		</html>
			
		<?php	
		}*/
		/*?>
		
		<form action="comments.php" method="post">
			Write Comment:<input type="text" name="comment"><br>
			<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
			<input type="hidden" name="owner_id" value=<?php echo $visited;?>>
			<input type="hidden" name="content_id" value=<?php echo $c_id;?>>
			<input type="hidden" name="page" value="visitor_profile.php">
			<input type="submit" name="submit">
		</form>
		</body>
	</html>

	<?*/ 
	}
		
	}
	else
	{
			while($row=pg_fetch_assoc($profile_result)){
			if($row['privacy_setting']=='E'){
			?>

			<html>
				<body>
	
				<?php echo $row["title"]?><br>
				<?php echo $row["description"]?><br>
				
				<?php
					/*$c_id=$row['c_id'];
					$disp_comment="SELECT commentor_id, time_stamp, content FROM \"Assignment\".comments where content_id=$c_id ; ";
					$result_comment=pg_query($conn, $disp_comment);
					while($row_comment=pg_fetch_assoc($result_comment)){?>
		
				<html>
					<body>
						<?php echo $row_comment['commentor_id'].":"; echo $row_comment['content'];?><br>
					</body>
				</html>
			
				<?php	
				}*/
				?>
		
			

	<? 
			}
		}
	
	}

	}
	
$query_pic="Select image from \"Assignment\".\"USER\" where u_name='$visited';";

$pic_query=pg_query($conn,$query_pic);

$result_pic=pg_fetch_assoc($pic_query);

$initialvalue=$_SESSION["profilepic"];

$_SESSION["profilepic"]=$result_pic["image"];

//$pic=$_SESSION["profilepic"];


include("picdisplay.php");

$_SESSION["profilepic"]=$initialvalue;

	?>
	
	
	
<?php
echo "comments";

$query_com="SELECT commentor_id,content,content_id FROM \"Assignment\".comments where owner_id='$visited';";

$query_comment=pg_query($conn, $query_com);

if(pg_num_rows($query_comment)==0){
	echo "No recent comments";
}
else{
	
	
	
	while($row_comment=pg_fetch_assoc($query_comment)){
		
		$cid=$row_comment["content_id"];
		
		$contentid_query="Select pages from \"Assignment\".contentids where c_id='$cid';";
		
		$content_query=pg_query($conn, $contentid_query);
		
		$fetch=pg_fetch_assoc($content_query);
		
		//echo $fetch["pages"];
		
		if(!strcmp($fetch["pages"],'profile_c')){
		$value=$row_comment["commentor_id"];
		
		
		
		$query_c="SELECT screen_name from \"Assignment\".\"USER\" where u_name='$value';";
		
		$exec_cm=pg_query($conn, $query_c);
		
		$name_screen=pg_fetch_assoc($exec_cm);
		
		$new_value=$row_comment["content"];
		
		?>
		
		<html>
			<body>
				<br>
				<?php echo $name_screen["screen_name"];?><br>
				
				<?php echo "\"$new_value\"";?><br>
			<body>
		<html>
		
		<?php
	}
		
	}
}



?>
	
	
	
	
	
<html>
<body>
			<form action="comments.php" method="post">
			Write Comment:<input type="text" name="comment"><br>
			<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
			<input type="hidden" name="owner_id" value=<?php echo $visited;?>>

			<input type="hidden" name="page" value="visitor_profile.php">
			<input type="submit" name="submit">
		</form>
</body>
</html>