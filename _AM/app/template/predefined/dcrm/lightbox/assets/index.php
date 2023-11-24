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
    <style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
  	<script>
		<!-- ReplaceValueProcess:collapse-gsapinstance_null -->
		<!-- ReplaceValueProcess:expand-gsapinstance_null -->

var creative = {};
var collapse_ready = false;
var expand_ready = false;
var allow_expand = true;
<!-- ReplaceValueProcess:custom-vars -->
<?php if($testComputedStyleForFirefox) { ?>
    var _interval;
    <?php }  ?>

function preInit(event) {
  creative.dom = {};
  creative.isTouchable = isMobile.any();
  creative.dom.expandExit = document.getElementById('expand-exit');
  creative.dom.expandState = document.getElementById('expand-state');
  creative.dom.collapseState = document.getElementById('collapse-state');
  creative.dom.collapseExit = document.getElementById('collapse-exit');

  if (Enabler.isInitialized()) {
    enablerInitHandler();
  } else {
    Enabler.addEventListener(
      studio.events.StudioEvent.INIT, enablerInitHandler);
  }
}


function enablerInitHandler(event) {
  Enabler.setHint('expansionMode', 'lightbox');

  if (creative.isTouchable) {
    creative.dom.collapseExit.addEventListener('click', onExpandHandler, false);
  } else {
    creative.dom.collapseExit.addEventListener('mouseover', onExpandHandler, false);
  }
  Enabler.addEventListener(studio.events.StudioEvent.FULLSCREEN_DIMENSIONS, fullScreenDimensionsHandler);
  Enabler.addEventListener(studio.events.StudioEvent.FULLSCREEN_EXPAND_START, expandStartHandler);
  Enabler.addEventListener(studio.events.StudioEvent.FULLSCREEN_EXPAND_FINISH, expandFinishHandler);
  Enabler.addEventListener(studio.events.StudioEvent.FULLSCREEN_COLLAPSE_START, collapseStartHandler);
  Enabler.addEventListener(studio.events.StudioEvent.FULLSCREEN_COLLAPSE_FINISH, collapseFinishHandler);
  creative.dom.expandExit.addEventListener('click', exitClickHandler);
  <!-- ReplaceValueProcess:custom-events -->

  if (Enabler.isVisible()) {
    enablerVisibleHandler();
  }
  else {
    Enabler.addEventListener(studio.events.StudioEvent.VISIBLE, enablerVisibleHandler);
  }
}

function enablerVisibleHandler(event) {
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

  if (creative.isExpanded) {
    return;
  }
  creative.dom.expandState.style.display = 'none';
  creative.dom.collapseState.style.display = 'block';
}

function init() {
    collapseInitObjects();
    expandInitObjects();
    reset();
    <!-- ReplaceValueProcess:custom-script -->
    <!-- ReplaceValueProcess:custom-init -->
}

function fullScreenDimensionsHandler(event) {
  Enabler.requestFullscreenExpand(event.width, event.height);
}


function expandStartHandler(event) {
  Enabler.finishFullscreenExpand();
};


function expandFinishHandler(event) {
  renderExpandedView();
};


function collapseStartHandler(event) {
  Enabler.finishFullscreenCollapse();
};

function onExpandHandler(event) {
  if (creative.isExpanded || !allow_expand) {
    return;
  }
  Enabler.queryFullscreenDimensions();
  allow_expand = false;
};


function collapseFinishHandler(event) {
  renderCollapsedView();
};


function renderExpandedView() {
  collapseStopAtEnd();
  expandLaunch();

  creative.dom.expandState.style.display = 'block';
  creative.dom.collapseState.style.display = 'none';
  creative.isExpanded = true;
  Enabler.startTimer('Panel Expansion');
  Enabler.counter('Expanded Counter');
}


function renderCollapsedView() {
  collapseStopAtEnd();
  expandStop();

  creative.dom.expandState.style.display = 'none';
  creative.dom.collapseState.style.display = 'block';
  creative.isExpanded = false;
  Enabler.stopTimer('Panel Expansion');
  Enabler.counter('Collapse Counter');
}


function exitClickHandler() {
  Enabler.requestFullscreenCollapse();
  Enabler.stopTimer('Panel Expansion');
  Enabler.exit('Background Exit');
}

function reset(){
  <!-- ReplaceValueProcess:expand-gsapinit -->
  <!-- ReplaceValueProcess:collapse-gsapinit -->
}

function collapseInitObjects(){
	<!-- ReplaceValueProcess:collapse-gsapinstance -->
	<!-- ReplaceValueProcess:collapse-gsapanimation -->
	collapse_ready = true;
}
function launch(){
	collapseLaunch();
}
function collapseLaunch(){
	<!-- ReplaceValueProcess:collapse-gsapplay -->
}

function collapseStop(){
	<!-- ReplaceValueProcess:collapse-gsapstop -->
}

function collapseStopAtEnd(){
	<!-- ReplaceValueProcess:collapse-gsapstopatend -->
}

function expandInitObjects(){
	<!-- ReplaceValueProcess:expand-gsapinstance -->
	<!-- ReplaceValueProcess:expand-gsapanimation -->
	expand_ready = true;
}

function expandLaunch(){
	<!-- ReplaceValueProcess:expand-gsapplay -->
}


function expandStop(){
	<!-- ReplaceValueProcess:expand-gsapstop -->
}

function expandStopAtEnd(){
	<!-- ReplaceValueProcess:expand-gsapstopatend -->
}

var isMobile = {
  Android: function() {
    return navigator.userAgent.match(/Android/i);
  },
  BlackBerry: function() {
    return navigator.userAgent.match(/BlackBerry/i);
  },
  iOS: function() {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
  },
  Opera: function() {
    return navigator.userAgent.match(/Opera Mini/i);
  },
  Windows: function() {
    return navigator.userAgent.match(/IEMobile/i);
  },
  any: function() {
    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()) && hasTouchScreen();
  }
};

<!-- ReplaceValueProcess:custom-function -->

var hasTouchScreen = function(){var n=!1,o=function(n){return-1!==window.navigator.userAgent.toLowerCase().indexOf(n)};return("ontouchstart"in window||navigator.maxTouchPoints>0||navigator.msMaxTouchPoints>0)&&(o("NT 5")||o("NT 6.1")||o("NT 6.0")||(n=!0)),n};

window.addEventListener('load', preInit);

  	</script>
</head>
<body>
	<div id="collapse-state">
    	<!-- ReplaceValueProcess:collapse-content -->
        <div id="collapse-exit"></div>
    </div>
    <div id="expand-state">
    	<!-- ReplaceValueProcess:expand-content -->
        <div id="expand-exit"></div>
    </div>
</body>
</html>
