<?php

session_start();
?>
<a href="displaydiary.php">Diary</a>
<?php

include_once("connectdb.php");
$u_name=$_SESSION["u_name"];

$pending_query="SELECT sender_id FROM \"Assignment\".friend_req where receiver_id='$u_name';";

$pending_execute=pg_query($conn, $pending_query);

if(!pg_num_rows($pending_execute)){
	echo "No Pending Request";
}

while($row=pg_fetch_assoc($pending_execute)){
	
	$name = $row["sender_id"];
	
	$screen_query="SELECT image, screen_name FROM \"Assignment\".\"USER\" where u_name='$name';";
	
	$screen_execute=pg_query($conn, $screen_query);
	
	$result_screen=pg_fetch_assoc($screen_execute);
	
	
	
	?>

<html>
	<body>
		<div>
			<?php $url="visitor_diary.php?visited=".$row["sender_id"]?>
			<a href=<?php echo $url; ?>><?php echo $result_screen["screen_name"];?></a><br>
		</div>
		<div>
			<form action="approvereq.php" method="post">
				<input type="hidden" name="query_sel" value=2>
				<input type="hidden" name="visited" value=<?php echo $row["sender_id"]?>>
				<button name="approve">Approve request</button>
			</form>
		</div>
		<div>
			<form action="rejectrequest.php" method="post">
				<input type="hidden" name="query_sel" value=2>
				<input type="hidden" name="visited" value=<?php echo $row["sender_id"]?>>
				<button name="approve">Reject request</button>
			</form>
		</div>
	</body>
</html>

	
	
<?php	
}

?>