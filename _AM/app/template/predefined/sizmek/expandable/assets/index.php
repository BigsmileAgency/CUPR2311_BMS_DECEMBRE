<!doctype html>
<html lang="<!-- ReplaceValueProcess:lang -->">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge<?php /*,chrome=1*/ ?>">
	<?php if($meta) { ?>
	<meta name="author" content="<!-- ReplaceValueProcess:author -->">
	<meta name="description" content="<!-- ReplaceValueProcess:description -->">
	<meta name="keywords" content="<!-- ReplaceValueProcess:keywords -->">
	<?php } ?>
	<title><!-- ReplaceValueProcess:title --></title>
	<script>EBModulesToLoad = ['EBCMD'];</script>
    <script src="https://secure-ds.serving-sys.com/BurstingScript/EBLoader.js"></script>
  	<!-- ReplaceValueProcess:import -->
  	<style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
  	<script>
		var adDiv;
		var bannerDiv;
		var expandDiv;
		var collapseDiv;
		<!-- ReplaceValueProcess:collapse-gsapinstance_null -->
		<!-- ReplaceValueProcess:expand-gsapinstance_null -->
		<!-- ReplaceValueProcess:custom-vars -->

		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>

		function initEB(){
			<?php if($devMode) { ?>
				startAd();
			<?php } else { ?>
				if (!EB.isInitialized()){
					EB.addEventListener(EBG.EventName.EB_INITIALIZED, startAd);
				}else{
					startAd();
				}
			<?php } ?>
		}

		function startAd() {
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

		}


		function init(){
			<?php if(!$devMode) { ?>
				EB.initExpansionParams(<!-- ReplaceValueProcess:expand-offset-x -->,<!-- ReplaceValueProcess:expand-offset-y -->,<!-- ReplaceValueProcess:expand-width -->,<!-- ReplaceValueProcess:expand-height -->);
			<?php } ?>
   			adDiv = document.getElementById("ad");
			bannerDiv = document.getElementById("banner");
			expandDiv = document.getElementById("expand");
			collapseDiv = document.getElementById("collapse");
			bannerDiv.style.display = "block";
    		addEventListeners();
    		reset();
			initObjects();
			<?php if(!$devMode) { ?>
				EB.setExpandProperties({useCustomClose: true});
			<?php } ?>
    		<!-- ReplaceValueProcess:custom-script -->
    		<!-- ReplaceValueProcess:custom-init -->

		}

		function initObjects(){
			<!-- ReplaceValueProcess:collapse-gsapinstance -->
			<!-- ReplaceValueProcess:expand-gsapinstance -->

			<!-- ReplaceValueProcess:collapse-gsapanimation -->
			<!-- ReplaceValueProcess:expand-gsapanimation -->
		}

		function launch(){
			<!-- ReplaceValueProcess:collapse-gsapplay -->
			<!-- ReplaceValueProcess:expand-gsapplay -->
		}

		function reset(){
			<!-- ReplaceValueProcess:collapse-gsapinit -->
			<!-- ReplaceValueProcess:expand-gsapinit -->
		}



     	function expand(){
			<?php if(!$devMode) { ?>
				EB.expand();
			<?php } ?>
			expandDiv.style.display = "block";
			collapseDiv.style.display = "none";
			removeClass(adDiv, "collapsed");
			setClass(adDiv, "expanded");
			customExpandAction();
		}
		function collapse(){
			expandDiv.style.display = "none";
			collapseDiv.style.display = "block";
			removeClass(adDiv, "expanded");
			setClass(adDiv, "collapsed");
			customCollapseAction();
			<?php if(!$devMode) { ?>
				EB.collapse();
			<?php } ?>
		}
		function handleExpandButtonClick(){
			expand();
		}
		function handleCollapseButtonClick(){
			collapse();
		}

		function addEventListeners() {
    	document.getElementById("clickthrough-button-expand").addEventListener("click", handleClickthroughButtonClick);
			document.getElementById("clickthrough-button-collapse").addEventListener("click", handleClickthroughButtonClick);
			document.getElementById("close-button").addEventListener("click", handleCollapseButtonClick);
			<!-- ReplaceValueProcess:custom-events -->
		}

		function handleClickthroughButtonClick() {
    		<?php if(!$devMode) { ?>
    			EB.clickthrough();
    		<?php } ?>
		}

		function customCollapseAction(){
			<!-- ReplaceValueProcess:collapse-custom -->
		}

		function customExpandAction(){
			<!-- ReplaceValueProcess:expand-custom -->
		}

		<!-- ReplaceValueProcess:custom-function -->


		window.addEventListener("load", initEB);



  	</script>
</head>
<body>
	<div id="container">
        <div id="ad" class="collapsed">
            <div id="banner">
             	 <div id="collapse">
                    <!-- ReplaceValueProcess:collapse-content -->
                    <button id="clickthrough-button-collapse" class="button clickthrough"></button>
                </div>
                <div id="expand">
                     <!-- ReplaceValueProcess:expand-content -->
                    <button id="clickthrough-button-expand" class="button clickthrough"></button>
                    <button id="close-button" class="button close"><!-- ReplaceValueProcess:close_text --></button>
                </div>
			</div>
        </div>
  	</div>
</body>
</html>
