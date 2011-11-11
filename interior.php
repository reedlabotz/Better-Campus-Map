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
		?>
		<div style="position:absolute;top:<?= $thing['y']; ?>;left:<?= $thing['x']; ?>;">
			<?
			if($thing['type'] == "E" && $e == true){
				echo '<img src="images/icons/ElevatorIcon.png" width="25" alt="ElevatorIcon">';
			}else if($thing['type'] == "S" && $e == true){
				echo '<img src="images/icons/StairIcon.png" width="25" alt="StairIcon">';
			}else if($thing['type'] == "R" && $r == true){
				echo '<img src="images/icons/RestroomIcon.png" width="25" alt="RestroomIcon">';
			}else if($thing['type'] == "F" && $f == true){
				echo '<img src="images/icons/FoodIcon.png" width="25" alt="FoodIcon">';
			}
			?>
		</div>
		<?
	}
	mysql_free_result($result);
	
	?>
	<img src="images/maps/<?= $id ?>/<?= $floor ?>.png" alt="0">
</div>