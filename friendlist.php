<?php

session_start();

include_once("connectdb.php");

$u_name1=$_SESSION["u_name"];

$friendlist="SELECT * FROM \"Assignment\".friends where u_name1='$u_name1';";

$result_friend=pg_query($conn , $friendlist);

while($row=pg_fetch_assoc($result_friend)){
?>

<html>
	<body>
		<div>
			<?php $url="visitor_diary.php?visited=".$row["u_name2"]?>
			<a href=<?php echo $url; ?>><?php echo $row["u_name2"];?></a><br>
		</div>
	</body>
</html>

<?php

}

?>

