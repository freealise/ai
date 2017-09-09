<?php 
	$siteurl = "https://m-goritskaia.rhcloud.com";
	$servername = "54555901500446b43a0003c0-goritskaia.rhcloud.com:48056";
	$username = "admin8ckZHR8";
	$password = "XJQQ-Us96fsF";
	$dbname = "m";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "USE " . $dbname;
	if (mysqli_query($conn, $sql)) {
		echo "";
	} else {
		echo "<br>Error selecting database: " . mysqli_error($conn);
	}

?>
