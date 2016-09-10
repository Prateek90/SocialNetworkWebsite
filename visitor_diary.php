<?php

session_start();?>

<html>
	<body>
		<a href="visitor_profile.php">Profile</a>
		<a href="visitor_folder.php">Folder</a>
		<a href="displaydiary.php">Home</a>
	</body>
</html>


<?php

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_GET["visited"];

$_SESSION["visited"]=$visited;

$screen="SELECT screen_name,privacy_setting FROM \"Assignment\".\"USER\" where u_name='$u_name';";

$screen_exec=pg_query($conn, $screen);

$screen_execute=pg_fetch_assoc($screen_exec);


$screen_visit="SELECT screen_name,privacy_setting FROM \"Assignment\".\"USER\" where u_name='$visited';";

$screen_execv=pg_query($conn, $screen_visit);

$screen_executev=pg_fetch_assoc($screen_execv);
//Query to find relationship between the u_name and visited
$result ="SELECT relationship FROM \"Assignment\".friends where u_name1='$u_name' and u_name2='$visited';";

$result_relationship=pg_query($conn, $result);

$disp_diary = "SELECT * FROM \"Assignment\".diary_c where u_name='$visited';";

$diary_result=pg_query($conn, $disp_diary);
	
$relation=pg_fetch_assoc($result_relationship);	

//Condition to check wheather the two are friends or not.
if(!pg_num_rows($result_relationship)){
	
	//Query to check wheather friend request is already sent or not.
	$check_req="SELECT sender_id, receiver_id, flag FROM \"Assignment\".friend_req where (sender_id='$u_name' and receiver_id='$visited') or (sender_id='$visited' and receiver_id='$u_name');";
	
	$result_req=pg_query($conn,$check_req);
	
	//Condition to check if freind request sent or not.
	if(!pg_num_rows($result_req)){
	
	?>

	<html>
		<body>
			<form action="sendreq.php" method="post">
				<button type="submit">SEND REQUEST</button>
			</form>
		</body>
	</html>
<?php
	}	
	else{
		//If friend request is already sent.
		$result_row=pg_fetch_assoc($result_req);
		
		$senderid=$result_row["sender_id"];
		
		$receiverid=$result_row["receiver_id"];
		
		if($senderid==$u_name){?>
		
		<html>
			<body>
				<button>Friend Request Sent</button>
			</body>
		</html>
	
		
<?php
		}
		else{?>
			<html>
				<body>
					<div>
					<form action="approvereq.php" method="post">
						<input type="hidden" name="query_sel" value=1>
						<button name="approve">Approve request</button>
					</form>
					</div>
					<div>
					<form action="rejectrequest.php" method="post">
						<input type="hidden" name="query_sel" value=1>
						<button name="approve">Reject request</button>
					</form
				</body>
			</html>
		<?php
		}
	}
}

//If the two are already friends then check the relationship between them.	
if(!strcmp($relation['relationship'],'Friend')){?>

	<html>
		<body>
			<div>
			<form action="unfriend.php" method="get">
				<input type="hidden" name="visited" value=<?php echo $visited;?>>
				<button type="submit">Unfriend</button>
			</form>
			</div>
			<div>
			<form action="diary_post.php" method="get">
				Write Something:<input type="text" name="title"><br>
				<input type="hidden" name="visited" value=<?php echo $visited;?>>
				<button type="submit">POST</button>
			</form>
			</div>
			<div>
				<form action="time.php" method="post">
				<button type="submit">Last 1 Week Diary</button>
				</form>
			</div>
		</body>
	<html>
	
	<?php
	
	
	
	//Everything will be shown to friend so no need to check for privacy setting.
	while($row=pg_fetch_assoc($diary_result)){
		
		if(!strcmp($row['postedby'],'self')){
			$screen_name=$screen_executev["screen_name"];
		}
		else{
			$postby=$row["postedby"];
			$query_screen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$postby';";
			$screenquery=pg_query($conn, $query_screen);
			$resultscreen=pg_fetch_assoc($screenquery);
			$screen_name=$resultscreen["screen_name"];
		}
		
	?>

	<html>
		<body>
		<?php echo $screen_name;?><br>
		<?php echo $row["title"]?><br>
		<?php echo $row["description"]?><br>
	
		<?php
		$c_id=$row['c_id'];
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
		//Commenting on some post.
		?>
		<html>
			<body>
			<form action="comments.php" method="post">
				Write Comment:<input type="text" name="comment"><br>
				<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
				<input type="hidden" name="owner_id" value=<?php echo $visited;?>>
				<input type="hidden" name="content_id" value=<?php echo $c_id;?>>
				<input type="hidden" name="page" value="visitor_diary.php">
				<input type="submit" name="submit">
			</form>
			</body>
		</html>

	<?php 
	}
	
	
}
//If the two are nt friends
else {
	//Code to determine the relationship between the two.
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
		
		if(!strcmp($screen_executev["privacy_setting"],'FOF')){?>
		<html>
			<body>
				<div>
					<form action="diary_post.php" method="get">
						Write Something:<input type="text" name="title"><br>
						<input type="hidden" name="visited" value=<?php echo $visited;?>>
						<button type="submit">POST</button>
					</form>
				</div>
			</body>
		</html>
		<?php
		}
		
		//Code to display every post except the one's marked for Friends.
		while($row=pg_fetch_assoc($diary_result)){
			if($row['privacy_setting']=='Friend'){
				continue;
			}
			if(!strcmp($row["postedby"],"self")){
				$screen_name=$screen_executev["screen_name"];
			}
			else{
				$post=$row["postedby"];
				$query_screen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$post';";
				$screenquery=pg_query($conn, $query_screen);
				$resultscreen=pg_fetch_assoc($screenquery);
				$screen_name=$resultscreen["screen_name"];
			}
	?>

	<html>
		<body>
	
		<?php echo $row["title"]?><br>
		<?php echo $row["description"]?><br>
		
		<?php
		$c_id=$row['c_id'];
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
		?>
		
		<form action="comments.php" method="post">
			Write Comment:<input type="text" name="comment"><br>
			<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
			<input type="hidden" name="owner_id" value=<?php echo $visited;?>>
			<input type="hidden" name="content_id" value=<?php echo $c_id;?>>
			<input type="hidden" name="page" value="visitor_diary.php">
			<input type="submit" name="submit">
		</form>
		</body>
	</html>

	<? 
	}
		
	}
	else
	{
		if(!strcmp($screen_executev["privacy_setting"],'FOF')){?>
		<html>
			<body>
				<div>
					<form action="diary_post.php" method="get">
						Write Something:<input type="text" name="title"><br>
						<input type="hidden" name="visited" value=<?php echo $visited;?>>
						<button type="submit">POST</button>
					</form>
				</div>
			</body>
		</html>
		<?php
		
			//Code to display every post marked as 'E'.
			while($row=pg_fetch_assoc($diary_result)){
			if($row['privacy_setting']=='E'){
				if(!strcmp($row["postedby"],"self")){
					$screen_name=$screen_executev["screen_name"];
				}
				else{
					$post=$row["postedby"];
					$query_screen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$post';";
					$screenquery=pg_query($conn, $query_screen);
					$resultscreen=pg_fetch_assoc($screenquery);
					$screen_name=$resultscreen["screen_name"];
				}
				
			?>

			<html>
				<body>
	
				<?php echo $row["title"]?><br>
				<?php echo $row["description"]?><br>
				
				<?php
				$c_id=$row['c_id'];
				$disp_comment="SELECT commentor_id, time_stamp, content FROM \"Assignment\".comments where content_id=$c_id ; ";
				$result_comment=pg_query($conn, $disp_comment);
				while($row_comment=pg_fetch_assoc($result_comment)){
				$comment=$row_comment["commentor_id"];
				$queryscreen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$comment';";
				$screen_query=pg_query($conn, $queryscreen);
				$result_screen=pg_fetch_assoc($screen_query);
				$screen_name1=$result_screen["screen_name"];	
			
					
					?>
		
				<html>
					<body>
						<?php echo $screen_nname1.":"; echo $row_comment['content'];?><br>
					</body>
				</html>
			
				<?php	
				}
				?>
		
				<form action="comments.php" method="post">
				Write Comment:<input type="text" name="comment"><br>
				<input type="hidden" name="commentor_id" value=<?php echo $u_name;?>>
				<input type="hidden" name="owner_id" value=<?php echo $visited;?>>
				<input type="hidden" name="content_id" value=<?php echo $c_id;?>>
				<input type="hidden" name="page" value="visitor_diary.php">
				<input type="submit" name="submit">
				</form>
			</body>
		</html>

	<? 
			}
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

