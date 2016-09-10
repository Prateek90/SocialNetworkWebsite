<?php

	session_start();

    include_once("connectdb.php");
	
    if(isset($_POST["name"]) and isset($_POST["password"])){
        $u_name = $_POST["name"];
    
        $pass = $_POST["password"];
		
		$_SESSION["u_name"]=$u_name;
    

    $query="Select * from \"Assignment\".password where u_name='$u_name' and password='$pass';";

    $result=pg_query($conn,$query);

    if(pg_num_rows($result)){
        //include_once("displaydiary.php");
		header("Location:displaydiary.php");
    }
    else{
        echo "Wrong username or password";
		//include("initialpage.html");
		header("initialpage.html");
    }
	}
	
	else{
		echo "Wrong username or password";
		//include("initialpage.html");
		header("initialpage.html");
	}

?>