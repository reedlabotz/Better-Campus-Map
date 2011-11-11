<?php
require("database.php");
$id = mysql_real_escape_string($_GET['id']);
$e = mysql_real_escape_string($_GET['e']);
$r = mysql_real_escape_string($_GET['r']);
$f = mysql_real_escape_string($_GET['f']);
$floor = mysql_real_escape_string($_GET['floor']);
?>
<div class="interiorHolder" style="position:relative;">
	<?
	$query = "SELECT * FROM building_infos WHERE building_id=$id AND floor=$floor";
	$result2 = mysql_query($query);
	while($thing = mysql_fetch_array($result2, MYSQL_ASSOC)){
		$x = $thing['x'];
		$y = $thing['y'];
		
		if($id == 291){
			$x = $x/2;
			$y = $y/2;
		}else if($id == 113){
			if($floor == 0){
				$x = $x*(500/599);
				$y = $y*(500/599);
				
			}else if($floor == 1){
				$x = $x*(500/914);
				$y = $y*(500/914);
			}else if($floor == 2){
				$x = $x*(500/1116);
				$y = $y*(500/1116);
			}else if($floor == 3){
				$x = $x*(500/584);
				$y = $y*(500/584);
			}
		}
		?>
		
		
		<div style="position:absolute;top:<?= $y; ?>px;left:<?= $x; ?>px;">
			<?
			if($thing['type'] == "E" && $e == "true"){
				echo '<img src="images/icons/ElevatorIcon.png" width="25" class="elevatorIcon">';
			}else if($thing['type'] == "S" && $e == "true"){
				echo '<img src="images/icons/StairIcon.png" width="25" class="elevatorIcon">';
			}else if($thing['type'] == "R" && $r == "true"){
				echo '<img src="images/icons/RestroomIcon.png" width="25" class="restroomIcon">';
			}else if($thing['type'] == "F" && $f == "true"){
				echo '<img src="images/icons/FoodIcon.png" width="25" class="foodIcon">';
			}
			?>
		</div>
		<?
	}
	
	?>
	<img src="images/maps/<?= $id ?>/<?= $floor ?>.png" width="500" alt="0">
</div>