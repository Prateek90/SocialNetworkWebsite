<?php

$pitchure=$_SESSION["profilepic"];

$unescape=pg_unescape_bytea($pitchure);

$file_name="temp.jpg";

$img=fopen($file_name, 'wb');

fwrite($img, $unescape);

fclose($img);

?>
<html>
	<body>
		<img src="temp.jpg" alt="unable to upload picture">
	<body>
<html>