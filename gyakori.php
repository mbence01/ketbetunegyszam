<?php
	include('db.php');
	
	$abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";	
	$arr[] = (array)null;
	
	for($i = 0; $i < 26; $i++) {
		for($j = 0; $j < 26; $j++) {
			$query = $mysqli->query("SELECT id FROM cars WHERE plate LIKE '".$abc[$i].$abc[$j]."-%'");
			$arr[] = array('num' => $query->num_rows, 'plate' => $abc[$i].$abc[$j]);
		}
	}
	
	usort($arr, function ($item1, $item2) {
		return $item2['num'] <=> $item1['num'];
	});

	for($i = 1; $i <= 26*26; $i++) {
		if($arr[$i]['num'] == 0) continue;
		
		echo "Rendszám: " .$arr[$i]['plate']. " (".$arr[$i]['num'].")<br>";
	}
?>