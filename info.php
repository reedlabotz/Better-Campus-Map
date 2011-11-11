<?php
require("head.php");
require('database.php');
$id = mysql_real_escape_string($_GET['id']);

$query = "select * from buildings WHERE id='$id'";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_ASSOC);
mysql_free_result($result);
$today = getdate();

$dow = $today['wday'];
$dows = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
?>
   <div class="left">
      <p class="name"><?= $row['name'] ?></p>
		<p class="address"><?= $row['address'] ?></p>
		<p class="phone"><?= $row['phone'] ?></p>
		<p class="hours">
			<? 
			for($i=0;$i<7;$i++){
				if($i == $dow){
					echo "<strong>";
				}
				echo $dows[$i].": ".$row["hours_".$i];
				if($i == $dow){
					echo "</strong>";
				}
				if($i != 6){
					echo "<br>\n";
				}
			} 
			?>
		</p>
		<p class="directions"><a href="http://maps.google.com/maps?daddr=<?= urlifyAddress($row['address']); ?>">Google Maps Directions</a> | <a href="http://www.cumtd.com/maps-and-schedules/bus-stops/search?query=<?= urlifyAddress($row['address']); ?>">CUMTD Directions</a></p>
   </div>
   <div class="right">
	   <div id="container">
			<div id="controls">
				<img src="images/buttons/plusButton.png" width="25" height="26" alt="PlusButton" id="zoomInBtn"><br>
				<img src="images/buttons/minusButton.png" width="25" height="26" alt="MinusButton" id="zoomOutBtn">
			</div>
   		<div id="content">
				<?
					$query = "SELECT x,y,width,height,id FROM buildings WHERE x IS NOT NULL";
					$result2 = mysql_query($query);
					while($building = mysql_fetch_array($result2, MYSQL_ASSOC)){
						?>
						<a href="info.php?id=<?= $building['id']; ?>" style="position:absolute;top:<?= $building['y']; ?>px;left:<?= $building['x']; ?>px;width:<?= $building['width']; ?>px;height:<?= $building['height']; ?>px;text-decoration:none;">&nbsp;</a>
						<?
					}
					mysql_free_result($result);
				
				?>
   			
   		</div>
   	</div>
		<div id="mapOptions">
			<div id="interior">
				<div id="elevator"></div>
				<div id="restroom"></div>
				<div id="food"></div>
				<div class="clear"></div>
			</div>
			<div id="exterior">
				<div id="bike"></div>
				<div id="bus"></div>
				<div id="door"></div>
				<div id="parking"></div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	
	<!-- Create Scroller, bind UI layer and mouse/touch events -->
	<script src="scripts/ui.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- Custom rendering code -->
	<script type="text/javascript">

		// Initialize layout
		var container = document.getElementById("container");
		var content = document.getElementById("content");

		content.style.width = contentWidth + "px";
		content.style.height = contentHeight + "px";


		// Generate content
		var size = 200;
		var frag = document.createDocumentFragment();
		for (var row=0;row<11; row++) {
			for (var col=0; col<12; col++) {
				elem = document.createElement("div");
				//elem.style.backgroundColor = row%2 + col%2 > 0 ? "#ddd" : "";
				elem.style.backgroundImage="url('images/maps/maps_"+row+"_"+col+".jpg')";
				elem.style.width = cellWidth + "px";
				elem.style.height = cellHeight + "px";
				elem.style.display = "inline-block";
				elem.innerHTML = "&nbsp;";
				frag.appendChild(elem);
			}
		}
		content.appendChild(frag);

		
		
		// DOM based rendering (Use 3D when available)
		var render;
		if (zynga.common.Style.property("perspective")) {
			render = function(left, top, zoom) {
				zynga.common.Style.set(content, "transform", "translate3d(" + (-left) + "px," + (-top) + "px,0) scale(" + zoom + ")");
			};
		} else {
			render = function(left, top, zoom) {
				zynga.common.Style.set(content, "transform", "translate(" + (-left) + "px," + (-top) + "px) scale(" + zoom + ")");
			};
		}
		
		scroller.zoomTo(1.8);
		scroller.scrollTo(<?= $row['x']+800; ?>, <?= $row['y']; ?>);
	</script>
<?php
require("foot.php");
function urlifyAddress($address){
	$address = str_replace("<br />"," ",$address);
	return urlencode($address);
}
?>
