<?php
require("head.php");
?>
   <div class="left">
      Digital Computing Laboratory
   </div>
   <div class="right">
	   <div id="container">
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
		for (var row=0;row<15; row++) {
			for (var col=0; col<11; col++) {
				elem = document.createElement("div");
				//elem.style.backgroundColor = row%2 + col%2 > 0 ? "#ddd" : "";
				elem.style.backgroundImage="url('images/maps/map_"+row+"_"+col+".jpg')";
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
?>