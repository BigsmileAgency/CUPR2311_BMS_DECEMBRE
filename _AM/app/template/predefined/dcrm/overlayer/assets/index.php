<?php 

$debug = false; 
$custom_interaction = false; 

?><!doctype html>
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
  			
		var container;	
		var closeBtn;	
		var exitBtn;

		var vid;
		var vidPlayBtn;
		var vidPauseBtn;
		var vidUnmuteBtn;
		var vidMuteBtn;
		var vidReplayBtn;
		var vidStopBtn;

		var timer;
		var timer_int = <!-- ReplaceValueProcess:autostop-time -->;
		var auto_stop_video_timer;
		var auto_stop_video_delay = <!-- ReplaceValueProcess:autostopvideo-time -->;
		var block_auto_stop_video_delay = false;

		var is_first_time = true;
		var is_first_play = true;
		var user_play = false;

		<!-- ReplaceValueProcess:custom-vars -->
		<!-- ReplaceValueProcess:gsapinstance_null -->

		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>

		
		var preinit = function(e){
			<?php echo $debug ? 'console.log(\'init\');' : '' ?>
			
			if (Enabler.isInitialized()) {
			    enablerInitHandler();
			} else {
			    Enabler.addEventListener(studio.events.StudioEvent.INIT, function() {
			    	enablerInitHandler();
			    });
			}
		};

		var enablerInitHandler = function(){
			<?php echo $debug ? 'console.log(\'enablerInitHandler\');' : '' ?>
			Enabler.setFloatingPixelDimensions(<!-- ReplaceValueProcess:width --> ,<!-- ReplaceValueProcess:height -->);
			<?php if(!$custom_interaction) { ?>
		    	Enabler.addEventListener(studio.events.StudioEvent.INTERACTION,  userInteract);
		    <?php } ?>
		    container = document.getElementById('container');
			closeBtn = document.getElementById('closeBtn');
			exitBtn = document.getElementById('clickThroughBtn');
			timer = setInterval(function() { autoClose(self) }, timer_int);

			vid = document.getElementById('video');
			vidContainer = document.getElementById('videoContainer');
			vidPlayBtn = document.getElementById('btnPlay');
			vidPauseBtn = document.getElementById('btnPause');
			vidUnmuteBtn = document.getElementById('btnUnmute');
			vidMuteBtn = document.getElementById('btnMute');
			vidReplayBtn = document.getElementById('btnReplay');
			vidStopBtn = document.getElementById('btnStop');

			container.style.display = 'block';

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
			
			addListeners();
			addVideoTracking();

			

		};

		var addListeners = function(){
			<?php echo $debug ? 'console.log(\'addListeners\');' : '' ?>
			
			closeBtn.addEventListener('click',  onCloseClickHandler, false);
			exitBtn.addEventListener('click', onBgExitClickHandler, false);
			vidPlayBtn.addEventListener('click', pausePlayClickHandler, false);
			vidPauseBtn.addEventListener('click', pausePlayClickHandler, false);
			vidMuteBtn.addEventListener('click', muteUnmuteClickHandler, false);
			vidUnmuteBtn.addEventListener('click', muteUnmuteClickHandler, false);
			vidReplayBtn.addEventListener('click', replayClickHandler, false);
			vidStopBtn.addEventListener('click', stopClickHandler, false);
			vid.addEventListener('ended',  videoEndHandler, false);
			vid.addEventListener('replay',  replayVideoHandler, false);
			vid.addEventListener('play', playVideoHandler, false);
			vid.addEventListener('pause', pauseVideoHandler, false);
			<!-- ReplaceValueProcess:custom-events -->

		};

		var addVideoTracking = function(){
			<?php echo $debug ? 'console.log(\'addVideoTracking\');' : '' ?>
			
			<?php if(!$debug) { ?>
			Enabler.loadModule(studio.module.ModuleId.VIDEO, function() {
				studio.video.Reporter.attach('video', vid);
			});
			<?php } ?>
			<!-- ReplaceValueProcess:begin-video-custom-call -->

			vid.volume = 0.0;

			if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)) ){
				vidUnmuteBtn.style.display = 'none';
				vidMuteBtn.style.display = 'none';
			} else {
				vidMuteBtn.style.visibility = 'hidden';
				vidUnmuteBtn.style.visibility = 'visible';
			}
		};

		var playVideo = function(){
			<?php echo $debug ? 'console.log(\'play\');' : '' ?>
			vid.play();
		};

		var pauseVideo = function(){
			<?php echo $debug ? 'console.log(\'pause\');' : '' ?>
			vid.pause();
		};

		var stopVideo = function(){
			<?php echo $debug ? 'console.log(\'stop\');' : '' ?>
			vid.stop();
		};

		var replayVideo = function(){
			<?php echo $debug ? 'console.log(\'replay\');' : '' ?>
			vid.currentTime = 0;
			vid.play();
		};

		var autoClose = function(){
			<?php echo $debug ? 'console.log(\'autoClose\');' : '' ?>
			clearInterval(timer);
			clearTimeout(auto_stop_video_timer);
			block_auto_stop_video_delay = true;
			main_timeline.stop();
			vid.pause();
			Enabler.close();
		};


		var onCloseClickHandler = function(e){
			<?php echo $debug ? 'console.log(\'onCloseClickHandler\');' : '' ?>
			clearInterval(timer);
			clearTimeout(auto_stop_video_timer);
			block_auto_stop_video_delay = true;
			vid.pause();
			main_timeline.stop();
			Enabler.reportManualClose();
			Enabler.close();
		};

		var onBgExitClickHandler = function(e){
			<?php echo $debug ? 'console.log(\'onBgExitClickHandler\');' : '' ?>
			
			clearInterval(timer);
			clearTimeout(auto_stop_video_timer);
			block_auto_stop_video_delay = true;

			<?php if($allowEvents) { ?>
				Enabler.exit('EVENT_CLICKTHROUGH');
			<?php } else { ?>
				Enabler.exit('EVENT_CLICKTHROUGH');
			<?php } ?>

			vid.pause();
			Enabler.close();
		};


		var pausePlayClickHandler = function(e){
			<?php echo $debug ? 'console.log(\'pausePlayClickHandler\');' : '' ?>
			<?php if($custom_interaction) { ?>
				clearInterval(timer);
				clearTimeout(auto_stop_video_timer);
				block_auto_stop_video_delay = true;
			<?php } ?>

			user_play = true;

			if (vid.paused) {
				vid.play();
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_PLAY');
				<?php } ?>
				vidPauseBtn.style.visibility = 'visible';
				vidPlayBtn.style.visibility = 'hidden';
			} else {
				vid.pause();
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_PAUSE');
				<?php } ?>
				vidPauseBtn.style.visibility = 'hidden';
				vidPlayBtn.style.visibility = 'visible';
			}
		};

		var muteUnmuteClickHandler = function(e){
			<?php echo $debug ? 'console.log(\'muteUnmuteClickHandler\');' : '' ?>
			<?php if($custom_interaction) { ?>
				clearInterval(timer);
				clearTimeout(auto_stop_video_timer);
				block_auto_stop_video_delay = true;
			<?php } ?>
			if (vid.volume == 0.0) {
				vid.volume = 1.0;
				<!-- ReplaceValueProcess:unmute-video-custom-call -->
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_UNMUTE');
				<?php } ?>
				vidMuteBtn.style.visibility = 'visible';
				vidUnmuteBtn.style.visibility = 'hidden';
			} else {
				vid.volume = 0.0;
				<!-- ReplaceValueProcess:mute-video-custom-call -->
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_MUTE');
				<?php } ?>
				vidMuteBtn.style.visibility = 'hidden';
				vidUnmuteBtn.style.visibility = 'visible';
			}
		};

		var replayClickHandler = function(e){
			<?php echo $debug ? 'console.log(\'replayClickHandler\');' : '' ?>
			<?php if($allowEvents) { ?>
				Enabler.counter('EVENT_VIDEO_REPLAY');
			<?php } ?>
			<?php if($custom_interaction) { ?>
				clearInterval(timer);
				clearTimeout(auto_stop_video_timer);
				block_auto_stop_video_delay = true;
			<?php } ?>
			vid.currentTime = 0;
			<!-- ReplaceValueProcess:replay-video-custom-call -->
			vid.play();
			vid.volume = 1.0;
			vidPauseBtn.style.visibility = 'visible';
			vidMuteBtn.style.visibility = 'visible';
		};

		var stopClickHandler = function(e){
			<?php echo $debug ? 'console.log(\'stopClickHandler\');' : '' ?>
			<?php if($allowEvents) { ?>
				Enabler.counter('EVENT_VIDEO_STOP');
			<?php } ?>
			<?php if($custom_interaction) { ?>
				clearInterval(timer);
				clearTimeout(auto_stop_video_timer);
				block_auto_stop_video_delay = true;
			<?php } ?>
			vid.currentTime = 0;
			<!-- ReplaceValueProcess:stop-video-custom-call -->
			vid.pause();
			vidPauseBtn.style.visibility = 'hidden';
			vidPlayBtn.style.visibility = 'visible';
			is_first_time = false;
		};

		<?php if(!$custom_interaction) { ?>
			var userInteract = function(e){
				<?php echo $debug ? 'console.log(\'userInteract\');' : '' ?>
				block_auto_stop_video_delay = true;
				clearInterval(timer);
				clearTimeout(auto_stop_video_timer);
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_USER_INTERACTION');
				<?php } ?>
			};
		<?php } ?>


		var playVideoHandler = function(e){
			<?php echo $debug ? 'console.log(\'playVideoHandler\');' : '' ?>
			if(!((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)))){
				if(is_first_play && !user_play && !block_auto_stop_video_delay){
					block_auto_stop_video_delay = true;
					<?php echo $debug ? 'console.log(\'is_first_play\');' : '' ?>
					auto_stop_video_timer = setTimeout(function(){ 
						<?php echo $debug ? 'console.log(\'end_video_timer\');' : '' ?>
						vid.pause();
						vidPauseBtn.style.visibility = 'hidden';
						vidPlayBtn.style.visibility = 'visible';
						<!-- ReplaceValueProcess:end-video-custom-call -->
					}, auto_stop_video_delay);

					is_first_play = false;
					vidPauseBtn.style.visibility = 'visible';
					vidPlayBtn.style.visibility = 'hidden';
				}

			}
			<!-- ReplaceValueProcess:play-video-custom-call -->
		};

		var pauseVideoHandler = function(e){
			<?php echo $debug ? 'console.log(\'pauseVideoHandler\');' : '' ?>
			vidPauseBtn.style.visibility = 'hidden';
			vidPlayBtn.style.visibility = 'visible';
			<!-- ReplaceValueProcess:pause-video-custom-call -->
		};


		var replayVideoHandler = function(e){
			<?php echo $debug ? 'console.log(\'replayVideoHandler\');' : '' ?>
			if(!is_first_time || ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)))){
				if(vid.volume == 0.0){
					muteUnmuteHandler();
				}
			}
		};

		var videoEndHandler = function(e){
			<?php echo $debug ? 'console.log(\'videoEndHandler\');' : '' ?>
			<?php if($allowEvents) { ?>
				Enabler.counter('EVENT_VIDEO_COMPLETE');
			<?php } ?>
			clearTimeout(auto_stop_video_timer);
			<!-- ReplaceValueProcess:end-video-custom-call -->
			vid.pause();
			is_first_time = false;
			vidPauseBtn.style.visibility = 'hidden';
			vidPlayBtn.style.visibility = 'visible';
		};


		var initObjects = function(){
			<?php echo $debug ? 'console.log(\'initObjects\');' : '' ?>
			
			<!-- ReplaceValueProcess:gsapinstance -->
			<!-- ReplaceValueProcess:gsapanimation -->
		};


		 var init = function(){
		 	<?php echo $debug ? 'console.log(\'init\');' : '' ?>
		    
		     	reset();
		     	initObjects();
			  
			<!-- ReplaceValueProcess:custom-script -->
			<!-- ReplaceValueProcess:custom-init -->
	    };
	

		var reset = function(){
			<?php echo $debug ? 'console.log(\'reset\');' : '' ?>
			<!-- ReplaceValueProcess:gsapinit -->
		};


		var launch = function(){
			<?php echo $debug ? 'console.log(\'launch\');' : '' ?>
			<!-- ReplaceValueProcess:gsapplay -->
		};

    	  
		<!-- ReplaceValueProcess:custom-function -->
		<!-- ReplaceValueProcess:begin-video-custom-function -->
		<!-- ReplaceValueProcess:end-video-custom-function -->
		<!-- ReplaceValueProcess:play-video-custom-function -->
		<!-- ReplaceValueProcess:pause-video-custom-function -->
		<!-- ReplaceValueProcess:replay-video-custom-function -->
		<!-- ReplaceValueProcess:stop-video-custom-function -->
		<!-- ReplaceValueProcess:mute-video-custom-function -->
		<!-- ReplaceValueProcess:unmute-video-custom-function -->


		window.addEventListener('load', preinit, false);
	


  	</script>
</head>
<body>
	<div id="container">
		<!-- ReplaceValueProcess:content -->
        <div id="videoContainer">
            <video id="video" poster="<!-- ReplaceValueProcess:video_poster -->">
                <source id="video_1_mp4_src" type="video/mp4" src="<!-- ReplaceValueProcess:video_name -->.mp4" />
                <?php /* <source id="video_1_ogv_src" type="video/ogv" src="<!-- ReplaceValueProcess:video_name -->.ogv" /> */?>
                <source id="video_1_webm_src" type="video/webm" src="<!-- ReplaceValueProcess:video_name -->.webm" />
            </video>
       	</div>
       	<div id="videoControls">
            <button id="btnPlay" class="video-controls"></button>
            <button id="btnPause" class="video-controls"></button>
            <button id="btnUnmute" class="video-controls"></button>
            <button id="btnMute" class="video-controls"></button>
            <button id="btnReplay" class="video-controls"></button>
            <button id="btnStop" class="video-controls"></button>
        </div>
        <div id="clickThroughBtn"></div>
        <div id="closeBtn"><!-- ReplaceValueProcess:close --></div>
	</div>
</body>
</html>
