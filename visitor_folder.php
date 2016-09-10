<?php

session_start();
?>

<html>
	<body>
		<a href="visitor_profile.php">Profile</a>
		<form action="visitor_diary.php" method="get">
		<input type="hidden" name="visited" value=<?php echo $_SESSION["visited"];?>>
		<button type="submit">DIARY</button>
		</form>
		<a href="visitor_diary.php">Diary</a>
		<a href="displaydiary.php">Home</a>
	</body>
</html>

<?php
include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_SESSION["visited"];

$result = "SELECT relationship FROM \"Assignment\".friends where u_name1='$u_name' and u_name2='$visited';";

$result_relation=pg_query($conn, $result);

$display_query="SELECT u_name, f_id, folder_name, privacy_setting FROM \"Assignment\".folders where u_name='$visited'";

$folder_result=pg_query($conn,$display_query);

if(!strcmp($result_relation['privacy_setting'],'Friend')){
	

	while($row=pg_fetch_assoc($folder_result)){
	?>
	<html>
		<body>
			<div>
				<form action="folder_content.php" method="post">
					<?php echo $row['folder_name'];?><br>
					<input type="hidden" id="f_id" name="f_id" value=<?php echo $row['f_id']; ?>>
					<input type="submit" id="submit" name="submit">
				</form>
			</div>
		</body>
	</html>
<?php }
}
else{
	
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
	
	if($relationship == 'FOF'){
			
		while($row=pg_fetch_assoc($folder_result)){
			if($row['privacy_setting']=='Friend'){
				continue;
			}
		?>
		<html>
			<body>
				<div>
					<form action="folder_content.php" method="post">
						<?php echo $row['folder_name'];?><br>
						<input type="hidden" id="f_id" name="f_id" value=<?php echo $row['f_id']; ?>>
						<input type="submit" id="submit" name="submit">
					</form>
				</div>
			</body>
		</html>
		
<?php	}
	}
	else{
		while($row=pg_fetch_assoc($folder_result)){
		if($row['privacy_setting']=='E'){
		?>
		<html>
			<body>
				<div>
					<form action="folder_content.php" method="post">
						<?php echo $row['folder_name'];?><br>
						<input type="hidden" id="f_id" name="f_id" value=<?php echo $row['f_id']; ?>>
						<input type="submit" id="submit" name="submit">
					</form>
				</div>
			</body>
		</html>
		
<?
			}
		}
	}
}

 ?>
