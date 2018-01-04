<?php
	session_start();
	if(array_key_exists("content",$_POST))
	{
		include("connection.php");
		$query="UPDATE users SET diary='".mysqli_real_escape_string($link,$_POST['content'])."' where id=".$_SESSION['id']." LIMIT 1";
		$result=mysqli_query($link,$query);
	}
?>


