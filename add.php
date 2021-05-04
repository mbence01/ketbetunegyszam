<?php
session_start();
include('db.php');

if(!isset($_SESSION["logged"]) OR $_SESSION["logged"] == 0){
	echo "
		<form action='login.php' method='post'>
			Jelszó: <input type='password' name='pass'> <input type='submit' value='Belép'>
		</form>
	";
}else{

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["plate"]) AND isset($_POST["id"])){
        echo "File size: " . $_FILES["pic"]["size"];
        if($_FILES["pic"]["size"] <= 125000) {
            //$abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $target_dir = "cars/";
            $file = basename($_FILES["pic"]["name"]);
            $complete_file_name = $target_dir . $file;
            move_uploaded_file($_FILES["pic"]["tmp_name"],$complete_file_name);
            $mysqli->query("INSERT INTO cars(id, num, src, plate, type, semitype, source, description, originalsrc, format) VALUES('', ".$_POST["id"].", '".$complete_file_name."', '".$_POST["plate"]."', '".$_POST["type"]."', '".$_COOKIE["semitype"]."', '".$_POST["source"]."', '".$_POST["description"]."', '".$_POST["originalsrc"]."', '".$_POST["format"]."')");
            echo "Upload completed!";
            echo $mysqli->error;
        }
        else echo " bytes. File upload failed! Max size 125 kb";
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
			$(document).ready(function(){
                $(".select-type").change(function(){
                    $(".hidden").css("display","none");
					var id = $(".select-type option:selected").attr("id");
					$("#select" + id).css("display","block");
					
                });
                $("select").change(function(){
                    if($(this).attr("name")=="semitype"){
                        /*$.ajax({
                           url:"add.php",
                          Type:'POST',
                          data:{semitype:$(this).val()},
                          success:function(response){}
                        });*/
                        document.cookie = "semitype="+$(this).val();
                    }
                });
            });
        </script>
    </head>
    <body>
        <form action="add.php" method="post" enctype="multipart/form-data">
            Formátum: 
            <select name="format" class="select-typea">
                <option selected>Standard</option>
                <option>Állami</option>
                <option>Ideiglenes</option>
                <option>Próba</option>
                <option>Vám</option>
                <option>Zoll</option>
            </select>
            Rendszám: <input type="text" name="plate"><br>
            Hanyadik hely?: <input type="number" name="id"><br>
            Gyártmány: 
			<?php
			echo "<select name='type' class='select-type'>";
			$gettypes = $mysqli->query("SELECT * FROM types ORDER BY name");
			while($rows = $gettypes->fetch_array(MYSQLI_ASSOC)) {
				echo "<option id='".$rows["id"]."'>".$rows["name"]."</option>";
			}
			echo "</select><br>";
			echo "Típus:";
			$gettypes = $mysqli->query("SELECT * FROM types ORDER BY name");
			while($rows = $gettypes->fetch_array(MYSQLI_ASSOC)) {
				echo "<select name='semitype' class='hidden' id='select".$rows["id"]."'>";
				$getstypes = $mysqli->query("SELECT * FROM semitypes WHERE parent = '".$rows["name"]."'");
				echo "<option>-----</option>";
				while($_rows = $getstypes->fetch_array(MYSQLI_ASSOC)) {
					echo "<option>".$_rows["name"]."</option>";
				}
				echo "</select>";
			}
			?>
            <br>
            Forrás: <textarea name="source"></textarea><br>
            Eredeti kép linkje: <input type="text" name="originalsrc"><br><br>
            Leírás: <textarea name="description"></textarea><br>
            Kép: <input type="file" name="pic"><br>
            <input type="submit" value="Feltöltés"><br><br><br>
        </form>
		<br><br>
		<form action="addcimke.php" method="post">
			Cimke neve: <input type="text" name="name"> <input type="submit" value="Hozzáad">
		</form>
		<br><br>
		<form action="appendcimke.php" method="post">
			<select name="rendszam">
				<?php
					$get_rendszam = $mysqli->query("SELECT id, plate FROM cars ORDER BY plate");
					while($rendszamok = $get_rendszam->fetch_array(MYSQLI_ASSOC)) {
						echo "<option value='".$rendszamok["id"]."'>".$rendszamok["plate"]."</option>";
					}
				?>
			</select>
			<select name="cimke">
				<?php
					$get_cimke = $mysqli->query("SELECT * FROM cimkek");
					while($cimkek = $get_cimke->fetch_array(MYSQLI_ASSOC)) {
						echo "<option value='".$cimkek["id"]."'>".$cimkek["name"]."</option>";
					}
				?>
			</select>
			<input type="submit" value="Módositás">
		</form>
		<br><br>
		<form action="edit.php" method="post">
		<?php
			$get_cubes = $mysqli->query("SELECT cubes_in_page FROM info");
			$rows = $get_cubes->fetch_array(MYSQLI_ASSOC);
		?>
			Kockák száma: <input type="number" value="<?php echo $rows["cubes_in_page"]; ?>" name="cube"><br>
			<input type="submit" value="Mehet">
		</form>
		<br><br><br>
		<form action="delete.php" method="post">
			Rendszám törlése: <input type="text" name="plate"><br>
			<input type="submit" value="Mehet">
		</form>
        <br><br><br>
        <form action="changepic.php" method="post" enctype="multipart/form-data">
            Rendszámhoz tartozó fénykép módosítása: <input type="text" name="plate"><br>
            <input type="file" name="pic2">
            <input type="submit" value="Mehet">
        </form>
		<br><br><br>
        <form action="addtype.php?page=type" method="post" enctype="multipart/form-data">
            Gyártmányhoz tartozó kép módosítása / Gyártmány hozzáadása: <input type="text" name="plate"><br>
            <input type="file" name="pic2">
            <input type="submit" value="Mehet">
        </form>
        <br><br><br>
        <form action="addtype.php?page=semitype" method="post" enctype="multipart/form-data">
            Típushoz tartozó kép módosítása / Típus hozzáadása: <input type="text" name="plate"><br>
			Gyártmány: <input type="text" name="parent"><br><br>
            <input type="file" name="pic2">
            <input type="submit" value="Mehet">
        </form>
		<button onClick="location.href='login.php'">Kilépés</button>
    </body>
 </html><?php
} ?>