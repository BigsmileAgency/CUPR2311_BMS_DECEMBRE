<!DOCTYPE html>
<html lang="<!-- ReplaceValueProcess:lang -->">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="generator" content="Powered by Big Smile Agency">
  <meta http-equiv="X-UA-Compatible" content="IE=edge<?php /*,chrome=1*/ ?>">
	<?php if($meta) { ?>
	<meta name="author" content="<!-- ReplaceValueProcess:author -->">
	<meta name="description" content="<!-- ReplaceValueProcess:description -->">
	<meta name="keywords" content="<!-- ReplaceValueProcess:keywords -->">
	<?php } ?>
	<title><!-- ReplaceValueProcess:title --></title>
  	<!-- ReplaceValueProcess:import -->
	<script>
		document.write('<script src="'+ (window.API_URL || 'https://s1.adform.net/banners/scripts/rmb/Adform.DHTML.js?bv='+ Math.random()) +'"><\/script>');
	</script>
	<style>
		<!-- ReplaceValueProcess:style -->
		<!-- ReplaceValueProcess:custom-style -->
    </style>
    
</head>

<body>
	<div id="banner">
		<div id="container">
			<!-- ReplaceValueProcess:content -->
		</div>
	</div>
	<script>
		var banner = document.getElementById('banner');
		var deltax, deltay, x, y;
		<?php //var closebutton = document.getElementById('closeButton'); //NOT NEEDED! ?>
		var clickTAGvalue = dhtml.getVar('clickTAG', '<!-- ReplaceValueProcess:clicktag -->');
		var landingpagetarget = dhtml.getVar('landingPageTarget', '_blank');
		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>
		
		<!-- ReplaceValueProcess:gsapinstance_null -->
		<!-- ReplaceValueProcess:custom-vars -->

		banner.style.width = dhtml.width + 'px';
		banner.style.height = dhtml.height + 'px';

		<?php if($testComputedStyleForFirefox) { ?>
		_interval = setInterval(function(){
            if(window.getComputedStyle(document.body) || document.defaultView.getComputedStyle(document.body)){
               clearInterval(_interval);
        <?php } ?>
               <!-- ReplaceValueProcess:loaded-script -->
        <?php if($testComputedStyleForFirefox) { ?>
            }
        }, 20);

        <?php } ?>
		
		function init(){
			instances();
			reset();
			animations();
			events();
			<!-- ReplaceValueProcess:custom-script -->
			<!-- ReplaceValueProcess:custom-init -->
		}
  		function reset(){
			<!-- ReplaceValueProcess:gsapinit -->
		}
		function instances(){
			<!-- ReplaceValueProcess:gsapinstance -->
		}

		function animations(){
			<!-- ReplaceValueProcess:gsapanimation -->
		}
		function events(){
			banner.onclick = function() {
				window.open(clickTAGvalue,landingpagetarget);
			};

			document.addEventListener('touchstart', function(event) {
			 deltax = 0;
			 deltay = 0;
			 x = event.touches[0].clientX;
			 y = event.touches[0].clientY;
			 l = event.touches.length;
			}, false);

			document.addEventListener('touchmove', function(event) {
			  event.preventDefault();
			  deltax = x - event.touches[0].clientX;
			  deltay = y - event.touches[0].clientY;
			  parent.window.scrollBy(0,deltay);  
			}, false);
	       <!-- ReplaceValueProcess:custom-events -->

	    }
		function launch(){
			<!-- ReplaceValueProcess:gsapplay -->
		}

		<!-- ReplaceValueProcess:custom-function -->

	</script>
</body>
</html>
