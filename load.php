<?php include_once("header.php"); ?>

<?php include_once("functions.php"); ?>

<?php if (isset($_POST['signup'])) {
	$email = post_check("email");
	$password = post_check("password");
	$confirmpassword = post_check("confirmpassword");
	$number = post_check("number");
	// echo "$email<br>$password<br>$confirmpassword<br>$number";
	$table = "accounts";
	$dbname = "proteas";
	create_row($conn,$dbname,$table,"email","$email");
	update_info($conn,$dbname,$table,"security_key",$password,"$email");
	update_info($conn,$dbname,$table,"number",$number,"$email");
	exit("<br>done");
}

 if (isset($_POST['login'])) {
	$email = post_check("email");
	$password = post_check("password");
	// echo "$email<br>$password";
	exit("<br>done");
}

include_once("footer.php"); 