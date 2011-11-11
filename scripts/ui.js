// Settings
var contentWidth = 200*12;
var contentHeight = 200*11;
var cellWidth = 200;
var cellHeight = 200;

// Intialize layout
var container = document.getElementById("container");
var content = document.getElementById("content");
var clientWidth = 0;
var clientHeight = 0;

// Initialize Scroller
this.scroller = new Scroller(function(left, top, zoom) {
	render(left, top, zoom);	
}, {
	zooming: true
});

var rect = container.getBoundingClientRect();
scroller.setPosition(rect.left + container.clientLeft, rect.top + container.clientTop);


// Reflow handling
var reflow = function() {
	clientWidth = container.clientWidth;
	clientHeight = container.clientHeight;
	scroller.setDimensions(clientWidth, clientHeight, contentWidth, contentHeight);
};

window.addEventListener("resize", reflow, false);
reflow();

scroller.options.scrollingX = true;
scroller.options.scrollingY = true;
scroller.options.animating = true;
scroller.options.bouncing = true;
scroller.options.zooming = true;
scroller.options.minZoom = .5;
scroller.options.maxZoom = 2;


document.querySelector("#zoomInBtn").addEventListener("click", function() {
	scroller.zoomBy(1.2, true);
}, false);

document.querySelector("#zoomOutBtn").addEventListener("click", function() {
	scroller.zoomBy(0.8, true);
}, false);

/*document.querySelector("#settings #scrollByUp").addEventListener("click", function() {
	scroller.scrollBy(0, -150, true);
}, false);

document.querySelector("#settings #scrollByRight").addEventListener("click", function() {
	scroller.scrollBy(150, 0, true);
}, false);

document.querySelector("#settings #scrollByDown").addEventListener("click", function() {
	scroller.scrollBy(0, 150, true);
}, false);

document.querySelector("#settings #scrollByLeft").addEventListener("click", function() {
	scroller.scrollBy(-150, 0, true);
}, false);*/


if ('ontouchstart' in window) {

	container.addEventListener("touchstart", function(e) {
		// Don't react if initial down happens on a form element
		if (e.touches[0] && e.touches[0].target && e.touches[0].target.tagName.match(/input|textarea|select/i)) {
			return;
		}

		scroller.doTouchStart(e.touches, e.timeStamp);
		e.preventDefault();
	}, false);

	document.addEventListener("touchmove", function(e) {
		scroller.doTouchMove(e.touches, e.timeStamp, e.scale);
	}, false);

	document.addEventListener("touchend", function(e) {
		scroller.doTouchEnd(e.touches, e.timeStamp, e.scale);
	}, false);

	document.addEventListener("touchcancel", function(e) {
		scroller.doTouchEnd(e.touches, e.timeStamp, e.scale);
	}, false);

} else {

	var mousedown = false;

	container.addEventListener("mousedown", function(e) {
		if (e.target.tagName.match(/input|textarea|select/i)) {
			return;
		}
		
		scroller.doTouchStart([{
			pageX: e.pageX,
			pageY: e.pageY
		}], e.timeStamp);

		mousedown = true;
	}, false);

	document.addEventListener("mousemove", function(e) {
		if (!mousedown) {
			return;
		}

		scroller.doTouchMove([{
			pageX: e.pageX,
			pageY: e.pageY
		}], e.timeStamp);

		mousedown = true;
	}, false);

	document.addEventListener("mouseup", function(e) {
		if (!mousedown) {
			return;
		}

		scroller.doTouchEnd([{
			pageX: e.pageX,
			pageY: e.pageY
		}], e.timeStamp);

		mousedown = false;
	}, false);

	container.addEventListener("mousewheel", function(e) {
		scroller.doMouseZoom(e.wheelDelta, e.timeStamp, e.pageX, e.pageY);
	}, false);

}