<?php
    include('db.php');
    error_reporting(E_ALL);
	
	$get_info = $mysqli->query("SELECT * FROM info");			
	$info = $get_info->fetch_array(MYSQLI_ASSOC);
?>

<html>
    <head>
		<title>2betű4szám</title>
		<link rel="x-icon" src="icon.jpg">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){				
				$(".span-stype").css("display", "none");
				$(".span-plate").css("display", "none");
				$(".plateimg").css("display", "none");
				
				$(".search-for-plate-tr").hide();
				
				$(".plate-td").mouseover(function() {
					var id = $(this).attr("id");
					$("#" + id + "span").css("color", "black");
				});	
				$(".plate-td").mouseout(function() {
					var id = $(this).attr("id");
					$("#" + id + "span").css("color", "white");
				});	
				
				$(".span-type").click(function(){
					var id = $(this).attr("id");
					if($(this).hasClass("opened")) {
						$(".span-stype-"+id).css("display", "none");
						$(this).removeClass("opened");
					}else{
						$(".span-stype-"+id).css("display", "block");
						$(this).addClass("opened");
					}
				});
				
				$(".span-stype").click(function(){
					var id = $(this).attr("id");
					var content = $(".plate-"+id).html();
					$(".td-content").html(content);
				});
				
				$(".plate").mouseover(function(event) {
					var x = event.pageX;
					var y = event.pageY;
					var bela = ".image-"+$(this).attr("id");
					$(bela).css("display", "block");
					$(bela).css("position","absolute");
					$(bela).offset({top: y+5, left: x+10})
				});
				
				$(".plate").mouseout(function() {
					var bela = ".image-"+$(this).attr("id");
					$(bela).css("display", "none");
					$(bela).css("width","128");
				});				
				
                $(".tabla tr td").mouseover(function(){
                    $(".tabla tr td span#s"+$(this).attr('id')).css("color","black");
                });
                $(".tabla tr td").mouseout(function(){
                    $(".tabla tr td span#s"+$(this).attr('id')).css("color","white");
                });
                
                $("input").change(function(){
                    $(".search_input").attr("maxlength","150");
                    $(".search_input").attr("placeholder","Keresés...");
                });
                
                $("#radio3").change(function(){
                    if($("#radio3").prop("checked")){
                        $(".search_input").attr("maxlength","2");
                        $(".search_input").val("");
                        $(".search_input").attr("placeholder","Írj be 2 karaktert...");
                    }       
                });
				
				$(".plate-td").mousemove(function(event) {
					var x = event.pageX;
					var y = event.pageY;
					var bela = ".div-plate"+$(this).attr("id");
					$(bela).show();
					$(bela).css("position","absolute");
					$(bela).offset({top: y+5, left: x+10})
				});
				
				$(".plate-td").mouseout(function() {
					var bela = ".div-plate"+$(this).attr("id");
					$(bela).hide();
					$(bela).css("width","128");
				});
				
				//last 10
				$(".lastten-click").mousemove(function(event) {
					var x = event.pageX;
					var y = event.pageY;
					$(".lastten").show();
					$(".lastten").css("position","absolute");
					$(".lastten").offset({top: y+5, left: x-220})
				});
				
				$(".lastten-click").mouseout(function() {
					$(".lastten").hide();
					$(".lastten").css("width","200");
				});
				
				$(".search-for-plate").click(function(){
					if($(".search-for-plate-tr").hasClass("disabled")) {
						$(".search-for-plate-tr").show(1500);
						$(".search-for-plate-tr").removeClass("disabled");
					} else {
						$(".search-for-plate-tr").hide(1500);
						$(".search-for-plate-tr").addClass("disabled");
					}
				});
				
				$(".search-for-plate-input").on('keypress',function(e) {
					if(e.which == 13) {
						var bela = $(".search-for-plate-input").val();
						$.get("getplate.php", { plate: bela }, function(data) {
							if(data != "can't find") {
								window.location.href = data;
							} else {
								alert('Nincs ilyen rendszám az adatbázisban!');
							}
						});
					}
				});
				
				/*$(".search-for-plate-input").keypress(function(event) {
					alert("szia");
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13') {
						//alert($(".search-for-plate-input").val());
						//var bela = $(".search-for-plate-input").val();
						$.get("getplate.php", plate: bela, function(data) {
							if(data != "can't find") {
								window.location.href = data;
							} else {
								alert('Nincs ilyen rendszám az adatbázisban!');
							}
						});
					}
				});*/
            });
        </script>
    </head>
    <body>
		<table class="title-table">
			<tr>
                <td>
                    <?php 
                        $sql_get_plates = $mysqli->query("SELECT id, plate FROM cars ORDER BY id DESC"); 
                        $szam = $sql_get_plates->num_rows; 
                        $rows = $sql_get_plates->fetch_array(MYSQLI_ASSOC);
                        
                        $tipus = $mysqli->query("SELECT type FROM cars GROUP BY type ORDER BY COUNT(type) DESC LIMIT 1");
                        $altipus = $mysqli->query("SELECT type, semitype FROM cars GROUP BY semitype ORDER BY COUNT(semitype) DESC LIMIT 1");
                        $tipusr = $tipus->fetch_array(MYSQLI_ASSOC);
                        $altipusr = $altipus->fetch_array(MYSQLI_ASSOC);
                        
                        $legnepszerubb = 0;
                        $legnepszerubb_komb = null;
                        $abc = "ABCDEFGHIJKLMNOPRSTUVXYZ";
                        
                        for($x = 0; $x < strlen($abc); $x++) {
                            for($y = 0; $y < strlen($abc); $y++) {
                                $query = $mysqli->query("SELECT id FROM cars WHERE plate LIKE '". $abc[$x] . $abc[$y] ."-%'");
                                if($query->num_rows > $legnepszerubb) {
                                    $legnepszerubb = $query->num_rows;
                                    $legnepszerubb_komb = $abc[$x].$abc[$y];
                                }
                            }
                        }
                    ?>
                    <div style="background: rgba(0,0,0,0.2); border-radius: 5px; box-shadow: 2px 2px 2px white; padding: 10px 10px;">
                        <span class="search">Rendszámok száma: <span style="color:red"><?php echo $szam; ?></span> darab</span><br><br>
                        <span class="search">Leggyakoribb gyártmány: <?php echo "<a href='index.php?search=3'><span style='color:red'>".$tipusr["type"] . "</span></a>"; ?><br><br>
                        <span class="search">Leggyakoribb típus: <?php echo "<a href='index.php?search=3'><span style='color:red'>". $altipusr["type"] . " " . $altipusr["semitype"] ."</span></a>"; ?><br><br>
                        <span class="search">Utoljára feltöltött rendszám: <?php echo "<a href='profile.php?id=".$rows["id"]."'><span style='color:red'>" . $rows["plate"] . "</span></a>"; ?></span><br><br>
                        <span class="search">Legnépszerűbb kombináció: <?php echo "<span style='color:red'>" . $legnepszerubb_komb . " (". $legnepszerubb .")</span></a>"; ?></span>
                    </div>
                </td>
				<td>
                    <center><a href="index.php"><img width="1200" src="2b4szujlogo.jpg"></a></center>
				</td>
                <td>
                </td>
			</tr>
            <tr>
                    <td colspan="3">
                        <nav class="index-menu">
                            <a title="Keresés rendszám alapján"><img class="search-for-plate" src="search.png" width="64"></a>
                            <a title="Kapcsolat" href="index.php?search=4"><img src="ikon1.png" width="64"></a>
                            <a title="Keresés" href="index.php?search=1"><img src="ikon2.PNG" width="64"></a>
                            <a title="Gyártmánykeresés" href="index.php?search=3"><img src="ikon3.PNG" width="64"></a>
                            <a title="Random rendszám" href="profile.php?id=rand"><img src="ikon4.PNG" width="64"></a>
                            <a title="Állami rendszámok" href="index.php?search=spec&miszerint=Állami&order=plate"><img src="ikon5.PNG" width="64"></a>
                            <a title="Ideiglenes" href="index.php?search=spec&miszerint=Ideiglenes&order=plate"><img src="ikon9.PNG" width="64"></a>
                            <a title="Próba rendszámok" href="index.php?search=spec&miszerint=Próba&order=plate"><img src="ikon6.png" width="64"></a>
                            <a title="Vám" href="index.php?search=spec&miszerint=Vám&order=plate"><img src="ikon7.png" width="64"></a>
                            <a title="Zoll" href="index.php?search=spec&miszerint=Zoll&order=plate"><img src="ikon8.png" width="64"></a>
                            <a class="lastten-click"><img src="last10.png" width="64"></a>
							
							<?php 
							$q = $mysqli->query("SELECT plate, type, semitype FROM cars ORDER BY id DESC LIMIT 10");
							echo "<div class='div-plates lastten' style='display: none;font-weight: normal;background: darkslategrey;color: white;text-shadow: 1px 1px 1px black;'>";
							while($rows = $q->fetch_array(MYSQLI_ASSOC)) {
								echo "<span class='span-divplate'><b>".$rows["plate"]."</b> ".$rows["type"]." ".$rows["semitype"]."</span><br>";
							}
							echo "</div>";
							?>
                        </nav>
                    </td>    
            </tr>
			<tr class="search-for-plate-tr disabled">
				<td>
					<span class="search">Rendszám: </span><input type="text" class="search-for-plate-input">
				</td>
				<td colspan="2">
			</tr>
			<!--<tr>
				<td style="width:25%">
				</td>
				<td style="width:50%"></td>
				<td style="width:25%">
					<ul id="menusor">
						<li><a href="#">Menü</a>
							<ul>
							  <li><a href="index.php?search=4">Kapcsolat</a></li>
							  <li><a href="index.php?search=1">Keresés</a></li>
							  <li><a href="index.php?search=3">Gyártmánykeresés</a></li>
							  <li><a href="profile.php?id=rand">Random rendszám</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>-->
		</table>
		<!--<nav class="pages-nav" style="text-align:center;">
			<?php
				/*$x = 0;
				$i = 0;
				
				for($i = 0; $i < 5; $i++){
					$x++;
					$url = $_SERVER["REQUEST_URI"];
					if(strpos($url, "page") !== FALSE){
						$url[strpos($_SERVER["REQUEST_URI"], "page")+5] = $x;
					}elseif($url != "/") $url .= "&page=".$x."";
					else $url .= "?page=".$x."";
					
					echo "<a href='".$url."'>". (($i*10000)+1) ." - ". (($i*10000)+10000) ."</a>";
					if($i+1 != intval($info["pages"])) echo " | ";
				}*/
			?>
		</nav>-->
            <?php
                $i = 1;
                $c = 0;
				
				if(isset($_GET["search"]) AND $_GET["search"] == 1) {
                    echo "<table class='tabla' align='center'>";
					$abc = "ABCDEFGHIJKLMNOPRSTUVXYZ";
					$char = "";
					for($x = 0; $x < 24; $x++){
						for($y = 0; $y < 24; $y++){
							$get = $mysqli->query("SELECT * FROM cars WHERE plate LIKE '".$abc[$x].$abc[$y]."-%'");
							$get2 = $mysqli->query("SELECT * FROM cars WHERE plate LIKE '".$abc[$x].$abc[$y]."-%' ORDER BY plate LIMIT 10");
							if($get->num_rows > 0)
                            {
                                $c++;
                                echo "<td class='plate-td' id='".$c."'><div class='tabla-div'><a href='index.php?plate=".$abc[$x].$abc[$y]."'><img src='car.png' width='64'><br><span id='s".$c."'>".$abc[$x].$abc[$y]." (".$get->num_rows.")</a></span></div></td>";
                                echo "<div class='div-plates div-plate".$c."' id='".$abc[$x].$abc[$y]."' style='display: none;background: darkslategrey;color: white;font-weight: bold;text-shadow: 1px 1px 1px black;'>";
                                while($rows = $get2->fetch_array(MYSQLI_ASSOC)) {
                                    echo "<span class='span-divplate'>".$rows["plate"]."</span><br>";
                                }
                                echo "</div>";
                                if($c%10==0) echo "</tr><tr>";
                            }
						}
					}
				}elseif(isset($_GET["search"]) AND $_GET["search"] == 3) { //gyártmánykeresés
					if(isset($_GET["page"]) AND $_GET["page"] == 2) { //tipusok
						echo "<table class='tabla' align='center'><tr>";
						$sql = $mysqli->query("SELECT semitype FROM cars WHERE type = '".$_GET["type"]."' GROUP BY semitype");
						$c = 0;
						while($rows = $sql->fetch_array(MYSQLI_ASSOC)) {
							$_sql = $mysqli->query("SELECT id, src FROM semitypes WHERE name = '".$rows["semitype"]."'");
							if($_sql->num_rows > 0) {
								$c++;
								$_rows = $_sql->fetch_array(MYSQLI_ASSOC);
								echo "<td class='plate-td' id='td".$_rows["id"]."'><div class='tabla-div'><a href='index.php?search=3&page=3&type=".$rows["semitype"]."'><img src='".$_rows["src"]."' width='90%'><br><br><span id='td".$_rows["id"]."span'>".$rows["semitype"]."</a></span><br></div></td>";
								if($c%10==0) echo "</tr><tr>";
							} 
						}
						echo "</tr></table>";
					} elseif(isset($_GET["page"]) AND $_GET["page"] == 3) { //rendszamok
						echo "<table style='text-align:center;' align='center' width='50%'>";
						echo "<tr><th>Rendszámok</th></tr>";
						
						$sql = $mysqli->query("SELECT id, plate FROM cars WHERE semitype = '".$_GET["type"]."' ORDER BY plate");
						while($rows = $sql->fetch_array(MYSQLI_ASSOC)) {
							echo "<tr><td><a href='profile.php?id=".$rows["id"]."'>".$rows["plate"]."</a></td></tr>";
						}
						
						echo "</table>";
					} else { //gyartmanyok
						echo "<center><h2>Fejlesztés alatt...</h2></center>";
						echo "<table class='tabla' align='center'><tr>";
						$sql = $mysqli->query("SELECT type FROM cars GROUP BY type");
						$c = 0;
						while($rows = $sql->fetch_array(MYSQLI_ASSOC)) {
							$c++;
							$_sql = $mysqli->query("SELECT id, src FROM types WHERE name = '".$rows["type"]."'");
							$_rows = $_sql->fetch_array(MYSQLI_ASSOC);
							echo "<td class='plate-td' id='td".$_rows["id"]."'><div class='tabla-div'><a href='index.php?search=3&page=2&type=".$rows["type"]."'><img src='".$_rows["src"]."' width='64'><br><span id='td".$_rows["id"]."span'>".$rows["type"]."</a></span></div></td>";
							if($c%10==0) echo "</tr><tr>";
						}
						echo "</tr></table>";
					}
                    /*echo "<table class='tabla' align='center'>";
					echo "<table class='tbl' width='50%'><tr><th>Gyártmányok</th><th>Rendszámok</th></tr><tr><td>";
					$get = $mysqli->query("SELECT * FROM cars GROUP BY type");
					while($rows = $get->fetch_array(MYSQLI_ASSOC))
					{
						$get_ = $mysqli->query("SELECT * FROM cars WHERE type = '".$rows["type"]."'");
						echo "<span class='span-type' id='".$rows["type"]."'><b>" . $rows["type"] . "(" . $get_->num_rows . ")" . "</b></span><br>";
						$get__ = $mysqli->query("SELECT semitype FROM cars WHERE type = '".$rows["type"]."' GROUP BY semitype");
						while($rows_ = $get__->fetch_array(MYSQLI_ASSOC))
						{
							$get___ = $mysqli->query("SELECT id, src, plate FROM cars WHERE type = '".$rows["type"]."' AND semitype = '".$rows_["semitype"]."' ORDER BY plate");
							echo "<div style='text-indent:5px;' class='span-stype span-stype-".$rows["type"]."' id='".$rows_["semitype"]."'><i>".$rows_["semitype"]." (".$get___->num_rows.")</i><br></div>";
							echo "<div class='span-plate plate-".$rows_["semitype"]."'>";
							while($rows__ = $get___->fetch_array(MYSQLI_ASSOC))
							{
								echo "<a target='a_blank' class='plate-a' href='profile.php?id=".$rows__["id"]."'><span class='plate' id='".$rows__["plate"]."'>".$rows__["plate"]."</span></a>
								<img class='plateimg image-".$rows__["plate"]."' src='".$rows__["src"]."' width='128'><br>";
							}
							echo "</div>";
						}
					}
					echo "</td><td valign='top' class='td-content'></td></table>";*/
                }elseif(isset($_GET["search"]) AND $_GET["search"] == "spec") { //speciális rendszámok
                    $var = $_GET["miszerint"];
                    if(($var != "Állami" AND $var != "Ideiglenes" AND $var != "Vám" AND $var != "Zoll" AND $var != "Próba") OR ($_GET["order"] != "plate" AND $_GET["order"] != "id DESC")){
                        die("Az SQL injection nem vicces!");
                    }
					echo "<table class='tbl' width='50%'>
                            <tr><td></td>
                                <td style='padding-left:150px;'>
                                    <a href='index.php?search=spec&miszerint=".$_GET["miszerint"]."&order=plate'><span class='span-type'>ABC sorrend</span></a> / 
                                    <a href='index.php?search=spec&miszerint=".$_GET["miszerint"]."&order=id DESC'><span class='span-type'>Legfrissebb</span></a><br><br><br><br>
                                </td>
                            </tr>
                            <tr><th colspan='2'>Rendszámok</th></tr>";
					if($var == "Vám") $get = $mysqli->query("SELECT * FROM cars WHERE format = '".$_GET["miszerint"]."' ORDER BY RIGHT(plate, 2)");
					else $get = $mysqli->query("SELECT * FROM cars WHERE format = '".$_GET["miszerint"]."' ORDER BY ".$_GET["order"]."");
					while($rows = $get->fetch_array(MYSQLI_ASSOC))
					{
                        echo "<tr><td colspan='2' class='span-type'><b><a href='profile.php?id=".$rows["id"]."'>".$rows["plate"]."</a></b> ".$rows["type"]." ".$rows["semitype"]."</td></tr>";
					}
					echo "</table>";
                }elseif(isset($_GET["search"]) && $_GET["search"] == 4) { //kapcsolat
                  ?><center>
                       <h1 class="search">
                           Ha rendszámot szeretnél küldeni, vagy bármi észrevételed, ötleted támadna, írj nekünk!<br>   <br>
                           <img align="absmiddle" src="email.png" width="64"> info@ketbetunegyszam.hu<br>
                           <img align="absmiddle" src="fb.png" width="64"> <a href="http://www.facebook.com/ketbetunegyszam"> ketbetunegyszam</a>
                        </h1>
                    </center><?php
				}else {
                    echo "<table class='tabla' align='center'>";
					if(isset($_GET["plate"])) {
                        echo "<center><div class='pages-div'>";
                        for($q = 0; $q < 10; $q++) {
                            $plate_nums = $mysqli->query("SELECT id FROM cars WHERE plate LIKE '".$_GET["plate"]."-%' AND num > ". ($q*1000+1) ." AND num < ". ($q*1000+1000) ."");
                            $plate_nums_n = $plate_nums->num_rows;
                            echo "<span class='pages-div-span'><a href='index.php?plate=".$_GET["plate"]."&page=".($q*1000+1)."'>".($q*1000+1)." - ".($q*1000+1000)." (".$plate_nums_n.")</a>";
                            if($q != 9) echo "     |     ";
                            echo "</span>";
                        }
                        echo "</div></center>";
                        $i = 1;
                        $p = 1;
                        if(isset($_GET["page"])) {
                            $p = intval($_GET["page"]);
                            $i = intval($_GET["page"]);
                        }
                        for($i; $i <= $p+999; $i++) {
							$sql = $mysqli->query("SELECT * FROM cars WHERE num = ".$i." AND plate LIKE '".$_GET["plate"]."-%'");
							$rows;
							if($sql->num_rows != 0) $rows = $sql->fetch_array(MYSQLI_ASSOC);
							if($sql->num_rows == 0 OR $rows["plate"] == "N/A") {
								$c++;
								echo "<td id='".$i."'><div class='tabla-div' style='background: darkgrey'><img src='car.png' width='64'><br><span id='s".$i."'>".$i."</span></div></td>";
								if($c%10==0) echo "</tr><tr>";
							}else{
								$c++;
								echo "<td id='".$i."'><div class='tabla-div'><a href='profile.php?id=".$rows["id"]."'><img src='".$rows["src"]."' width='64'><br><span id='s".$i."'>".$rows["plate"]."</span></a></div></td>";
								if($c%10==0) echo "</tr><tr>";
							}
						}
						
					}else{ ?>
                        <center>
                            <h1 class="search" style="font-weight:bold; font-size: 25px;">Üdvözlünk az oldalon!</h1>

                            <h3 class="search"><i>Célunk hazánk összes 1957 és 1989 között kiadott, két betű és négy szám kombinációjú rendszámát összegyűjteni vizuális formában.
                            Ez körülbelül 4.800.000 rendszámot jelent. Bár erről a számról pontos adatok nincsenek, az biztos, hogy egy élethosszig tartó project lesz. 
                            Amennyiben segítenéd a gyűjtést, és van a birtokodban olyan fotó, amelyet szívesen látnál a gyűjteményben, kérlek vedd fel velünk a kapcsolatot!</i></h3>
                        </center><?php
					}
				}
            ?>
        </table>
		<!--<nav class="pages-nav" style="text-align:center;">
			<?php
				/*$x = 0;
				$i = 0;
				
				for($i = 0; $i < 5; $i++){
					$x++;
					$url = $_SERVER["REQUEST_URI"];
					if(strpos($url, "page") !== FALSE){
						$url[strpos($_SERVER["REQUEST_URI"], "page")+5] = $x;
					}elseif($url != "index.php") $url .= "&page=".$x."";
					else $url .= "?page=".$x."";
					
					echo "<a href='".$url."'>". (($i*10000)+1) ." - ". (($i*10000)+10000) ."</a>";
					if($i+1 != intval($info["pages"])) echo " | ";
				}*/
			?>
		</nav>-->
    </body>
</html>