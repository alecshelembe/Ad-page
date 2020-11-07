<?php 
session_start();
include_once("header.php"); ?>

<?php include_once("functions.php"); ?>

<?php if (isset($_POST['signup'])) {
	$email = post_check("email");
	$password = post_check("password");
	$confirmpassword = post_check("confirmpassword");
	$number = post_check("number");
	$name = post_check("name");
	$active = "no";
	// echo "$email<br>$password<br>$confirmpassword<br>$number";
	$table = "accounts";
	$dbname = "proteas";
	$login_times = "0";
	create_user($conn,$dbname,$table,"email","$email");
	update_info($conn,$dbname,$table,"security_key",$password,"$email");
	update_info($conn,$dbname,$table,"number",$number,"$email");
	update_info($conn,$dbname,$table,"active",$active,"$email");
	update_info($conn,$dbname,$table,"name",$name,"$email");
	update_info($conn,$dbname,$table,"login_times",$login_times,"$email");
	setcookie("email","$email",time()+31556926 ,'/');
	exit("<br>done");
}

 if (isset($_POST['login'])) {
	$email = post_check("email");
	$security_key = post_check("password");
	// echo "$email<br>$password";
	$table = "accounts";
	pair_for_login($conn,$table,"email",$email,"security_key",$security_key);

	exit("<br>done");
}

if (isset($_POST['logout'])) {
	logout();
}

include_once("footer.php"); 