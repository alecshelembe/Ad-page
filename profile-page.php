<?php include_once("header.php"); ?>

<?php include_once("functions.php"); ?>

<?php 
session_start();
$email = $_SESSION['email'];
if (!isset($email)) {
	please_login();
	$location = "index.php";
	go_to($location);
	die();
}
?>
<form action="load.php" method="post">	
	<input type="submit" class="logout" name="logout" value="Logout">
</form>

<?php include_once("footer.php"); ?>

