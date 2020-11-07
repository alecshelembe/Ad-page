<?php
// sever
$dbsevername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "proteas";

$conn = mysqli_connect($dbsevername, $dbusername, $dbpassword);

mysqli_select_db($conn, $dbname);

function sanitizeString($var) {    
	if (get_magic_quotes_gpc())

		$var = stripsloashes($var);   
	$var = htmlentities($var);    
	$var = strip_tags($var); 

	if (strlen($var) > 400 ) {
		die("Charachter break fatal error"); 
	}
	$var = addslashes($var);
	return $var; 
}

function redirect_back() {
	echo("<script type=\"text/javascript\">
		window.history.go(-1);
		</script>");
}

function confirm_match($var,$var2) {
	if ($var !== $var2) {
		echo("<script type=\"text/javascript\">
			alert(\"Does not match.\");
			</script>");
		redirect_back();
		die();
	}
}

function please_login() {

	echo("<script type=\"text/javascript\">
		alert(\"Session expired. Please Login\");
		</script>");
}

function go_to($var){

	echo("<script type=\"text/javascript\">
		window.location.replace(\"$var\");
		</script>");
}

function logged_in(){

	echo("<script type=\"text/javascript\">
		alert(\"Logged in\");
		</script>");
}

function no_account_exits() {

	echo("<script type=\"text/javascript\">
		alert(\"Email not in use. \");
		window.history.go(-1);
		</script>");
}

function wrongpassword() {

	echo("<script type=\"text/javascript\">
		alert(\"Wrong password\");
		window.history.go(-1);
		</script>");
}

function info_exits() {

	echo("<script type=\"text/javascript\">
		alert(\"Account details already in use.\");
		</script>");
	$location = "index.php";
	go_to($location);
	die();
}

function check_if_empty($var) {
	if (empty($var)) {
		message_information_missing();
		redirect_back();
		die();
	}
}

function message_information_missing() {
	echo("<script type=\"text/javascript\">
		alert(\"Information missing\");
		</script>");
}

function post_check($var){
	if (!isset($_POST[$var])) {
		message_information_missing();
		die("$var not found");
	}
	$var = sanitizeString($_POST[$var]);
	check_if_empty($var);
	return $var;
}

function insert_info($varconn,$dbname,$table,$row_title,$info){
	
	$query = "INSERT INTO `$table` (`$row_title`) VALUES ('$info');";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	// echo "$query";

}

function check_if_exists($varconn,$dbname,$table,$row_title,$info){

	$query = "SELECT `$row_title` FROM `$table` WHERE `$row_title` = '$info';";

	// echo "$query";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	$row = mysqli_num_rows($result);
	if ($row > 0) {
		info_exits();
		die();
	}


}


function update_info($varconn,$dbname,$table,$row_title,$info,$email){

	$query = "UPDATE `$table` SET `$row_title` = '$info' WHERE `$table`.`email` = '$email';";

	 // echo "$query";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));


}

function create_user($varconn,$dbname,$table,$row_title,$info){

	$query = "CREATE TABLE `$dbname`.`$table` ( `$row_title` VARCHAR(200) NOT NULL ) ENGINE = InnoDB;";

	$result = mysqli_query($varconn, $query); 

	add_row($varconn,"proteas","accounts","security_key","email");

	add_row($varconn,"proteas","accounts","number","email");

	add_row($varconn,"proteas","accounts","active","email");

	add_row($varconn,"proteas","accounts","sign_up_date","email");

	add_row($varconn,"proteas","accounts","name","email");

	add_row($varconn,"proteas","accounts","last_seen","email");

	add_row($varconn,"proteas","accounts","login_times","email");

	check_if_exists($varconn,$dbname,$table,$row_title,$info);

	insert_info($varconn,$dbname,$table,$row_title,$info);

// echo "$query";

}

function add_row($varconn,$dbname,$table,$row_title,$old_row_title){

	$query ="ALTER TABLE `$table` ADD `$row_title` VARCHAR(200) NOT NULL AFTER `$old_row_title`;";

	if ($row_title == "sign_up_date") {
		$query = "ALTER TABLE `$table` ADD `$row_title` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `$old_row_title`;";
	}

	$result = mysqli_query($varconn, $query); 

	// echo "$query";
}

function pair_for_login($varconn,$table,$email,$email_info,$security_key,$security_key_info) {

	$query = "SELECT * FROM $table WHERE $email = '$email_info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	$row = mysqli_num_rows($result);
	if ($row == 0) {
		no_account_exits();
		exit();
	}

	$security_key = "";

	while ($row = mysqli_fetch_assoc($result)) {
		$security_key = $row['security_key'];
	}
	
	if ($security_key !== $security_key_info ){
		wrongpassword();
		exit();
	}


	$query = "SELECT * FROM $table WHERE $email = '$email_info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));


	$active = "";
	$login_times="";
	
	while ($row = mysqli_fetch_assoc($result)) {
		$active = $row['active'];
		$login_times = $row['login_times'];
	}

	$login_times++;
	

	if ($active == "no" ){
		// die("Account under review");
	}

	$query = "SELECT * FROM $table WHERE $email = '$email_info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	while ($row = mysqli_fetch_assoc($result))
	{ 

		$email = $_SESSION['email'] = $row['email'];
		$name = $_SESSION['name'] = $row['name'];
	}

	$dbname = "proteas";

	update_info($varconn,$dbname,$table,"login_times",$login_times,$email);

	$datetime = date("Y-m-d H:i:s");

	update_info($varconn,$dbname,$table,"last_seen",$datetime,$email);

	setcookie("email","$email",time()+31556926 ,'/');

	logged_in();

	$location = "profile-page.php";
	go_to($location);
	die();

}

function logout() {
	session_destroy();
	$location = "index.php";
	go_to($location);
	die();
}