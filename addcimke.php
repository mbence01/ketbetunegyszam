<?php
	session_start();
	include 'db.php';
	
	if(isset($_SESSION["logged"]) AND $_SERVER["REQUEST_METHOD"] == "POST") {
		$mysqli->query("INSERT INTO cimkek(id, name) VALUES('', '".$_POST["name"]."')");
		header("location: add.php");
	}else header("location: index.php");
?>