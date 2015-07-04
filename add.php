<?php
   	include("connect.php");
   	
   	$link=Connection();

	$pwd=$_POST["pwd"];
	$temp0=$_POST["temp0"]/10;  //transform to float
	$temp1=$_POST["temp1"]/10;  //transform to float
	$humidity=$_POST["hum"];
if($pwd=="password")
{
$query = "INSERT INTO `data` (`temperature0`, `temperature1`,`Humidity`) 
		VALUES ('".$temp0."','".$temp1."','".$humidity."')"; 
   	
   	mysql_query($query,$link);
	mysql_close($link);
	}

	header("Location: index.php");
?>
