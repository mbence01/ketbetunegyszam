<?php
	session_start();
	include('db.php');
	
	if(isset($_SESSION["logged"]) AND $_SESSION["logged"] == 1) {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$get = $mysqli->query("SELECT id FROM cars WHERE plate = '".$_POST["plate"]."'");
			if($get->num_rows > 0) {
				$mysqli->query("DELETE FROM cars WHERE plate = '".$_POST["plate"]."'");
				echo "<script>alert('Rendszám törölve!'); location.href='add.php'</script>";
			}else {
				echo "<script>alert('Nincs ilyen rendszám!'); location.href=history.back()</script>";
			}
		}else header("location: index.php");
	}else header("location: index.php");
?>