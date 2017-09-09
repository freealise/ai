<?php 
require("config.php");

$sql = "SELECT * FROM map_data ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql)) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"]. "<br>";
        echo "<b>" . $row["user_id"]. "</b><br>";
        echo "<span class='posttitle'>" . $row["title"]. "</span><br>";
        echo "<span class='posttext'>" . $row["text"]. "</span><br>";
        echo $row["date"]. "<br>";
        echo "<span class='post_lat'>" . $row["lat"] . "</span>, <span class='post_lng'>" . $row["lng"] . "</span><br>";
        echo $row["tags"]. "<p>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
