<!doctype html>
<html lang="<!-- ReplaceValueProcess:lang -->">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="ad.size" content="width=<!-- ReplaceValueProcess:width -->,height=<!-- ReplaceValueProcess:height -->">
  <meta name="generator" content="Powered by Big Smile Agency">
	<meta http-equiv="X-UA-Compatible" content="IE=edge<?php /*,chrome=1*/ ?>">
	<?php if($meta) { ?>
	<meta name="author" content="<!-- ReplaceValueProcess:author -->">
	<meta name="description" content="<!-- ReplaceValueProcess:description -->">
	<meta name="keywords" content="<!-- ReplaceValueProcess:keywords -->">
	<?php } ?>
	<title><!-- ReplaceValueProcess:title --></title>

  <script type="text/javascript" src="https://acdn.adnxs.com/html5-lib/1.3.0/appnexus-html5-lib.min.js"></script>
  	<!-- ReplaceValueProcess:import -->
    <style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
  	<script>
  		var clickTag = "<!-- ReplaceValueProcess:clicktag -->";
		<!-- ReplaceValueProcess:gsapinstance_null -->
		<!-- ReplaceValueProcess:custom-vars -->
		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php } ?>

		window.onload = function(){
			<?php if($testComputedStyleForFirefox) { ?>
			_interval = setInterval(function(){
	            if(window.getComputedStyle(document.body) || document.defaultView.getComputedStyle(document.body)){
	               clearInterval(_interval);
	        <?php } ?>
	               loaded();
	        <?php if($testComputedStyleForFirefox) { ?>
	            }
	        }, 20);
	        <?php } ?>
		};

		function loaded(){
			<!-- ReplaceValueProcess:loaded-script -->
		}

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
	      <!-- ReplaceValueProcess:custom-events -->
	    }
		function launch(){
			<!-- ReplaceValueProcess:gsapplay -->
		}

		<!-- ReplaceValueProcess:custom-function -->




  	</script>
</head>
<body>
  <div id="container">
    <a id="clickThroughBtn" href="javascript:void(0)" onClick="window.open(APPNEXUS.getClickTag(), '_blank');">
      <!-- ReplaceValueProcess:content -->
    </a>
	</div>
</body>
</html>
