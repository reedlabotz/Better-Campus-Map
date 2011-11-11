<?php
require("head.php");
require('database.php');
?>
   <div class="mapHolder">
	   <div id="container">
			<div id="controls">
				<table>
					<tr>
						<td></td>
						<td>
							<img src="images/buttons/NorthButton.png" width="21" height="35" alt="NorthButton" id="panN">
						</td>
						<td></td>
					</tr>
					<tr>
						<td>
							<img src="images/buttons/WestButton.png" width="35" height="21" alt="WestButton" id="panW">
						</td>
						<td></td>
						<td>
							<img src="images/buttons/EastButton.png" width="35" height="21" alt="EastButton" id="panE">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<img src="images/buttons/SouthButton.png" width="21" height="35" alt="SouthButton" id="panS">
						</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<img src="images/buttons/plusButton.png" width="25" height="26" alt="PlusButton" id="zoomInBtn"><br>
							<img src="images/buttons/minusButton.png" width="25" height="26" alt="MinusButton" id="zoomOutBtn">
						</td>
						<td></td>
				</table>
				
				
			</div>
   		<div id="content">
				<?
					$query = "SELECT x,y,width,height,id FROM buildings WHERE x IS NOT NULL";
					$result2 = mysql_query($query);
					while($building = mysql_fetch_array($result2, MYSQL_ASSOC)){
						?>
						<a href="info.php?id=<?= $building['id']; ?>" style="position:absolute;top:<?= $building['y']; ?>px;left:<?= $building['x']; ?>px;width:<?= $building['width']; ?>px;height:<?= $building['height']; ?>px;text-decoration:none;" class='buildingClickZone'>&nbsp;</a>
						<?
					}
				
				?>
   		</div>
   	</div>
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
				elem.className = "mapTile";
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
		scroller.zoomTo(.5);
	</script>
<?php
require("foot.php");
?>
