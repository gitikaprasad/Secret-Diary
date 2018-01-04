<?php
	session_start();
	$content="";
	if(array_key_exists("id",$_COOKIE) && $_COOKIE['id'])
	{
		$_SESSION['id']=$_COOKIE['id'];
	}
	if(array_key_exists("id",$_SESSION) && $_SESSION['id'])
	{
		//echo "logged in <a href='login.php?logout=1'><span class='n' color='green'>log out</span></a>";
		include("connection.php");
		$query="SELECT name, diary FROM users where id=".$_SESSION['id']." LIMIT 1";
		$result=mysqli_query($link,$query);
		$row=mysqli_fetch_array($result);
		$content=$row['diary'];		
	}
	else 
	{
		header("Location:login.php");
	}
	if(array_key_exists("submit",$_POST))
	{
		header("Location:login.php?logout=1");
	}
	
?>
<?php include("header.php");
?>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Secret Diary of <span class="n" color='green'><?php echo $row['name'] ?></span></a>

 <form class="form-inline my-2 my-lg-0" method="post">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" id="logout">Logout</button>
  </form>
</nav>
<div class="container-fluid">
	<textarea id="diary" class="form-control"><?php echo $content?></textarea>
</div>

<?php include("footer.php");
?>
<script type="text/javascript">

	$('#diary').bind('input propertychange', function() {
		$.ajax
		({
			method: "POST",
			url: "updateDatabase.php",
			data: { content: $("#diary").val() }
		});
	});
</script>