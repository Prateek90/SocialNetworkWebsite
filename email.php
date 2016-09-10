<?php

session_start();

$email_from = "prateekchourasia17@gmail.com";

$email_subject = "New Friend Request";

$name=$_SESSION["u_name"];

$email_body = "You have received a new friend request from $name .";

//$email=$_POST["email"];

$visited=$_SESSION["visited"];

$visit=$visited."@nyu.edu";

$header="FROM:$email_from";

mail($visit, $email_subject, $email_body, $header);

header("Location:visitor_diary.php?visited=".$visited);
?>