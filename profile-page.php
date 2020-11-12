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

<p>Upload information about the product you would like to sell</p>
<br>
<hr>

<form action="load.php" method="post">	
	<input type="submit" name="balance" value="Balance">
</form>

<form action="load.php"  method="post" enctype="multipart/form-data" />
<label for="catagory">Select a catagory</label>
<select name="catagory">
	<option value="" selected>None</option>
	<option value="Clothing">Clothing</option>
</select>

<br><br>
<label for="Location"></label>
<input type="text" name="location" placeholder="Address">
<br><br>

<label for="Price"></label>
<input type="text" name="price" placeholder="Price">
<br><br>

<input type="text" name="name_of_product" placeholder="Name of product"><br><br>
<label for="Picture"><span>photo</span></label>
<input type="file" name="picture" accept="image/*"><br><br>
<input type="text" name="booknumber" value="1" hidden>
<input type="submit" value="Upload" name="productphoto">
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

