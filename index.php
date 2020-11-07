<?php include_once("header.php");
if (isset($_COOKIE['email'])) {
  $email = $_COOKIE['email'];
} else {
  $email = "";
}
?>
<body class="animate__animated animate__fadeIn">
	<header>
		<nav>
			<h1>Proteas</h1><h2>textbooks</h2>
		</nav>
	</header>
	<br>
	<h5>Login</h5>
	<form action="load.php" method="post">
		<input type="text" placeholder="Email" name="email" value="<?php echo("$email"); ?>"><br>
		<input type="text" name="password" placeholder="Password"><br>
		<input type="submit" name="login" value="Enter"><br>
	</form>
	<h5>Sign up</h5>
	<form action="load.php" method="post">
		<input type="text" placeholder="Email" name="email"><br>
		<input type="text" placeholder="Name" name="name"><br>
		<input type="text" name="password" placeholder="Password"><br>
		<input type="text" name="number" placeholder="Number"><br>
		<input type="text" name="confirmpassword" placeholder="Confirm Password"><br>
		<input type="submit" name="signup" value="Enter">
	</form>
	<?php include_once("footer.php"); ?>