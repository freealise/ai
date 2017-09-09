<?php 
require("config.php");
header("Access-Control-Allow-Origin: $siteurl");

$q = $_REQUEST;

//form validation
//$q["user_id"] = htmlspecialchars($q["user_id"]); this goes to user registration. user_id is a number.
$q["title"] = htmlspecialchars($q["title"]);
$q["text"] = htmlspecialchars($q["text"]);

//letters separated by ", "
$q["tags"] = htmlspecialchars($q["tags"]);

/*no greater than 180 or less than -180
$q["lat"] = 
$q["lng"] = */

if ($q) {
	$sql = "INSERT INTO map_data (user_id, title, text, date, tags, lat, lng) 
			VALUES ('".$q["user_id"]."', '".$q["title"]."', '".$q["text"]."', NOW(), '".$q["tags"]."', '".$q["lat"]."', '".$q["lng"]."')";
} else {
	$sql = "";
}

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: ".$sql."<br>".mysqli_error($conn);
}

mysqli_close($conn);

?>
