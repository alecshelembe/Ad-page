<?php include_once("header.php"); ?>
<body class="animate__animated animate__fadeIn">
	<h1>Proteas</h1>
	<p>Login</p>
	<form action="load.php" method="post">
		<input type="text" placeholder="Email" name="email">
		<input type="text" name="password" placeholder="Password">
		<input type="submit" name="login" value="Enter">
	</form>
	<p>Sign up</p>
	<form action="load.php" method="post">
		<input type="text" placeholder="Email" name="email">
		<input type="text" name="password" placeholder="Password">
		<input type="text" name="number" placeholder="Number">
		<input type="text" name="confirmpassword" placeholder="Confirm Password">
		<input type="submit" name="signup" value="Enter">
	</form>
<?php include_once("footer.php"); ?>