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
   		<div id="content"></div>
   	</div>
	</div>
	<div class="clear"></div>
	<div id="settings">
		<div><label for="scrollingX">ScrollingX: </label><input type="checkbox" id="scrollingX" checked/></div>
		<div><label for="scrollingY">ScrollingY: </label><input type="checkbox" id="scrollingY" checked/></div>
		<div><label for="animating">Animating: </label><input type="checkbox" id="animating" checked/></div>
		<div><label for="bouncing">Bouncing: </label><input type="checkbox" id="bouncing" checked/></div>
		<div><label for="locking">Locking: </label><input type="checkbox" id="locking" checked/></div>

		<div><label for="zooming">Zooming: </label><input type="checkbox" id="zooming" checked/></div>
		<div><label for="minZoom">Min Zoom: </label><input type="text" id="minZoom" size="5" value="0.5"/></div>
		<div><label for="maxZoom">Max Zoom: </label><input type="text" id="maxZoom" size="5" value="3"/></div>
		<div><label for="zoomLevel">Zoom Level: </label><input type="text" id="zoomLevel" size="5"/></div>
		<div><button id="zoom">Zoom to Level</button><button id="zoomIn">+</button><button id="zoomOut">-</button></div>
		
		<div><label for="scrollLeft">Scroll Left: </label><input type="text" id="scrollLeft" size="9"/></div>
		<div><label for="scrollTop">Scroll Top: </label><input type="text" id="scrollTop" size="9"/></div>
		<div><button id="scrollTo">Scroll to Coords</button></div>

		<div><button id="scrollByUp">&uarr;</button><button id="scrollByDown">&darr;</button><button id="scrollByLeft">&larr;</button><button id="scrollByRight">&rarr;</button></div>
	</div>
	
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

	</script>
<?php
require("foot.php");
function urlifyAddress($address){
	$address = str_replace("<br />"," ",$address);
	return urlencode($address);
}
?>
