<?php 
/*	
	include_once("connectdb.php") ;
	
	if(isset($_POST["submit"])){
	
	$name=$_POST["name"];
	
	$pass=$_POST["password"]; 
	
	$query = "Select * from \"Assignment\".password where u_name='$name' and password='$pass';";
	
	echo $query;
	
	$result=pg_query($conn,$query);
	
	if(pg_num_rows($result))
		echo "Query executed succesfully";
	
	else
		echo "Query failed";
	}
	*/
	echo $_POST["name"];
	echo $_POST["password"];
	
?>

