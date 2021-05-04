<?php
    include('db.php');
	session_start();
    error_reporting(E_ALL);

    if(!isset($_GET["id"])) header("location: index.php");

	$sql_t = $mysqli->query("SELECT id FROM cars");
	$max_plate = $sql_t->num_rows;

	if($_GET["id"] == "rand") $sql = $mysqli->query("SELECT * FROM cars ORDER BY RAND() LIMIT 1");
    else $sql = $mysqli->query("SELECT * FROM cars WHERE id = ".$_GET["id"]."");
    
	if($sql->num_rows == 0) die("<center><h1 style='color: red; margin-top: 20%;'>Nincs ilyen rendszám az adatbázisban!</h1></center>");
	
	$rows = $sql->fetch_array(MYSQLI_ASSOC);
?>

<html>
    <head>
		<title>Adatlap</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body style="text-align:left;">
        <table style="margin: 0 auto; margin-top: 100px; border-collapse: collapse;" width="912" class="profile_table">
            <tr>
                <td style="width:512px">
                    <img src="<?php echo $rows["src"]; ?>" width="512"><br>
					<center>
						<?php
							$get_cimke = $mysqli->query("SELECT * FROM cimke_auto WHERE carid = ".$rows["id"]."");
							while($cr = $get_cimke->fetch_array(MYSQLI_ASSOC)) {
								$get_cname = $mysqli->query("SELECT name FROM cimkek WHERE id = ".$cr["cimkeid"]."");
								$gcn = $get_cname->fetch_array(MYSQLI_ASSOC);
								echo "#".$gcn["name"]." ";
							}
						?>
					</center>
                </td>
				<?php
				if(isset($_SESSION["logged"]) AND $_SESSION["logged"] == 1) { ?>
					<form action="editprofile.php?id=<?php echo $_GET["id"]; ?>" method="post">
						<td id="data-td">
							<p class="search">Rendszám: <input type="text" class="search_input" name="plate" value="<?php echo $rows["plate"]; ?>"></p>
							<p class="search">Gyártmány: <input type="text" class="search_input" name="type" value="<?php echo $rows["type"]; ?>"></p>
							<p class="search">Típus: <input type="text" class="search_input" name="semitype" value="<?php echo $rows["semitype"]; ?>"></p>
							<p class="search">Forrás: <input type="text" class="search_input" style="height:100px;" name="source" value="<?php echo $rows["source"]; ?>"></p>
							<p class="search">Eredeti kép linkje: <input type="text" class="search_input" name="originalsrc" value="<?php echo $rows["originalsrc"]; ?>"></p>
							<p class="search" style="height:100px">Megjegyzés: <input type="text" class="search_input" style="height:100px;" name="description" value="<?php echo $rows["description"]; ?>"></p>
							<p class="search">(Sorszám: <input type="num" class="search_input" style="width: 50px;" name="num" value="<?php echo $rows["num"]; ?>">)</p>
							<p class="search"><input type="submit" class="search_input" name="submit" value="Módosítás"></p>
						</td>
					</form><?php
				}else{ ?>
					<td id="data-td">
						<p class="search">Rendszám: <?php echo $rows["plate"]; ?></p>
						<p class="search">Gyártmány: <?php echo $rows["type"]; ?></p>
						<p class="search">Típus: <?php echo $rows["semitype"]; ?></p>
						<p class="search">Forrás: <?php echo $rows["source"]; ?></p>
						<p class="search">Eredeti kép linkje: <button class="img-btn" onclick="location.href='<?php echo $rows["originalsrc"]; ?>'">KATTINTS</button></p>
						<p class="search" style="height:100px;" title="<?php echo $rows["description"] ?>">Megjegyzés: <?php echo $rows["description"]; ?></p>
					</td><?php
				} ?>
            </tr>
            <tr>
                <td colspan="2">
					<br><br><br>
					<center>
						<button class="navigate-btn" onclick="location.href='profile.php?id=<?php echo (($_GET["id"] == 1) ? $max_plate : $_GET["id"]-1); ?>'">Előző</button>
						<button class="navigate-btn" onclick="location.href='index.php'">Vissza a főoldalra</button>
						<button class="navigate-btn" onclick="location.href='profile.php?id=<?php echo (($_GET["id"] == $max_plate) ? "1" : $_GET["id"]+1); ?>'">Következő</button>
					</center>
				</td>
            </tr>
        </table>
    </body>
</html>