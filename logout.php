<?php

session_start();

include_once("connectdb.php");

pg_close($conn);

session_destroy();



header("Location:initialpage.html");
exit();

?>