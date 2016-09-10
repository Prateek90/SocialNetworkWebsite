<?php
	session_start();

	include_once("connectdb.php");

	$f_name='';
	$l_name='';
	$street='';
	$city='';
	$country='';
	$gender='';
	$screen_name='';
	
	if(isset($_POST["u_name"]) and isset($_POST["password"])){
		$u_name = $_POST["u_name"];
		
		$pass = $_POST["password"];
		
		$insert_pass = "INSERT INTO \"Assignment\".password(u_name, password) VALUES ('$u_name','$pass')";

		$result = pg_query($conn , $insert_pass);
	
	
	if(isset($_POST["fname"])){
		$f_name = $_POST["fname"];
	}
	
	if(isset($_POST["lname"])){
		$l_name = $_POST["lname"];
	}
	
	if(isset($_POST["street"])){
		$street = $_POST["street"];
	}
	
	if(isset($_POST["city"])){
		$city = $_POST["city"];
	}
	
	if(isset($_POST["country"])){
		$country = $_POST["country"];
	}
	
	if(isset($_POST["gender"])){
		$gender = $_POST["gender"];
	}
	
	if(isset($_POST["screen_name"])){
		$screen_name = $_POST["screen_name"];
	}



$insert_user="INSERT INTO \"Assignment\".\"USER\"(u_name, f_name, l_name, street, city, country, gender, screen_name) VALUES ('$u_name', '$f_name', '$l_name', '$street', '$city', '$country', '$gender', '$screen_name')";

$result_user=pg_query($conn, $insert_user);


if($result and $result_user)
	echo "Query executed successfully";

else
	echo "Query failed";

}
else{
	echo "Wrong Registration";
}



?>

