<?php require("config.php"); ?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<base href="<?php echo $siteurl; ?>/map/">
		<title><?php if ($siteurl=="https://m-goritskaia.rhcloud.com") {echo "Freealise";} ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="leaflet/leaflet.css">
		<link rel="stylesheet" href="leaflet/leaflet.fullscreen.css">
		<link rel="stylesheet" href="<?php if ($siteurl=='https://m-goritskaia.rhcloud.com') {echo 'freealise.css';} ?>">
		<script src="leaflet/leaflet.js"></script>
		<script src="leaflet/Leaflet.fullscreen.min.js"></script>
		<script src="leaflet/leaflet.markercluster.js"></script>
	</head>
	<body>
		<div id="main">
			<div id="header">
				<div id="title">
					<?php if ($siteurl=="https://m-goritskaia.rhcloud.com") {echo "Freealise";} ?>
				</div>
			</div>
			<div id="map"></div>
			<script src="config.js"></script>
			<script src="functions.js"></script>
			<div id="newpost">

			</div>
			<div id="des">
				<p>text</p>
			</div>
			<div id="content">
				<?php include("posts.php"); ?>
			</div>
		</div>
	</body>
<html>
