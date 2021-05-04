<?php
	session_start();
	if(isset($_SESSION["logged"])){
		$_SESSION["logged"] = NULL;
		header("location: add.php");
	}else{
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if($_POST["pass"] == "NegyTizenOtosSzabalyzatiPont"){
				$_SESSION["logged"] = 1;
				header("location: add.php");
			}else{
				header("location: add.php");
			}
		}
	}
?>