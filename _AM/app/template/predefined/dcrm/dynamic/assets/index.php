<!doctype html>
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
	<script src="https://s0.2mdn.net/ads/studio/Enabler.js"></script>
	<!-- ReplaceValueProcess:import -->

	<link rel="stylesheet" href="style.css">

	<script>
    <!-- ReplaceValueProcess:gsapinstance_null -->
    <!-- ReplaceValueProcess:custom-vars -->

		window.onload = function(){
  			if (Enabler.isInitialized()) {
    			enablerInitHandler();
  			} else {
    			Enabler.addEventListener(studio.events.StudioEvent.INIT, enablerInitHandler);
 			}
  		};

  		function enablerInitHandler(){
  			addListeners();

  			if (Enabler.isPageLoaded()) {
   		 		pageLoadedHandler();
  			} else {
   				Enabler.addEventListener(studio.events.StudioEvent.PAGE_LOADED, pageLoadedHandler);
  			}
  		}

  		function addListeners(){
        <!-- ReplaceValueProcess:custom-events -->
  		}


  		function pageLoadedHandler() {

 			if (Enabler.isVisible()) {
    			adVisibilityHandler();
  			} else {
    			Enabler.addEventListener(studio.events.StudioEvent.VISIBLE, adVisibilityHandler);
  			}
		}

		function adVisibilityHandler() {
			<!-- ReplaceValueProcess:loaded-script -->

		}

		function init() {
			reset();
			initObjects();
			<!-- ReplaceValueProcess:custom-script -->
      <!-- ReplaceValueProcess:custom-init -->
		}


    function reset(){
      <!-- ReplaceValueProcess:gsapinit -->
    }

    function initObjects(){
    	<!-- ReplaceValueProcess:gsapinstance -->
    	<!-- ReplaceValueProcess:gsapanimation -->
    }

    function launch(){
    	<!-- ReplaceValueProcess:gsapplay -->
    }


		<!-- ReplaceValueProcess:custom-function -->


  	</script>

</head>
<body>
	<div id="container">
		<!-- ReplaceValueProcess:content -->
	</div>
	<div id="clickThroughBtn"></div>
</body>
</html>
