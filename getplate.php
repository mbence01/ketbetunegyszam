<?php
	include('db.php');
	$q = $mysqli->query("SELECT id FROM cars WHERE plate = '".$_GET["plate"]."'");
	
	if($q->num_rows == 0) {
		echo "can't find";
	} else {
		$rows = $q->fetch_array(MYSQLI_ASSOC);
		echo "profile.php?id=".$rows["id"]."";
	}
?>