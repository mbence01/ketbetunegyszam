<?php
	include('db.php');
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$mysqli->query("UPDATE info SET cubes_in_page = ".$_POST["cube"]."");
		header("location: add.php");
	}else header("location: index.php");
?>