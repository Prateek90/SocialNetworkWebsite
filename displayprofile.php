<?php

session_start();
?>

<html>
	<body>
		<a href="displaydiary.php">Diary</a>
		<a href="displayfolder.php">Folder</a>
		<a href="friendlist.php">FriendList</a>
		<a href="search.php">Search</a><br>
	<body>
<html>

<?php
include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$ret_profile="SELECT * FROM \"Assignment\".profile_c where u_name='$u_name'";

$profile_result=pg_query($conn, $ret_profile);

while($row=pg_fetch_assoc($profile_result)){
?>

<html>
	<body>
	
	<?php echo $row["title"]?><br>
	<?php echo $row["description"]?><br>
	
	</body>
</html>

<?php
}
?>
<html>
	<body>	
		<div>
		<form action="profileentry.php" method="POST">
			Title:<input type="text" name="title"><br>
			Description:<input type="text" name="desc"><br>
			<button type="submit">POST</button>
		</form>
		</div>
	</body>
</html>

<?php
echo "comments";

$query_com="SELECT commentor_id,content,content_id FROM \"Assignment\".comments where owner_id='$u_name';";

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