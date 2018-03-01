<?php
/*
	This page is a self contained module to include the animated SGF LOGO with spinning globe.
	include this page. 
	Constrain the size of this with a wrapper tag. It will scale.
*/
  if(@$_GET['logo-spin']){
?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.2/d3.min.js'></script>
<script src='https://d3js.org/d3-geo.v1.min.js'></script>
<script src='https://d3js.org/topojson.v2.min.js'></script>
<?php
  }
?>
<style>
	#logo-container {
	    position: relative;
	    height: 0;
	    width: 100%;
	    padding-bottom: 100%;
	}
    .svg-element {
        position: absolute;
        left: 0;
        top: 0;
    }
    #globe {
        position: absolute;
        z-index: 1;
        width: 46%;
        height: 46%;
        top: 27.8%;
        left: 26.8%;
    }

</style>
<div id="logo-container">
	<a href="<?php echo home_url(); ?>" >
		<?php
/*SVG files are included separately so they can be commented out , reordered easily and use variations*/
			include "sgf-outer-gradient-aqua-01.svg";
			include "sgf-inner-gradient-aqua-01.svg";
			include "sgf-ring-white-01.svg";
			include "sgf-logo-shadow-01.svg";
			include "sgf-text-gradient-aqua-01.svg";
			// canvas is where animated globe loads.
       if(@$_GET['logo-spin']){
		?>
		<canvas id="globe"></canvas>
		<?php
  }
			/*Globe background default incase animated globe canvas doesn't load*/
			include "sgf-globe-01.svg";
		?>



</div>
<?php  if(@$_GET['logo-spin']){?>
	<script>
		
	//
// Creates the spinning globe in the logo.
//

// ms to wait after dragging before auto-rotating
var rotationDelay = 1000;
// scale of the globe (not the canvas element)
var scaleFactor = 0.5;
// autorotation speed
var degPerSec = 10;
// start angles
var angles = { x: -10, y: 40, z: 0};
// colors
var colorWater = '#176990';
var colorLand = '#d9eef7';
var colorGraticule = '#ccc';
var colorCountry = '#a00';


var canvas = d3.select('#globe');
var center = canvas.bounds;
var context = canvas.node().getContext('2d');
var water = {type: 'Sphere'};
var projection = d3.geoOrthographic().precision(0.1);
var graticule = d3.geoGraticule10();
var path = d3.geoPath(projection).context(context);
var v0; // Mouse position in Cartesian coordinates at start of drag gesture.
var r0; // Projection rotation as Euler angles at start.
var q0; // Projection rotation as versor at start.
var lastTime = d3.now();
var degPerMs = degPerSec / 1000;
var width, height;
var land, countries;
var countryList;
var autorotate, now, diff, roation;
var currentCountry;
//console.log("graticule", graticule, "colorGraticule", colorGraticule);

function setAngles() {
  var rotation = projection.rotate();
  rotation[0] = angles.y;
  rotation[1] = angles.x;
  rotation[2] = angles.z;
  projection.rotate(rotation);
}
function scale() {
  width = document.getElementById("logo-container").style.width;
  height = document.getElementById("logo-container").style.height;
  y = document.getElementById("globe").offsetTop*2;
  x = document.getElementById("globe").offsetLeft*2;
  
canvas.attr('width',500).attr('height', 500);
  
  projection  
    .scale(251)
    .translate([250,250]);
  
  render_logo();
}

function startRotation(delay) {
  autorotate.restart(rotate, delay || 0);
}

function stopRotation() {
  autorotate.stop();
}


function render_logo() {
  context.clearRect(0, 0, width, height);
  fill(water, colorWater);
  stroke(graticule, colorGraticule);
  fill(land, colorLand);
  if (currentCountry) {
    fill(currentCountry, colorCountry);
  }
}
function fill(obj, color) {
  context.beginPath();
  path(obj);
  context.fillStyle = color;
  context.fill();
}

function stroke(obj, color) {
  context.beginPath();
  path(obj);
  context.strokeStyle = color;
  //lat lng lines
  //context.stroke();
}

function rotate(elapsed) {
  now = d3.now();
  diff = now - lastTime;
  if (diff < elapsed) {
    rotation = projection.rotate();
    rotation[0] += diff * degPerMs;
    projection.rotate(rotation);
    render_logo();
  }
  lastTime = now;
}
function loadData(cb) {
  d3.json('https://unpkg.com/world-atlas@1/world/110m.json', function(error, world) {
    if (error) throw error;
   // d3.tsv('https://gist.githubusercontent.com/mbostock/4090846/raw/07e73f3c2d21558489604a0bc434b3a5cf41a867/world-country-names.tsv', function(error, countries) {
     if (error) throw error;
      cb(world, countries);
    });
}

setAngles();

loadData(function(world, cList) {
  land = topojson.feature(world, world.objects.land);
  window.addEventListener('resize', scale);
  scale();
  autorotate = d3.timer(rotate);
})
/**/
	</script>
<?php } ?>