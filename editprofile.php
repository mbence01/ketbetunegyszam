<?php
	session_start();
	include('db.php');
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_SESSION["logged"]) AND $_SESSION["logged"] == 1) {
			$mysqli->query("UPDATE cars SET plate = '".$_POST["plate"]."', type = '".$_POST["type"]."', semitype = '".$_POST["semitype"]."', source = '".$_POST["source"]."', description = '".$_POST["description"]."', originalsrc = '".$_POST["originalsrc"]."', num = ".$_POST["num"]." WHERE id = ".$_GET["id"]."");
			header("location: profile.php?id=".$_GET["id"]."");
		}else {
			header("location: index.php");
		}
	}else{
		header("location: index.php");
	}

?>