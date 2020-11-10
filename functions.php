<?php
// sever
$dbsevername = "localhost";
$dbusername = "id14954189_protea";
$dbpassword = "REh2[L~gIUZ<$<lI";
$dbname = "id14954189_proteas";

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

function nothing() {

	echo("<script type=\"text/javascript\">
		alert(\"Nothing here\");
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
		alert(\"The name of an input has already been used.\");
		</script>");
	redirect_back();
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

function image_size() {

	echo("<script type=\"text/javascript\">
		alert(\" Image size too big\");
		</script>");
	redirect_back();
	die();
}

function photo_format() {

	echo("<script type=\"text/javascript\">
		alert(\" Please upload .jpeg/.gif/ .png/ .tif picture less than 2MB\");
		</script>");
	redirect_back();
	die();
}

function saved() {

	echo("<script type=\"text/javascript\">
		alert(\"Saved\");
		</script>");
	die();
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

	// die("$query");

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

	   //die("$query");

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));


}

function create_user($varconn,$dbname,$table,$row_title,$info){

	$query = "CREATE TABLE `$dbname`.`$table` ( `$row_title` VARCHAR(200) NOT NULL ) ENGINE = InnoDB;";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn)); 

	$query = "SELECT * FROM `accounts`;";

	$result = mysqli_query($varconn, $query);
	//die("$query");

	$row = mysqli_num_rows($result);
	if ($row > 50) {
		die("Please return after 24 hours. System under review");
	}

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
	

	if ($active == "review" ){
		die("Account under review");
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

function create_textbook_profile($varconn,$dbname,$table,$row_title,$info){

	$query = "CREATE TABLE `$dbname`.`$table` ( `$row_title` VARCHAR(200) NOT NULL ) ENGINE = InnoDB;";

	//die("$query");

	$result = mysqli_query($varconn, $query); 

	check_if_exists($varconn,$dbname,$table,$row_title,$info);

	check_if_exists($varconn,$dbname,$table,"ticket",$info);

	insert_info($varconn,$dbname,$table,$row_title,$info);

	add_row($varconn,"proteas","textbooks","school","email");
	add_row($varconn,"proteas","textbooks","textbook_name","email");
	add_row($varconn,"proteas","textbooks","textbook_photo","email");
	add_row($varconn,"proteas","textbooks","textbook_subject","email");
	add_row($varconn,"proteas","textbooks","price","email");
	add_row($varconn,"proteas","textbooks","location","email");
	add_row($varconn,"proteas","textbooks","ticket","email");

}

function remove($varconn,$dbname,$table,$row_title,$info){

	$query = "DELETE FROM `$table` WHERE `$table`.`$row_title` = '$info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	//die("$query");

}

function remove_photo($varconn,$dbname,$table,$row_title,$info){

	$query = "SELECT `textbook_photo`,`textbook_subject` FROM `$table` WHERE `$row_title` = '$info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));
	
	$row = mysqli_num_rows($result);
	if ($row == 0) {
		redirect_back();
		nothing();
		die();
	}


	while ($row = mysqli_fetch_assoc($result))
	{ 
		$textbook_subject = $row['textbook_subject'];
		$textbook_photo = $row['textbook_photo'];
	}

	unlink("$textbook_subject/$textbook_photo");

}

function create_balance_profile($varconn,$dbname,$table,$row_title,$info){


	$query = "CREATE TABLE `$dbname`.`$table` ( `$row_title` VARCHAR(200) NOT NULL ) ENGINE = InnoDB;";

	//die("$query");

	$result = mysqli_query($varconn, $query); 


	$query = "SELECT * FROM $table WHERE $row_title = '$info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	$row = mysqli_num_rows($result);
	if ($row == 1) {

		$row = mysqli_fetch_assoc($result);
		$amount = $row['amount'];
		$coins = $row['coins'];

		$answer = "R: $amount <br><br> Coins: $coins ";

		return $answer;

		die();
		
	}

	check_if_exists($varconn,$dbname,$table,$row_title,$info);

	insert_info($varconn,$dbname,$table,$row_title,$info);

	add_row($varconn,"proteas","balance","amount","email");

	add_row($varconn,"proteas","balance","coins","email");

}

function see_ad($varconn,$dbname,$table,$row_title,$info){

	$email = $_SESSION['email'];

	$query = "SELECT * FROM $table WHERE $row_title = '$info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	$row = mysqli_num_rows($result);
	if ($row == 0) {
		redirect_back();
		nothing();
		die();
	}

	$row = mysqli_fetch_assoc($result);
	$email = $row['email'];
	$ticket = $row['ticket'];
	$location = $row['location'];
	$price = $row['price'];
	$textbook_subject = $row['textbook_subject'];
	$textbook_photo = $row['textbook_photo'];
	$textbook_name = $row['textbook_name'];
	$school = $row['school'];
	$price = $row['price'];

	echo "<h5>School: $school</h5><br>";

	echo "<h5>Name: $textbook_name</h5><br>";

	echo "<h5>Price: $price</h5><br>";

	echo "<h5>Meet at: $location</h5><br>";

	echo "<h5>Ticket: $ticket</h5><br><br>";

	echo "<div style=\"text-align: center;\">
	<img src=\"$textbook_subject/$textbook_photo\" style=\"border-radius:5px;\" max width=\"300px\">
	</div>";



}