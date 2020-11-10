<?php 
session_start();
include_once("header.php"); ?>

<?php include_once("functions.php"); ?>

<?php 
$email = $_SESSION['email'];
if (!isset($email)) {
	please_login();
	$location = "index.php";
	go_to($location);
	die();
}
?>

<p>Upload details of the textbooks you would like to sell</p>
<br>
<hr>

<form action="load.php" method="post">	
	<input type="submit" name="balance" value="Balance">
</form>

<form action="load.php"  method="post" enctype="multipart/form-data" />
<label for="Subject">Select a subject</label>
<select name="subject">
	<option value="" selected>None</option>
	<option value="Math">Math</option>
	<option value="English">English</option>
</select>

<br><br>
<label for="School">Select a school</label>
<select name="school">
	<option value="Wits" selected>Wits</option>
</select>

<br><br>
<label for="Location">Select a building </label>
<select name="location">
	<option value="Library" selected>Library</option>
</select>
<br><br>
<input type="text" name="name_of_textbook" placeholder="Name of textbook"><br><br>
<label for="Picture"><span>photo</span></label>
<input type="file" name="picture" accept="image/*"><br><br>
<input type="text" name="booknumber" value="1" hidden>
<input type="submit" value="Upload" name="bookphoto">
</form>

<form action="load.php" method="post">	
	<input type="submit" name="remove" value="Remove Upload">
</form>

<form action="load.php" method="post">	
	<input type="submit" name="see_ad" value="See Ad">
</form>

<form action="load.php" method="post">	
	<input type="submit" class="logout" name="logout" value="Logout">
</form>


<script type="text/javascript">
	if ( window.history.replaceState ) {
		window.history.replaceState( null, null, window.location.href );
	}
</script>
<?php include_once("footer.php"); ?>

