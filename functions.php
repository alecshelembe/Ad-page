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
		exit("Charachter break fatal error"); 
	}
	$var = addslashes($var);
	return $var; 
}

function go_to($var){

	echo("<script type=\"text/javascript\">
		window.location.replace(\"$var\");
		</script>");
}

function info_exits() {

	echo("<script type=\"text/javascript\">
		alert(\"Already in use.\");
		</script>");
	$location = "index.php";
	go_to($location);
}

function redirect_back() {
	echo("<script type=\"text/javascript\">
		window.history.go(-1);
		</script>");
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
		exit("$var not found");
	}
	$var = sanitizeString($_POST[$var]);
	check_if_empty($var);
	return $var;
}

function check_if_exists($varconn,$dbname,$table,$row_title,$info){

	$query = "SELECT `$row_title` FROM `$table` WHERE `$row_title` = '$info';";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	$row = mysqli_num_rows($result);
	if ($row == 1) {
		info_exits();
		exit();
	}

	$query = "INSERT INTO `$table` (`$row_title`) VALUES ('$info');";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));

	// echo "$query";

}

function insert_info($varconn,$dbname,$table,$row_title,$info){

	check_if_exists($varconn,$dbname,$table,$row_title,$info);

}

function update_info($varconn,$dbname,$table,$row_title,$info,$email){

	$query = "UPDATE `$table` SET `$row_title` = '$info' WHERE `$table`.`email` = '$email';";

	// echo "$query";

	$result = mysqli_query($varconn, $query) or die(mysqli_error($varconn));


}

function create_row($varconn,$dbname,$table,$row_title,$info){

	$query = "CREATE TABLE `$dbname`.`$table` ( `$row_title` VARCHAR(200) NOT NULL ) ENGINE = InnoDB;";

	$result = mysqli_query($varconn, $query); 

	add_row($varconn,"proteas","accounts","security_key","email");

	add_row($varconn,"proteas","accounts","number","email");

	insert_info($varconn,$dbname,$table,$row_title,$info);


// echo "$query";

}

function add_row($varconn,$dbname,$table,$row_title,$old_row_title){

	$query ="ALTER TABLE `$table` ADD `$row_title` VARCHAR(200) NOT NULL AFTER `$old_row_title`;";

	$result = mysqli_query($varconn, $query); 

	// echo "$query";
}