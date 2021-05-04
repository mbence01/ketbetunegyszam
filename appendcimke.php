<?php
	session_start();
	include 'db.php';
	
	if(isset($_SESSION["logged"]) AND $_SERVER["REQUEST_METHOD"] == "POST") {
		$mysqli->query("INSERT INTO cimke_auto(id,carid,cimkeid) VALUES('', ".$_POST["rendszam"].", ".$_POST["cimke"].")");
		header("location: add.php");
	} else header("location: index.php");
?>