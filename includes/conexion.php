<?php
	$servername = "us-cdbr-iron-east-04.cleardb.net";
	$username = "b6cc8110fbd434";
	$password = "7aee6b90";
	$dbname = "heroku_88b63e6c9aaaf78";

	// Create connection
	$conexion = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conexion) {
	    die("No pudo conectarse: " . mysqli_connect_error());
	}

?>