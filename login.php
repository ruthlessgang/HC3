<?php 
error_reporting(0);
## error_reporting(E_ALL);
require 'storage.php';
require 'core/init.php';
$general->logged_in_protect();
if (empty($_POST) === false)
{	$username = strip_tags(addslashes(trim($_POST['username']))); 
	$password = strip_tags(addslashes(trim($_POST['password']))); 
	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'Sorry, but we need your username and password.';
	} else if ($users->user_exists($username) === false) {
		$errors[] = 'Sorry, that username doesn\'t exists. Please try again.';
	} 
	else
	{	$login = $users->login($username, $password);
		if ($login === false) {
			$errors[] = 'Sorry, that username/password is invalid. Please try again.';
		}else if (!$users->email_confirmed($username)){
			$errors[] = 'Sorry, your account is locked. Please contact Administrator.';
		}else {
			$_SESSION['loginid'] =  $login;
			$users->log_users($login,'Login to Helpdesk System');
			echo $login;
			header('location: home.php');
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login HC3</title>
	<link rel="icon" href="https://storage.googleapis.com/portalhc-statics-1/images/hc3favicon.ico" type="image/x-icon">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================
	<link rel="stylesheet" type="text/css" href="css/util.css">-->
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('https://storage.googleapis.com/portalhc-statics-1/images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login" class="login100-form validate-form" method="post">
					<span class="login100-form-logo1">
						<!--<i class="zmdi zmdi-landscape"></i>
						<img src="https://storage.googleapis.com/portalhc-statics-1/images/logo.png" height="40" width="40">  -->
					</span>
					
					<span class="login100-form-logo">
						<!--<i class="zmdi zmdi-landscape"></i> -->
						<img src="https://storage.googleapis.com/portalhc-statics-1/images/cs.png" height="140" width="140">
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						HC3 Login Admin
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<div>
						<?php 
							if(empty($errors) === false){
								echo '<p class="errormsg">' . implode('</p><p class="errormsg">', $errors) . '</p>';	
							}
						?>
					</div>
					<!--
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					-->
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<!--<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a> -->
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>
