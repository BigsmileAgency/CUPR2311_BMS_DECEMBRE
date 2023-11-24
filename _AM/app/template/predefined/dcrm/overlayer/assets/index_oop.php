<?php 

$debug = false; 
$custom_interaction = true; 

?><!doctype html>
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

  		var dcrm;
  		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>
  		

	  	var DCRM_Floating = function() {
			
			this._container;	
			this._closeBtn;	
			this._exitBtn;

			this._vid;
			this._vidPlayBtn;
			this._vidPauseBtn;
			this._vidUnmuteBtn;
			this._vidMuteBtn;
			this._vidReplayBtn;
			this._vidStopBtn;

			this._timer;
			this._timer_int = <!-- ReplaceValueProcess:autostop-time -->;
			this._auto_stop_video_timer;
			this._auto_stop_video_delay = <!-- ReplaceValueProcess:autostopvideo-time -->;
			this._block_auto_stop_video_delay = false;

			this._is_first_time = true;
			this._is_first_play = true;
			this._user_play = false;
			<!-- ReplaceValueProcess:custom-vars -->
			<!-- ReplaceValueProcess:gsapinstance_null -->

			this.init();
		};


		DCRM_Floating.prototype.init = function(){
			<?php echo $debug ? 'console.log(\'init\');' : '' ?>
			var self = this;
			if (Enabler.isInitialized()) {
			    self.enablerInitHandler(self);
			} else {
			    Enabler.addEventListener(studio.events.StudioEvent.INIT, function() {
			    	self.enablerInitHandler(self);
			    });
			}
		};

		DCRM_Floating.prototype.enablerInitHandler = function(self){
			<?php echo $debug ? 'console.log(\'enablerInitHandler\');' : '' ?>
			Enabler.setFloatingPixelDimensions(<!-- ReplaceValueProcess:width --> ,<!-- ReplaceValueProcess:height -->);
			<?php if(!$custom_interaction) { ?>
		    	Enabler.addEventListener(studio.events.StudioEvent.INTERACTION, function() { self.userInteract(self) } );
		    <?php } ?>
		    self._container = document.getElementById('container');
			self._closeBtn = document.getElementById('closeBtn');
			self._exitBtn = document.getElementById('clickThroughBtn');
			self._timer = setInterval(function() { self.autoClose(self) }, self._timer_int);

			self._vid = document.getElementById('video');
			self._vidContainer = document.getElementById('videoContainer');
			self._vidPlayBtn = document.getElementById('btnPlay');
			self._vidPauseBtn = document.getElementById('btnPause');
			self._vidUnmuteBtn = document.getElementById('btnUnmute');
			self._vidMuteBtn = document.getElementById('btnMute');
			self._vidReplayBtn = document.getElementById('btnReplay');
			self._vidStopBtn = document.getElementById('btnStop');

			self._container.style.display = 'block';

			<!-- ReplaceValueProcess:loaded-script -->

			self.addListeners();
			self.addVideoTracking();


		};

		DCRM_Floating.prototype.addListeners = function(){
			<?php echo $debug ? 'console.log(\'addListeners\');' : '' ?>
			var self = this;
			self._closeBtn.addEventListener('click', function() { self.onCloseClickHandler(self) }, false);
			self._exitBtn.addEventListener('click', function() { self.onBgExitClickHandler(self) }, false);
			self._vidPlayBtn.addEventListener('click', function() { self.pausePlayClickHandler(self) }, false);
			self._vidPauseBtn.addEventListener('click', function() { self.pausePlayClickHandler(self) }, false);
			self._vidMuteBtn.addEventListener('click', function() { self.muteUnmuteClickHandler(self) }, false);
			self._vidUnmuteBtn.addEventListener('click', function() { self.muteUnmuteClickHandler(self) }, false);
			self._vidReplayBtn.addEventListener('click', function() { self.replayClickHandler(self) }, false);
			self._vidStopBtn.addEventListener('click', function() { self.stopClickHandler(self) },false);

			self._vid.addEventListener('ended', function() { self.videoEndHandler(self) }, false);
			self._vid.addEventListener('replay', function() { self.replayVideoHandler(self) }, false);
			self._vid.addEventListener('play', function() { self.playVideoHandler(self) }, false);
			self._vid.addEventListener('pause', function() { self.pauseVideoHandler(self) }, false);
			<!-- ReplaceValueProcess:custom-events -->

		};

		DCRM_Floating.prototype.addVideoTracking = function(){
			<?php echo $debug ? 'console.log(\'addVideoTracking\');' : '' ?>
			var self = this;
			<?php if(!$debug) { ?>
			Enabler.loadModule(studio.module.ModuleId.VIDEO, function() {
				studio.video.Reporter.attach('video', self._vid);
			});
			<?php } ?>
			<!-- ReplaceValueProcess:begin-video-custom-call -->

			self._vid.volume = 0.0;

			if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)) ){
				self._vidUnmuteBtn.style.display = 'none';
				self._vidMuteBtn.style.display = 'none';
			} else {
				self._vidMuteBtn.style.visibility = 'hidden';
				self._vidUnmuteBtn.style.visibility = 'visible';
			}
		};

		DCRM_Floating.prototype.play = function(){
			<?php echo $debug ? 'console.log(\'play\');' : '' ?>
			var self = this;
			self._vid.play();
		};

		DCRM_Floating.prototype.pause = function(){
			<?php echo $debug ? 'console.log(\'pause\');' : '' ?>
			var self = this;
			self._vid.pause();
		};

		DCRM_Floating.prototype.stop = function(){
			<?php echo $debug ? 'console.log(\'stop\');' : '' ?>
			var self = this;
			self._vid.stop();
		};

		DCRM_Floating.prototype.replay = function(){
			<?php echo $debug ? 'console.log(\'replay\');' : '' ?>
			var self = this;
			self._vid.currentTime = 0;
			self._vid.play();
		};

		DCRM_Floating.prototype.autoClose = function(self){
			<?php echo $debug ? 'console.log(\'autoClose\');' : '' ?>
			clearInterval(self._timer);
			clearTimeout(self._auto_stop_video_timer);
			self._main_timeline.stop();
			self._vid.pause();
			Enabler.close();
		};


		DCRM_Floating.prototype.onCloseClickHandler = function(self){
			<?php echo $debug ? 'console.log(\'onCloseClickHandler\');' : '' ?>
			clearInterval(self._timer);
			clearTimeout(self._auto_stop_video_timer);
			self._block_auto_stop_video_delay = true;
			self._vid.pause();
			self._main_timeline.stop();
			Enabler.reportManualClose();
			Enabler.close();
		};

		DCRM_Floating.prototype.onBgExitClickHandler = function(self){
			<?php echo $debug ? 'console.log(\'onBgExitClickHandler\');' : '' ?>
			
			clearInterval(self._timer);
			clearTimeout(self._auto_stop_video_timer);
			self._block_auto_stop_video_delay = true;
			<?php if($allowEvents) { ?>
				Enabler.exit('EVENT_CLICKTHROUGH');
			<?php } else { ?>
				Enabler.exit('EVENT_CLICKTHROUGH');
			<?php } ?>

			self._vid.pause();
			Enabler.close();
		};


		DCRM_Floating.prototype.pausePlayClickHandler = function(self){
			<?php echo $debug ? 'console.log(\'pausePlayClickHandler\');' : '' ?>
			<?php if($custom_interaction) { ?>
				clearInterval(self._timer);
				clearTimeout(self._auto_stop_video_timer);
				self._block_auto_stop_video_delay = true;
			<?php } ?>

			self._user_play = true;

			if (self._vid.paused) {
				self._vid.play();
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_PLAY');
				<?php } ?>
				self._vidPauseBtn.style.visibility = 'visible';
				self._vidPlayBtn.style.visibility = 'hidden';
			} else {
				self._vid.pause();
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_PAUSE');
				<?php } ?>
				self._vidPauseBtn.style.visibility = 'hidden';
				self._vidPlayBtn.style.visibility = 'visible';
			}
		};

		DCRM_Floating.prototype.muteUnmuteClickHandler = function(self){
			<?php echo $debug ? 'console.log(\'muteUnmuteClickHandler\');' : '' ?>
			<?php if($custom_interaction) { ?>
				clearInterval(self._timer);
				clearTimeout(self._auto_stop_video_timer);
				self._block_auto_stop_video_delay = true;
			<?php } ?>
			if (self._vid.volume == 0.0) {
				self._vid.volume = 1.0;
				<!-- ReplaceValueProcess:unmute-video-custom-call -->
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_UNMUTE');
				<?php } ?>
				self._vidMuteBtn.style.visibility = 'visible';
				self._vidUnmuteBtn.style.visibility = 'hidden';
			} else {
				self._vid.volume = 0.0;
				<!-- ReplaceValueProcess:mute-video-custom-call -->
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_VIDEO_MUTE');
				<?php } ?>
				self._vidMuteBtn.style.visibility = 'hidden';
				self._vidUnmuteBtn.style.visibility = 'visible';
			}
		};

		DCRM_Floating.prototype.replayClickHandler = function(self){
			<?php echo $debug ? 'console.log(\'replayClickHandler\');' : '' ?>
			<?php if($allowEvents) { ?>
				Enabler.counter('EVENT_VIDEO_REPLAY');
			<?php } ?>
			<?php if($custom_interaction) { ?>
				clearInterval(self._timer);
				clearTimeout(self._auto_stop_video_timer);
				self._block_auto_stop_video_delay = true;
			<?php } ?>
			self._vid.currentTime = 0;
			<!-- ReplaceValueProcess:replay-video-custom-call -->
			self._vid.play();
			self._vid.volume = 1.0;
			self._vidPauseBtn.style.visibility = 'visible';
			self._vidMuteBtn.style.visibility = 'visible';
		};

		DCRM_Floating.prototype.stopClickHandler = function(self){
			<?php echo $debug ? 'console.log(\'stopClickHandler\');' : '' ?>
			<?php if($allowEvents) { ?>
				Enabler.counter('EVENT_VIDEO_STOP');
			<?php } ?>
			<?php if($custom_interaction) { ?>
				clearInterval(self._timer);
				clearTimeout(self._auto_stop_video_timer);
				self._block_auto_stop_video_delay = true;
			<?php } ?>
			self._vid.currentTime = 0;
			<!-- ReplaceValueProcess:stop-video-custom-call -->
			self._vid.pause();
			self._vidPauseBtn.style.visibility = 'hidden';
			self._vidPlayBtn.style.visibility = 'visible';
			self._is_first_time = false;
		};

		<?php if(!$custom_interaction) { ?>
			DCRM_Floating.prototype.userInteract = function(){
				<?php echo $debug ? 'console.log(\'userInteract\');' : '' ?>
				var self = this;
				clearInterval(self._timer);
				clearTimeout(self._auto_stop_video_timer);
				<?php if($allowEvents) { ?>
					Enabler.counter('EVENT_USER_INTERACTION');
				<?php } ?>
			};
		<?php } ?>


		DCRM_Floating.prototype.playVideoHandler = function(self){
			<?php echo $debug ? 'console.log(\'playVideoHandler\');' : '' ?>
			if(!((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)))){
				if(self._is_first_play && !self._user_play && !self._block_auto_stop_video_delay){
					<?php echo $debug ? 'console.log(\'is_first_play\');' : '' ?>
					self._auto_stop_video_timer = setTimeout(function(){ 
						<?php echo $debug ? 'console.log(\'end_video_timer\');' : '' ?>
						self._vid.pause();
						self._vidPauseBtn.style.visibility = 'hidden';
						self._vidPlayBtn.style.visibility = 'visible';
						<!-- ReplaceValueProcess:end-video-custom-call -->
					}, self._auto_stop_video_delay);

					self._is_first_play = false;
					self._vidPauseBtn.style.visibility = 'visible';
					self._vidPlayBtn.style.visibility = 'hidden';
				}

			}
			<!-- ReplaceValueProcess:play-video-custom-call -->
		};

		DCRM_Floating.prototype.pauseVideoHandler = function(self){
			<?php echo $debug ? 'console.log(\'pauseVideoHandler\');' : '' ?>
			self._vidPauseBtn.style.visibility = 'hidden';
			self._vidPlayBtn.style.visibility = 'visible';
			<!-- ReplaceValueProcess:pause-video-custom-call -->
		};


		DCRM_Floating.prototype.replayVideoHandler = function(self){
			<?php echo $debug ? 'console.log(\'replayVideoHandler\');' : '' ?>
			if(!self._is_first_time || ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)))){
				if(self._vid.volume == 0.0){
					self.muteUnmuteHandler();
				}
			}
		};

		DCRM_Floating.prototype.videoEndHandler = function(self){
			<?php echo $debug ? 'console.log(\'videoEndHandler\');' : '' ?>
			<?php if($allowEvents) { ?>
				Enabler.counter('EVENT_VIDEO_COMPLETE');
			<?php } ?>
			clearTimeout(self._auto_stop_video_timer);
			<!-- ReplaceValueProcess:end-video-custom-call -->
			self._vid.pause();
			self._is_first_time = false;
			self._vidPauseBtn.style.visibility = 'hidden';
			self._vidPlayBtn.style.visibility = 'visible';
		};


		DCRM_Floating.prototype.initObjects = function(){
			<?php echo $debug ? 'console.log(\'initObjects\');' : '' ?>
			var self = this;
			<!-- ReplaceValueProcess:gsapinstance -->
			<!-- ReplaceValueProcess:gsapanimation -->
		};


		 DCRM_Floating.prototype.initAnimation = function(){
		 	<?php echo $debug ? 'console.log(\'initAnimation\');' : '' ?>
		    var self = this;
		     	self.reset();
		     	self.initObjects();
			  
			<!-- ReplaceValueProcess:custom-script -->
			<!-- ReplaceValueProcess:custom-init -->
	    };
	

		DCRM_Floating.prototype.reset = function(){
			<?php echo $debug ? 'console.log(\'reset\');' : '' ?>
			var self = this;
			<!-- ReplaceValueProcess:gsapinit -->
		};


		DCRM_Floating.prototype.launch = function(){
			<?php echo $debug ? 'console.log(\'launch\');' : '' ?>
			var self = this;
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


		window.addEventListener('load', function() { 
			<?php if($testComputedStyleForFirefox) { ?>
			_interval = setInterval(function(){
			    if(window.getComputedStyle(document.body) || document.defaultView.getComputedStyle(document.body)){
			       clearInterval(_interval);
			<?php } ?>
			       dcrm = new DCRM_Floating(); 
			<?php if($testComputedStyleForFirefox) { ?>

			    }
			}, 20);
			<?php } ?>
		});
	


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
