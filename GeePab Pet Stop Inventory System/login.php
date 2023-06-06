<?php
include_once 'config/config.php';
include_once 'classes/class.user.php';

$user = new User();
if($user->get_session()){
	header("location: index.php");
}
if(isset($_REQUEST['submit'])){
	extract($_REQUEST);
	$password = md5($password); // Add MD5 encryption to the password
	$login = $user->check_login($useremail,$password);
	if($login){
		header("location: index.php");
	}else{
		?>
        <div id='error_notif'>Wrong email or password.</div>
        <?php
	}
	
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>GeePab's Pet Stop</title>
    <meta charset="UTF-8">
	<link rel="icon" type="image/x-icon" href="img/fishy.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet'>
    <link rel="stylesheet" href="css/custom.css?<?php echo time();?>">
</head>
<body>
<div id="brand-block">

<center><img id="brandfish" src="img/fishy.png"></img></center>

</div>

<!-- Login Form -->
<div id="login-block">
	<h3 style="color: white;">Please login</h3>
	<form method="POST" action="" name="login">
	<div>
		<input type="email" class="input" required name="useremail" placeholder="Valid E-mail"/>
	</div>
	<div>
		<input type="password" class="input" required name="password" placeholder="Password"/>
	</div>
	<div>
		<input id="submit" type="submit" name="submit" value="Submit"/>
	</div>
	</form>
</div>
</body>
</html>