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

$floors = split(",",$row['floors']);
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
			<div id="interiorMapOverlay">
			</div>
			<div id="controls">
				<div id="exteriorControls">
					<img src="images/buttons/plusButton.png" width="25" height="26" alt="PlusButton" id="zoomInBtn"><br>
					<img src="images/buttons/minusButton.png" width="25" height="26" alt="MinusButton" id="zoomOutBtn">
				</div>
				<div id="interiorControls">
					<?
					for($i=0;$i<count($floors);$i++){
						echo "<div class='floorButton'>".$floors[$i]."</div>";
					}
					?>
				</div>
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
				
				?>
   			<?
					$query = "SELECT * FROM map_elements";
					$result2 = mysql_query($query);
					while($thing = mysql_fetch_array($result2, MYSQL_ASSOC)){
						?>
						<div class="icon" style="position:absolute;top:<?= $thing['y']-10; ?>px;left:<?= $thing['x']-15; ?>px;text-decoration:none;">
						<?
							if($thing['type'] == "B"){
								echo '<img src="images/icons/BikeIcon.png" width="25" alt="BikeIcon" class="bikeIcon">';
							}else if($thing['type'] == "T"){
								echo '<img src="images/icons/BusIcon.png" width="25" alt="BusIcon" class="busIcon">';
								echo "<div class='infoBox'><p>".$thing['details']."</p></div>";
							}else if($thing['type'] == "D"){
								echo '<img src="images/icons/DoorIcon.png" width="25" alt="DoorIcon" class="doorIcon">';
							}else if($thing['type'] == "P"){
								echo '<img src="images/icons/ParkingIcon.png" width="25" alt="ParkingIcon" class="parkingIcon">';
								echo "<div class='infoBox'><p><strong>".$thing['name']."</strong></p><p>".$thing['details']."</p></div>";
							}
						?>	
						</div>
						<?
					}
				
				?>
   		</div>
   	</div>
		<div id="mapOptions">
			<div id="tabs">
				<div class="tab selected" id="ext"><a href="javascript:showExterior();">Exterior</a></div>
				<div class="tab" id="int"><a href="javascript:showInterion(<?= $id; ?>);">Interior</a></div>
				<div class="clear"></div>
			</div>
			<div id="interiorOptions">
				<div id="elevator" class="button"></div>
				<div id="restroom" class="button"></div>
				<div id="food" class="button"></div>
				<div class="clear"></div>
			</div>
			<div id="exteriorOptions">
				<div id="bike" class="button"></div>
				<div id="bus" class="button"></div>
				<div id="door" class="button"></div>
				<div id="parking" class="button"></div>
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
		
		var choosenBuilding;
		var choosenFloor;
		
		function loadFloor(){
			var e = $("#elevator").hasClass("selected");
			var r = $("#restroom").hasClass("selected");
			var f = $("#food").hasClass("selected");
			$.get("interior.php?id="+choosenBuilding+"&floor="+choosenFloor+"&e="+e+"&r="+r+"&f="+f,function(data){
				$("#interiorMapOverlay").html(data);
			});
		}
		
		function showInterion(building){
			hideExterior();
			$("#interiorOptions").show();
			$("#interiorMapOverlay").show();
			$("#interiorControls").show();
			$("#int").addClass("selected");
			choosenBuilding = building;
			choosenFloor = 1;
			$(".floorButton").removeClass("selected");
			$(".floorButton").each(function(){
				if($(this).html() == "1"){
					$(this).addClass("selected");
				}
			});
			loadFloor();
		}
		
		function hideExterior(){
			$(".parkingIcon").hide();
			$(".bikeIcon").hide();
			$(".busIcon").hide();
			$(".doorIcon").hide();
			$("#ext").removeClass("selected");
			$("#exteriorControls").hide();
			$("#exteriorOptions").hide();
		}
		
		function showExterior(){
			hideInterior();
			$("#ext").addClass("selected");
			$("#exteriorControls").show();
			$("#exteriorOptions").show();
		}
		
		function hideInterior(){
			$("#int").removeClass("selected");
			$("#interiorMapOverlay").hide();
			$("#interiorControls").hide();
			$("#interiorOptions").hide();
		}
		
		function loadExteriorElements(){
			if($("#door").hasClass("selected")){
				$(".doorIcon").show();
			}else{
				$(".doorIcon").hide();
			}
			
			if($("#parking").hasClass("selected")){
				$(".parkingIcon").show();
			}else{
				$(".parkingIcon").hide();
			}
			
			if($("#bike").hasClass("selected")){
				$(".bikeIcon").show();
			}else{
				$(".bikeIcon").hide();
			}
			
			if($("#bus").hasClass("selected")){
				$(".busIcon").show();
			}else{
				$(".busIcon").hide();
			}
		}
		
		$(document).ready(function(){
			$(".button").click(function(){
				$(this).toggleClass("selected");
				
				if($(this).attr('id') == "elevator" || $(this).attr('id') == "food" || $(this).attr('id') == "restroom"){
					loadFloor();
				}else{
					loadExteriorElements();
				}
				
				console.log("."+$(this).attr('id') +"Icon");
				if($(this).hasClass("selected")){
					$("."+$(this).attr('id') +"Icon").effect("pulsate",{ times:2 },300);
				}
			});
			
			$(".floorButton").click(function(){
				$(".floorButton").removeClass("selected");
				$(this).addClass("selected");
				choosenFloor = $(this).html();
				loadFloor();
			});
			
			$(".icon .parkingIcon").hover(function(){
				$(this).parent().children(".infoBox").show();
			},function(){
				$(this).parent().children(".infoBox").hide();
			});
			
			$(".icon .busIcon").hover(function(){
				$(this).parent().children(".infoBox").show();
			},function(){
				$(this).parent().children(".infoBox").hide();
			});
		});
	</script>
<?php
require("foot.php");
function urlifyAddress($address){
	$address = str_replace("<br />"," ",$address);
	return urlencode($address);
}
?>
