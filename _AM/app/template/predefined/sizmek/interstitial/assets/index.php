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
        <script src="https://secure-ds.serving-sys.com/BurstingScript/EBLoader.js"></script>
		<!-- ReplaceValueProcess:import -->
        <style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
		<script>
			var timeUntilAutoCollapse = <!-- ReplaceValueProcess:auto_collapse -->;
			var autoCollapseTimeout;
			var cancelAutoCollapseOnUserInteraction = true;
			var lockScrollingWhenExpanded = true;
			var isAndroid2 = (/android 2/i).test(navigator.userAgent);
			var android2ResizeTimeout;
			<!-- ReplaceValueProcess:gsapinstance_null -->

			<!-- ReplaceValueProcess:custom-vars -->

			<?php if($testComputedStyleForFirefox) { ?>
			var _interval;
			<?php }  ?>

			window.addEventListener("load", checkIfEBIsInitialized);
			window.addEventListener("message", onMessageReceived);

			function checkIfEBIsInitialized() {
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

			function init() {
				reset();
initObjects();
<!-- ReplaceValueProcess:custom-script -->
				<?php if(!$devMode) { ?>
					initializeCustomVariables();
				<?php } ?>
				addEventListeners();
				<?php if(!$devMode) { ?>
					expand();
				<?php } ?>
				
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


			function initializeCustomVariables() {
				if (!EB._isLocalMode && EB._adConfig.customJSVars) {
					var customVariables = EB._adConfig.customJSVars;

					if (EBG.isNumber(customVariables.mdTimeUntilAutoCollapse)) {
						timeUntilAutoCollapse = customVariables.mdTimeUntilAutoCollapse;
					}

					if (EBG.isBool(customVariables.mdLockScrollingWhenExpanded)) {
						lockScrollingWhenExpanded = customVariables.mdLockScrollingWhenExpanded;
					}

					if (EBG.isBool(customVariables.mdCancelAutoCollapseOnUserInteraction)) {
						cancelAutoCollapseOnUserInteraction = customVariables.mdCancelAutoCollapseOnUserInteraction;
					}
				}
			}


			function addEventListeners() {
				document.getElementById("closeBtn").addEventListener("click", collapse, false);
				document.getElementById("clickThroughBtn").addEventListener("click", clickthrough, false);
				<!-- ReplaceValueProcess:custom-events -->
				if (cancelAutoCollapseOnUserInteraction) {
					var ad = document.getElementById("container");

					ad.addEventListener("mousedown", cancelAutoCollapse);
					ad.addEventListener("touchstart", cancelAutoCollapse);
				}
			}

			function clickthrough(event) {
				<?php if(!$devMode) { ?>
					EB.clickthrough();
				<?php } ?>
				
			}

			function cancelAutoCollapse(event) {
				clearTimeout(autoCollapseTimeout);
				event.currentTarget.removeEventListener("mousedown", cancelAutoCollapse);
				event.currentTarget.removeEventListener("touchstart", cancelAutoCollapse);
			}

			function expand() {

				EB.expand({
					actionType: EBG.ActionType.AUTO
				});

				if (lockScrollingWhenExpanded) {
					preventPageScrolling();
				}

				if (timeUntilAutoCollapse > 0){
					autoCollapseTimeout = setTimeout(collapse, timeUntilAutoCollapse);
				}
			}

			function preventPageScrolling() {
				document.addEventListener("touchmove", stopScrolling);
			}

			function stopScrolling(event) {
				event.preventDefault();
			}

			function collapse(event) {
				<?php if(!$devMode) { ?>
					EB.collapse();
				<?php } ?>
				
				if (lockScrollingWhenExpanded) {
					allowPageScrolling();
				}

				removeAd();
			}

			function allowPageScrolling() {
				document.removeEventListener("touchmove", stopScrolling);
			}

			function removeAd() {
				document.getElementById("container").style.display = "none";
				<?php if(!$devMode) { ?>
					var message = {
						adId: getAdID(),
						type: "removeAd"
					};
					window.parent.postMessage(JSON.stringify(message), "*");
				<?php } ?>
			}

			function getAdID() {
				if (EB._isLocalMode) {
					return null;
				}
				else {
					return EB._adConfig.adId;
				}
			}

			function onMessageReceived(event) {
				try {
					var messageData = JSON.parse(event.data);

					if (messageData.adId && messageData.adId === getAdID()) {
						if (messageData.type && messageData.type === "resize") {
							if (isAndroid2) {
								forceResizeOnAndroid2();
							}
						}
					}
				}
				catch (error) {
					EBG.log.debug(error);
				}
			}

			function forceResizeOnAndroid2() {
				document.body.style.opacity = 0.99;
				clearTimeout(android2ResizeTimeout);
				android2ResizeTimeout = setTimeout(function() {
					document.body.style.opacity = 1;
					document.body.style.height = window.innerHeight;
					document.body.style.width = window.innerWidth;
				}, 200);
			}





			<!-- ReplaceValueProcess:custom-function -->


        </script>
		<script>EB.initExpansionParams(0, 0, 0, 0);</script>
	</head>
	<body>
		<div id="background-dimmer">
			<div id="container" class="centered">

                <!-- ReplaceValueProcess:content -->

				<button id="clickThroughBtn" class="button clickthrough"></button>
				<button id="closeBtn" class="button close"><!-- ReplaceValueProcess:close_text --></button>
            </div>
		</div>
	</body>
</html>
