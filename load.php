<?php 
session_start();
include_once("header.php"); ?>

<?php include_once("functions.php"); ?>

<?php if (isset($_POST['signup'])) {
	$email = post_check("email");
	$security_key = post_check("password");
	$confirmpassword = post_check("confirmpassword");
	$number = post_check("number");
	$name = post_check("name");
	$active = "no";
	// echo "$email<br>$security_key<br>$confirmpassword<br>$number";
	$table = "accounts";
	$dbname = "proteas";
	$login_times = "0";
	confirm_match($security_key,$confirmpassword);
	create_user($conn,$dbname,$table,"email","$email");
	update_info($conn,$dbname,$table,"security_key",$security_key,"$email");
	update_info($conn,$dbname,$table,"number",$number,"$email");
	update_info($conn,$dbname,$table,"active",$active,"$email");
	update_info($conn,$dbname,$table,"name",$name,"$email");
	update_info($conn,$dbname,$table,"login_times",$login_times,"$email");
	$datetime = date("Y-m-d H:i:s");
	update_info($conn,$dbname,$table,"last_seen",$datetime,"$email");
	setcookie("email","$email",time()+31556926 ,'/');
	pair_for_login($conn,$table,"email",$email,"security_key",$security_key);
	die("<br>Done");
}

 if (isset($_POST['login'])) {
	$email = post_check("email");
	$security_key = post_check("password");
	// echo "$email<br>$security_key";
	$table = "accounts";
	pair_for_login($conn,$table,"email",$email,"security_key",$security_key);

	die("<br>Done");
}

if (isset($_POST['logout'])) {
	logout();
}

include_once("footer.php"); 