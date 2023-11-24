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
	<script src="https://s0.2mdn.net/ads/studio/Enabler.js"></script>
  	<!-- ReplaceValueProcess:import -->
    <style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
  	<script>

      <!-- ReplaceValueProcess:gsapinstance_null -->
		var vid1Container;
		var vid1;
		var vid1PlayBtn;
		var vid1PauseBtn;
		var vid1UnmuteBtn;
		var vid1MuteBtn;
		var vid1ReplayBtn;
		var vid1StopBtn;
		var userPlay = false;
		var pauseClickthrough = true;

		var isFirstTime = true;
		var isFirstPlay = true;
		var userPlay = false;

		var autoStopVideo;
		var autoStopDelay = <!-- ReplaceValueProcess:autostop-time -->;
		<!-- ReplaceValueProcess:custom-vars -->

		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>

		window.onload = function(){

			document.getElementById('vplayer').volume = 0.0;

  			if (Enabler.isInitialized()) {
    			enablerInitHandler();
  			} else {
    			Enabler.addEventListener(studio.events.StudioEvent.INIT, enablerInitHandler);
 			}
  		};

  		function enablerInitHandler(){
  			if (Enabler.isPageLoaded()) {
   		 		pageLoadedHandler();
  			} else {
   				Enabler.addEventListener(studio.events.StudioEvent.PAGE_LOADED, pageLoadedHandler);
  			}
  		}

  		function pageLoadedHandler() {
 			if (Enabler.isVisible()) {
    			adVisibilityHandler();
  			} else {
    			Enabler.addEventListener(studio.events.StudioEvent.VISIBLE, adVisibilityHandler);
  			}
		}

      function adVisibilityHandler() {
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
	  <!-- ReplaceValueProcess:custom-init -->
    }
	function reset(){
	<!-- ReplaceValueProcess:gsapinit -->
}
	
function initObjects(){
	vid1Container = document.getElementById('video-container-1');
	vid1 = document.getElementById('vplayer');
	vid1PlayBtn = document.getElementById('btnPlay');
	vid1PauseBtn = document.getElementById('btnPause');
	vid1UnmuteBtn = document.getElementById('btnUnmute');
	vid1MuteBtn = document.getElementById('btnMute');
	vid1ReplayBtn = document.getElementById('btnReplay');
	vid1StopBtn = document.getElementById('btnStop');

	<!-- ReplaceValueProcess:gsapinstance -->
	<!-- ReplaceValueProcess:gsapanimation -->
}

function launch(){
	addListeners();
	addVideoTracking();
	<!-- ReplaceValueProcess:gsapplay -->
}


function addListeners(){
	document.getElementById('clickThroughBtn').addEventListener('click', bgExitHandler, false);
	vid1PlayBtn.addEventListener('click', pausePlayHandler, false);
	vid1PauseBtn.addEventListener('click', pausePlayHandler, false);
	vid1MuteBtn.addEventListener('click', muteUnmuteHandler, false);
	vid1UnmuteBtn.addEventListener('click', muteUnmuteHandler, false);
	vid1ReplayBtn.addEventListener('click', replayHandler, false);
	vid1StopBtn.addEventListener('click', stopHandler,false);
	vid1.addEventListener('ended', videoEndHandler, false);
	vid1.addEventListener('replay', replayVideoHandler, false);
	vid1.addEventListener('play', playVideoHandler, false);
	vid1.addEventListener('pause', pauseVideoHandler, false);
	<!-- ReplaceValueProcess:custom-events -->

}

function replayVideoHandler(e){
	if(!isFirstTime){
		if(vid1.volume == 0.0){
			muteUnmuteHandler();
		}
	}
	if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i))){
		if(vid1.volume == 0.0){
			muteUnmuteHandler();
		}
	}
}

function playVideoHandler(e){
	if(!((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)))){
		if(isFirstPlay && !userPlay){
			autoStopVideo = setTimeout(function(){ <!-- ReplaceValueProcess:end-video-custom-call --> pausePlayHandler(e);}, autoStopDelay);
			isFirstPlay = false;
			vid1PauseBtn.style.visibility = 'visible';
			vid1PlayBtn.style.visibility = 'hidden';
		}

	}
	<!-- ReplaceValueProcess:play-video-custom-call -->


}

function pauseVideoHandler(e) {
	vid1PauseBtn.style.visibility = 'hidden';
	vid1PlayBtn.style.visibility = 'visible';
	<!-- ReplaceValueProcess:pause-video-custom-call -->

}

function pausePlayHandler(e) {
	userPlay = true;
	clearTimeout(autoStopVideo);

	if (vid1.paused) {
		vid1.play();
		<?php if($allowEvents) { ?>
			Enabler.counter('EVENT_VIDEO_PLAY');
		<?php } ?>
		vid1PauseBtn.style.visibility = 'visible';
		vid1PlayBtn.style.visibility = 'hidden';
	} else {
		vid1.pause();
		<?php if($allowEvents) { ?>
			Enabler.counter('EVENT_VIDEO_PAUSE');
		<?php } ?>
		vid1PauseBtn.style.visibility = 'hidden';
		vid1PlayBtn.style.visibility = 'visible';
	}
}


function muteUnmuteHandler(e) {
	clearTimeout(autoStopVideo);

	if (vid1.volume == 0.0) {
		vid1.volume = 1.0;
		<!-- ReplaceValueProcess:unmute-video-custom-call -->
		<?php if($allowEvents) { ?>
			Enabler.counter('EVENT_VIDEO_UNMUTE');
		<?php } ?>
		vid1MuteBtn.style.visibility = 'visible';
		vid1UnmuteBtn.style.visibility = 'hidden';
	} else {
		vid1.volume = 0.0;
		<!-- ReplaceValueProcess:mute-video-custom-call -->
		<?php if($allowEvents) { ?>
			Enabler.counter('EVENT_VIDEO_MUTE');
		<?php } ?>
		vid1MuteBtn.style.visibility = 'hidden';
		vid1UnmuteBtn.style.visibility = 'visible';
	}
}

function replayHandler(e) {
	<?php if($allowEvents) { ?>
		Enabler.counter('EVENT_VIDEO_REPLAY');
	<?php } ?>
	clearTimeout(autoStopVideo);
	vid1.currentTime = 0;
	<!-- ReplaceValueProcess:replay-video-custom-call -->
	vid1.play();
	vid1.volume = 1.0;
	vid1PauseBtn.style.visibility = 'visible';
	vid1MuteBtn.style.visibility = 'visible';
}

function stopHandler(e){
	<?php if($allowEvents) { ?>
		Enabler.counter('EVENT_VIDEO_STOP');
	<?php } ?>
	clearTimeout(autoStopVideo);
	vid1.currentTime = 0;
	<!-- ReplaceValueProcess:stop-video-custom-call -->
	vid1.pause();
	vid1PauseBtn.style.visibility = 'hidden';
	vid1PlayBtn.style.visibility = 'visible';

	isFirstTime = false;
}

function videoEndHandler(e) {
	<?php if($allowEvents) { ?>
	Enabler.counter('EVENT_VIDEO_COMPLETE');
	<?php } ?>
	clearTimeout(autoStopVideo);
	<!-- ReplaceValueProcess:end-video-custom-call -->
	vid1.pause();
	isFirstTime = false;
	vid1PauseBtn.style.visibility = 'hidden';
	vid1PlayBtn.style.visibility = 'visible';
}

function bgExitHandler(e) {
	clearTimeout(autoStopVideo);
	Enabler.exit('Background Exit');
	<!-- ReplaceValueProcess:pause-video-custom-call -->
	if(pauseClickthrough){
	vid1.pause();
	vid1PauseBtn.style.visibility = 'hidden';
	vid1PlayBtn.style.visibility = 'visible';
	}
}

function addVideoTracking() {
	Enabler.loadModule(studio.module.ModuleId.VIDEO, function() {
		studio.video.Reporter.attach('video_1', vid1);
	});

	vid1MuteBtn.style.visibility = 'hidden';
	vid1UnmuteBtn.style.visibility = 'visible';

	<!-- ReplaceValueProcess:begin-video-custom-call -->
	vid1.volume = 0.0;

	if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)) ){
		document.getElementById("btnUnmute").style.opacity=0;
		document.getElementById("btnMute").style.opacity=0;
	}

}




		<!-- ReplaceValueProcess:custom-function -->

		<!-- ReplaceValueProcess:begin-video-custom-function -->
		<!-- ReplaceValueProcess:end-video-custom-function -->
		<!-- ReplaceValueProcess:play-video-custom-function -->
		<!-- ReplaceValueProcess:pause-video-custom-function -->
		<!-- ReplaceValueProcess:replay-video-custom-function -->
		<!-- ReplaceValueProcess:stop-video-custom-function -->
		<!-- ReplaceValueProcess:mute-video-custom-function -->
		<!-- ReplaceValueProcess:unmute-video-custom-function -->



  	</script>
</head>
<body>
	<div id="container">
		<!-- ReplaceValueProcess:content -->
        <div id="video-container-1">
            <video id="vplayer" poster="<!-- ReplaceValueProcess:video_poster -->">
                <source id="video_1_mp4_src" type="video/mp4" src="<!-- ReplaceValueProcess:video_name -->.mp4" />
                <?php /* <source id="video_1_ogv_src" type="video/ogv" src="<!-- ReplaceValueProcess:video_name -->.ogv" /> */?>
                <source id="video_1_webm_src" type="video/webm" src="<!-- ReplaceValueProcess:video_name -->.webm" />
            </video>
       	</div>
       	<div id="video-controls-1">
            <button id="btnPlay" class="video-controls"></button>
            <button id="btnPause" class="video-controls"></button>
            <button id="btnUnmute" class="video-controls"></button>
            <button id="btnMute" class="video-controls"></button>
            <button id="btnReplay" class="video-controls"></button>
            <button id="btnStop" class="video-controls"></button>
        </div>
        <div id="clickThroughBtn"></div>
	</div>
</body>
</html>
