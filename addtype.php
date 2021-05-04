<?php
    session_start();
    include('db.php');

    if(isset($_SESSION["logged"])  AND $_SESSION["logged"] == 1) {
		$get_file = "";
		$target_dir = "";
        if($_GET["page"] == "type") $get_file = $mysqli->query("SELECT src FROM types WHERE name = '".$_POST["plate"]."'");
		else $get_file = $mysqli->query("SELECT src FROM semitypes WHERE name = '".$_POST["plate"]."'");
        if($get_file->num_rows > 0){
            $rows = $get_file->fetch_array(MYSQLI_ASSOC);
            unlink($rows["src"]);
			
			if($_GET["page"] == "type") $target_dir = "gyartmanyok/";
			else $target_dir = "tipusok/";
			
            $file = basename($_FILES["pic2"]["name"]);
            $complete_file_name = $target_dir . $file;
            move_uploaded_file($_FILES["pic2"]["tmp_name"],$complete_file_name);
			
			if($_GET["page"] == "type") $mysqli->query("UPDATE types SET src = '".$complete_file_name."' WHERE name = '".$_POST["plate"]."'");
			else $mysqli->query("UPDATE semitypes SET src = '".$complete_file_name."' WHERE name = '".$_POST["plate"]."'");
			
            echo "<script>alert('Fénykép módosítva! (".$complete_file_name.")'); window.location.href='add.php';</script>";
        } else {
			if($_GET["page"] == "type") $target_dir = "gyartmanyok/";
			else $target_dir = "tipusok/";
			
            $file = basename($_FILES["pic2"]["name"]);
            $complete_file_name = $target_dir . $file;
            move_uploaded_file($_FILES["pic2"]["tmp_name"],$complete_file_name);
			
			if($_GET["page"] == "type") $mysqli->query("INSERT INTO types(id, name, src) VALUES('', '".$_POST["plate"]."', '".$complete_file_name."')");
			else $mysqli->query("INSERT INTO semitypes(id, name, parent, src) VALUES('', '".$_POST["plate"]."', '".$_POST["parent"]."', '".$complete_file_name."')");
			
            echo "<script>alert('Fénykép és gyártmány hozzáadva! (".$complete_file_name.")'); window.location.href='add.php';</script>";
		}
    }
?>