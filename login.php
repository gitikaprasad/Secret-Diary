<?php
	ob_start();
	session_start();		
	$error="";
	$pwd="";	
	
	if($_GET['logout']==1)
	{
		session_destroy();
		//unset($_SESSION);
		//$_SESSION['id']="";
		setcookie("id","",time()-60*60);
		$_COOKIE['id']="";

	}	
	else if((array_key_exists('id',$_SESSION) AND $_SESSION['id']) OR (array_key_exists('id',$_COOKIE) AND $_COOKIE['id']))
	{
		header("Location:diary.php");
	}

	if(array_key_exists("submit",$_POST))
	{
		include("connection.php");
		$query="SELECT id,password FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";
		$result=mysqli_query($link,$query);
		if(mysqli_num_rows($result) == 0)
		{
			$error="This email address does not have any account. Please <a href='signupform.php'>Sign Up</a>";
		}
		else if (mysqli_num_rows($result) == 1)
		{
			$row=mysqli_fetch_array($result);
			$pwd=md5(md5($row['id']).$_POST['password']);
			if ($row['password'] == mysqli_real_escape_string($link,$pwd))
			{
				$_SESSION['id']=$row['id'];
				if($_POST['stayloggedin'])
					setcookie('id',$row['id'],time()+60*60*24*5);
			header("Location:diary.php");
			}
			else 
			{
				$error="Password doesn't match";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="login.css">
  </head>
   <body>
 
    <div class="container">
    <div id="top"><h1 class="toptext">Secret Diary</h1>
	<p class="toptext"> Store your thoughts permanently and securely.</p>
	<p class="toptext">Interested? <a href="signupform.php">Sign up</a> now.</p>
	<?php
	
		if($error)
		{
			echo'<p class="errormsg">'.$error.'</p>';
			
		}
		
	?>
	<form method="post">
	
  <div class="form-group">
    <label for="email">Email address&nbsp;<span class="superscript">*</span></label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" >
	<div id="emailmsg" class="errormsg"></div>
	
  </div>
  <div class="form-group">
    <label for="password">Password&nbsp;<span class="superscript">*</span></label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
	<div id="passwordmsg" class="errormsg"></div>
	
  </div>
  
  <div><input type="checkbox" name="stayloggedin" value=1>&nbsp;<span id="check">Stay logged in</span></div>
  
  
  <button type="submit" class="btn btn-primary" id="submit" name="submit">Login</button>
</form>
	</div>
	<?php
 include("footer.php");
?>
   
<script type="text/javascript">
	$("form").submit(function(e){
	var iserror=0;
	var errormsg="";
		if($("#email").val()=="")
		{
			errormsg="<span class='superscript'>*</span>Email address cannot be empty";
			iserror=1;
			$("#emailmsg").html(errormsg);
			$("#emailmsg").show();
			$("#email").css("background-color","#29F6D4");
		}
		else
		{
			$("#emailmsg").hide();
			$("#email").css("background-color","white");
			
		}
		
		iserror=0;
		if($("#password").val()=="")
		{
			errormsg="<span class='superscript'>*</span>Password cannot be empty";
			iserror=1;
			$("#passwordmsg").html(errormsg);
			$("#passwordmsg").show();
			$("#password").css("background-color","#29F6D4");
		}

		else 
		{
			$("#passwordmsg").hide();
			$("#password").css("background-color","White");
		}
		
		
	if(iserror==1)
	{
		e.preventDefault();
	}		
		
		
	});

</script>