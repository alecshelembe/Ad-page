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

if (isset($_POST['bookphoto'])) {

	$email = $_SESSION['email'];

	$booknumber = post_check("booknumber");
	$school = post_check("school");
	$name_of_book = post_check("name_of_textbook");
	$subject = post_check("subject");

	$dir = "$subject";

	if( is_dir($dir) === false )
	{
		mkdir($dir);
	}

	$original_file_name = $_FILES['picture']['name'];
	$file_type = $_FILES['picture']['type'];
	$name_of_picture = sanitizeString($original_file_name);

	$file_type = sanitizeString($file_type);

	if($_FILES["picture"]["size"] > 2000000) {
		image_size();
		die();
	}

	switch($_FILES['picture']['type'])
	{
		case 'image/jpeg': $extention = 'jpg'; break;
		case 'image/JPG': $extention = 'jpg'; break;
		case 'image/jpg': $extention = 'jpg'; break;
		case 'image/JPEG': $extention = 'jpg'; break;
		case 'image/gif':  $extention = 'gif'; break;
		case 'image/GIF':  $extention = 'gif'; break;
		case 'image/png':  $extention = 'png'; break;
		case 'image/PNG':  $extention = 'png'; break;
		case 'image/tif': $extention = 'tif'; break;
		case 'image/TIF': $extention = 'tif'; break;
		case 'image/tiff': $extention = 'tif'; break;
		case 'image/TIFF': $extention = 'tif'; break;
		default:	
		photo_format();
		die();	 		  

	} 

	$file_size = $_FILES['picture']['size']; 	
	$file_tem_loc = $_FILES['picture']['tmp_name'];

	if ($extention)
	{	
		$name_of_picture = "$name_of_picture";

		$file_store = "$dir/$name_of_picture";

		$table = "textbooks";
		$row_title = "email";
		$dbname = "proteas";
		
		create_textbook_profile($conn,$dbname,$table,$row_title,$email);

		move_uploaded_file($file_tem_loc, $file_store);

	}
	else
	{
		echo ("Something went wrong in Uploading your profile picture. Try a different one.");
		die();	 		  
	} 	

	redirect_back();
	saved();
	die("Done");
}

include_once("footer.php"); 