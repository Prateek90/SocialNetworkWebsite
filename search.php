<?php

session_start();

include_once("connectdb.php");

//$search=strtolower($_POST["search"]);

$type=strtolower($_POST["type"]);


if(!strcmp($type,'friend_search')){
	
	$friend=$_POST["friend"];
	
	$search_query="SELECT u_name FROM \"Assignment\".\"USER\" where screen_name='$friend';";
	
	$result=pg_query($conn,$search_query);
	
	if(pg_num_rows($result)==0){
		
		echo "No Result found";
	
	}
	else{
		
		while($row=pg_fetch_assoc($result)){
		
		?>
		<html>
			<body>
				<div>
					<?php $url="visitor_diary.php?visited=".$row["u_name"]?>
					<a href=<?php echo $url; ?>><?php echo $row["u_name"];?></a><br>
				</div>
			</body>
		</html>
	<?php	
	}
	}
}

else if(!strcmp($type,'comments')){
	
	$friend=strtolower($_POST["friend"]);
	
	$search_comment="SELECT commentor_id, owner_id, content_id, content FROM \"Assignment\".comments where commentor_id='$friend';";
	
	$comment_result=pg_query($conn,$search_comment);
	
	if(pg_num_rows($comment_result)==0){
		
		echo "No Comments by $friend";
	}
	else{
		
			while($row=pg_fetch_assoc($comment_result)){
							
			$c_id=$row["content_id"];
			$contentids_query="SELECT pages FROM \"Assignment\".contentids where c_id=$c_id ;";
			//echo ($c_id);
			$contentids_query="SELECT pages FROM \"Assignment\".contentids where c_id=$c_id ;";
			$contentids_result=pg_query($conn, $contentids_query);
			
			$newrow=pg_fetch_assoc($contentids_result);
				
			$page=$newrow['pages'];
			
			echo $page;
			
			if(!strcmp($page,'profile_c')){
				
				//echo "in profile";
			
			$profile_query="select u_name,title,description from \"Assignment\".profile_c where c_id=$c_id";
			
			$profile_result=pg_query($conn,$profile_query);
			
			$entity=pg_fetch_assoc($profile_result);
			?>
			<html>
				<body>
					<?php echo $entity["u_name"]; ?><br>
					<?php echo $entity["title"];?><br>
					<?php echo $entity["description"];?><br>
					<?php 
					$comment_profile="SELECT commentor_id, owner_id, content FROM \"Assignment\".comments where content_id=$c_id;";
					
					$result=pg_query($conn,$comment_profile);
					
					while($row_new=pg_fetch_assoc($result)){?>
						<html>
							<body>
								<?php echo $row_new["commentor_id"]; echo $row_new["content"];?><br>
							<body>
						<html>
					<?php
					}
					
					?>
				
				
			<?php
			}else if(!strcmp($page,'diary_c')){
				
				//echo "in diary";
				
			$diary_query="select u_name,title,description from \"Assignment\".diary_c where c_id=$c_id";
			
			$diary_result=pg_query($conn,$diary_query);
			
			$entity_diary=pg_fetch_assoc($diary_result);
			?>
			<html>
				<body>
					<?php echo $entity_diary["u_name"]; ?><br>
					<?php echo $entity_diary["title"];?><br>
					<?php echo $entity_diary["description"];?><br>
					<?php 
					$comment_diary="SELECT commentor_id, owner_id, content FROM \"Assignment\".comments where content_id=$c_id;";
					
					$result_diary=pg_query($conn,$comment_diary);
					
					while($row_newdiary=pg_fetch_assoc($result_diary)){?>
						<html>
							<body>
								<?php echo $row_newdiary["commentor_id"]; echo $row_newdiary["content"];?><br>
							<body>
						<html>
					<?php
					}
									
			}			
				
			else if(!strcmp($page,'folder_content')){
				
				echo("Code not written");
				
			}
				
			}
			
			
		}
		
	}
else if(!strcmp($type,'keyword')){
	
	$needle=strtolower($_POST["word"]);
	//echo $needle;
	
	$diary_query="select u_name,title,description,c_id from \"Assignment\".diary_c";
			
	$diary_result=pg_query($conn,$diary_query);
	
	while($entity_diary=pg_fetch_assoc($diary_result)){
		
		$haystack=strtolower($entity_diary["title"]);
		$value=strpos($haystack,$needle);
		if($value !==False){
			$c_id=$entity_diary["c_id"];
			
			$u_name=$entity_diary["u_name"];
			$queryscreen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$u_name';";
			$screen_query=pg_query($conn, $queryscreen);
			$result_screen=pg_fetch_assoc($screen_query);
			$screen_name=$result_screen["screen_name"];
			
	?>
			<html>
				<body>
					<?php echo $screen_name; ?><br>
					<?php echo $entity_diary["title"];?><br>
					<?php echo $entity_diary["description"];?><br>
					<?php 
					$comment_diary="SELECT commentor_id, owner_id, content FROM \"Assignment\".comments where content_id=$c_id;";
					
					$result_diary=pg_query($conn,$comment_diary);
					
					while($row_newdiary=pg_fetch_assoc($result_diary)){
						
						$commentor=$row_newdiary["commentor_id"];
						$queryscreen="SELECT screen_name FROM \"Assignment\".\"USER\" where u_name='$commentor';";
						$screen_query=pg_query($conn, $queryscreen);
						$result_screen=pg_fetch_assoc($screen_query);
						$screen_name1=$result_screen["screen_name"];
						?>
						<html>
							<body>
								<?php echo $screen_name1.":"; echo $row_newdiary["content"];?><br>
							<body>
						<html>
					<?php
					}
									
			}		
	}			
	
}

?>