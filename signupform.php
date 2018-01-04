<?php
	$msg="";
	$pwd="";
	$error="";
	if($_POST)
	{
	$link=mysqli_connect("shareddb-f.hosting.stackcp.net","users-20-32345479","CFsgvfVhi01Q","users-20-32345479");
	if(mysqli_connect_error())
		die("There was an error connecting to the database");
	
	$query="SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";
	$result=mysqli_query($link,$query);

	if(mysqli_num_rows($result) > 0)
			{
				$error="The given email address '<u>".$_POST['email']."'</u> already exists in the database.";
			}
	else
	{
		
		$query="INSERT INTO users (email,password,name) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."','".mysqli_real_escape_string($link,$_POST['name'])."')";

		if (mysqli_query($link,$query))
		{
			$pwd=md5(mysqli_insert_id($link));
			$pwd.=mysqli_real_escape_string($link,$_POST['password']);
			$pwd=md5($pwd);
			$query ="UPDATE users SET password='".$pwd."' WHERE id =". mysqli_insert_id($link)." LIMIT 1";
			if (mysqli_query($link,$query))
				$msg = "Congratulations!! You have signed up successfully.";
			else 
				$msg="sorry";
		}
		else 
			$msg="Sorry.There was a problem signing you up - please try again.";
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
	<link rel="stylesheet" type="text/css" href="signupform.css">
  </head>
  <body>
    <div class="container">
    <div id="top"><h1>New User! Sign Up</h1>
	<?php 
		if($error)
		{
			echo'<p class="errormsg">'.$error.'</p>';
			
		}
		else if($msg)
		{
			echo'<p class="successmsg">'.$msg.'</p>';
			echo'<a href="login.php">Login </a>now';
			
		}
	?>
	<form method="post">
	<div class="form-group">
    <label for="name">Name&nbsp;<span class="superscript">*</span></label>
    <input type="text" id="name" class="form-control" placeholder="Name" name="name">
	<div id="namemsg" class="errormsg"></div>
  </div>
  <div class="form-group">
    <label for="email">Email address&nbsp;<span class="superscript">*</span></label>
    <input type="email" id="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" name="email" >
	<div id="emailmsg" class="errormsg"></div>
	
  </div>
  <div class="form-group">
    <label for="password">Password&nbsp;<span class="superscript">*</span></label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
	<div id="passwordmsg" class="errormsg"></div>
  </div>
  <div class="form-group">
    <label for="confirmpassword">Confirm Password&nbsp;<span class="superscript">*</span></label>
    <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password">
	<div id="confirmpasswordmsg" class="errormsg"></div>
  </div>
  
  
  
  <button type="submit" class="btn btn-primary" id="submit">Submit</button>
</form>
	</div>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
   <script type="text/javascript" src="jquery-3.2.1.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
<script type="text/javascript">
	$("form").submit(function(e){
	var iserror=0;
	var errormsg="";
		if($("#name").val()=="")
		{
			errormsg="<span class='superscript'>*</span>Name cannot be empty";
			iserror=1;
			$("#namemsg").html(errormsg);
			$("#namemsg").show();
			$("#name").css("background-color","#29F6D4");
		}
		else
		{
			$("#namemsg").hide();
			$("#name").css("background-color","white");
			
		}
		iserror=0;
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

		else if($("#password").val()!=$("#confirmpassword").val())
		{
			$("#passwordmsg").hide();
			errormsg="<span class='superscript'>*</span>Password is not matching";
			iserror=1;
			$("#confirmpasswordmsg").html(errormsg);
			$("#confirmpasswordmsg").show();
			$("#password").css("background-color","#29F6D4");
			$("#confirmpassword").css("background-color","#29F6D4");
		}
		else
		{
			$("#confirmpasswordmsg").hide();
			$("#password").css("background-color","White");
			$("#confirmpassword").css("background-color","White");
			
		}
		
	if(iserror==1)
	{
		e.preventDefault();
	}		
		
		
	});

</script>