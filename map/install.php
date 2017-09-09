<?php
require("config.php");

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
if (mysqli_query($conn, $sql)) {
    echo "<br>Database created successfully";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

$sql = "USE " . $dbname;
if (mysqli_query($conn, $sql)) {
    echo "<br>Database selected successfully";
} else {
    echo "<br>Error selecting database: " . mysqli_error($conn);
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS `map_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `tags` varchar(255) NOT NULL,
  `lat` float(11,6) NOT NULL,
  `lng` float(11,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lat` (`lat`),
  KEY `lng` (`lng`)
) DEFAULT CHARSET=utf8";

if (mysqli_query($conn, $sql)) {
    echo "<br>Map table data created successfully";
} else {
    echo "<br>Error creating map table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS `map_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) DEFAULT CHARSET=utf8";

if (mysqli_query($conn, $sql)) {
    echo "<br>Users table data created successfully";
} else {
    echo "<br>Error creating users table: " . mysqli_error($conn);
}

$sql = "INSERT INTO map_users (name, pass)
VALUES ('admin', 'nebenu11')";

if (mysqli_query($conn, $sql)) {
    echo "<br>Map table data updated successfully";
} else {
    echo "<br>Error updating map table: " . mysqli_error($conn);
}

$sql = "INSERT INTO map_data (user_id, title, text, date, tags)
VALUES ('0', 'Title', 'Text', NOW(), 'tag1, tag2')";

if (mysqli_query($conn, $sql)) {
    echo "<br>Users table data updated successfully";
} else {
    echo "<br>Error updating users table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
