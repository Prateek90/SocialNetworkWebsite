<?php

session_start();

include_once("connectdb.php");

$u_name=$_SESSION["u_name"];

$display_query="SELECT u_name, f_id, folder_name, privacy_setting FROM \"Assignment\".folders where u_name='$u_name'";

$folder_result=pg_query($conn,$display_query);

while($row=pg_fetch_assoc($folder_result)){
?>
<html>
	<body>
		<div>
			<form action="folder_content.php" method="get">
				<?php echo $row['folder_name'];?><br>
				<input type="hidden" id="f_id" name="f_id" value=<?php echo $row["f_id"]; ?>>
				<input type="submit" id="submit" name="submit">
			</form>
		</div>
		<div>
		<form action="folderentry.php" method="post">
		<input type="hidden" name="fid" value=<?php echo $row["f_id"];?>>
		<input type="hidden" name="delete" value="delete">
		<button type="submit" name="submit">Delete Folder</button>
		</div>
		<div>
		<form action="folderentry.php" method="post">
		<input type="hidden" name="f_id" value=<?php echo $row["f_id"];?>>
		Change_privacy:<input type="text" name="privacy_setting">
		<input type="hidden" name="privacy">
		<button type="submit">Change</button>
		</form>
		</div>
	</body>
</html>
<?php } ?>
<html>
	<body>
		<div>
			<form action="folderentry.php" method="post">
				FolderName:<input type="text" name="foldername">
				<input type="submit" name="submit">
			</form>
		</div>

	</body>
</html>