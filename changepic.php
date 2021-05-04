<?php
    session_start();
    include('db.php');

    if(isset($_SESSION["logged"])  AND $_SESSION["logged"] == 1) {
        $get_file = $mysqli->query("SELECT src FROM cars WHERE plate = '".$_POST["plate"]."'");
        if($get_file->num_rows > 0){
            $rows = $get_file->fetch_array(MYSQLI_ASSOC);
            unlink($rows["src"]);
            $target_dir = "cars/";
            $file = basename($_FILES["pic2"]["name"]);
            $complete_file_name = $target_dir . $file;
            move_uploaded_file($_FILES["pic2"]["tmp_name"],$complete_file_name);
            $mysqli->query("UPDATE cars SET src = '".$complete_file_name."' WHERE plate = '".$_POST["plate"]."'");
            echo "<script>alert('Fénykép módosítva! (".$complete_file_name.")'); window.location.href='add.php';</script>";
        } else echo "<script>alert('Nincs ilyen rendszám!'); window.location.href=history.back();</script>";
    }
?>