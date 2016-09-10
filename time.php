<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$visited=$_SESSION["visited"];

$time_query="Select * from \"Assignment\".diary_c where u_name='$visited' and time_stamp>=(clock_timestamp()-interval '1 week');";

$query=pg_query($conn, $time_query);



while($row=pg_fetch_assoc($query)){
		
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

?>