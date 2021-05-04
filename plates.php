<?php
	include('db.php');
	$query = $mysqli->query("SELECT plate FROM cars ORDER BY plate");
    while($rows = $query->fetch_array(MYSQLI_ASSOC)) {
        echo $rows["plate"] . "<br>";
    }
?>