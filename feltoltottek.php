<?php
	include('db.php');
	
	echo "<html><head></head><body>";
	
	echo "<table width='100%'><tr><td style='vertical-align:top;'>";
	echo "<table width='100%' align='center' style='text-align:center'><tr><th>Gyártmányok</th></tr>";
	$sql = $mysqli->query("SELECT * FROM types WHERE src = '' ORDER BY name");
	while($rows = $sql->fetch_array(MYSQLI_ASSOC)) {
		echo "<tr><td>".$rows["name"]."</td></tr>";
	}
	echo "</table></td><td style='vertical-align:top;'>";
	
	echo "<table width='100%' align='center' style='text-align:center'><tr><th>Típusok</th></tr>";
	$sql = $mysqli->query("SELECT * FROM semitypes WHERE src = '' ORDER BY name");
	while($rows = $sql->fetch_array(MYSQLI_ASSOC)) {
		echo "<tr><td>".$rows["name"]." (".$rows["parent"].")</td></tr>";
	}
	echo "</table></td></tr></table>";
	
	echo "</body></html>";
?>