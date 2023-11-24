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
  	<!-- ReplaceValueProcess:import -->
    <link rel="stylesheet" href="//s1.adform.net/Banners/Scripts/assets/css/adform.reset.v1.css">
    <link rel="stylesheet" href="//s1.adform.net/Banners/Scripts/assets/css/adform.base.v1.css">
    <style>
<!-- ReplaceValueProcess:style -->
<!-- ReplaceValueProcess:custom-style -->
    </style>
    <script>
        document.write('<script src="' + (window.API_URL || 'https://s1.adform.net/banners/scripts/rmb/Adform.DHTML.js?bv=' + Math.random()) + '"><\/script>');
    </script>
    <script>

    	<!-- ReplaceValueProcess:gsapinstance_null -->
		<!-- ReplaceValueProcess:custom-vars -->

	    var Floating = function() {

		    this.banner = dhtml.byId('banner');
		     this.closeButton = dhtml.byId('closeButton');
		     this.clickArea = dhtml.byId('click-area');
		     this.lib = Adform.RMB.lib;

		    this._settings = {
		        clicktag: null,
		        target: null
		    };
		};
	    
	    Floating.prototype.setup = function (settings) {
	        for (var prop in settings) {
	            if (this._settings[prop] instanceof Object) {
	                for (var prop2 in settings[prop]) {
	                    this._settings[prop][prop2] = settings[prop][prop2];
	                }
	            } else {
	                this._settings[prop] = settings[prop];
	            }
	        }
	    };


	    Floating.prototype.attachEvents = function () {
	        
	    	var self = this;
	        this.closeButton.onclick = function (event) {
		        dhtml.external.close && dhtml.external.close();
		    };
		    
		     this.clickArea.onclick = function() {
		        window.open(self._settings.clicktag, self._settings.target);
		    };
	    
	    };
	    
		

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
<body class="Adform">
    <div id="banner" class="Adform-banner u-fullWidthHeight">
		 <div id="click-area">
			<!-- ReplaceValueProcess:content -->
		</div>
		<div id="closeButton" class="Adform-closeButton"><!-- ReplaceValueProcess:close --></div>
	</div>
	 <script>
    (function() {

    	var fl = new Floating();

        fl.setup({
            clicktag: dhtml.getVar('clickTAG', '<!-- ReplaceValueProcess:clicktag -->'),
            target: dhtml.getVar('landingPageTarget', '_blank'),
        });

        fl.attachEvents();
        <?php if($testComputedStyleForFirefox) { ?>
		var _interval  = setInterval(function(){
            if(window.getComputedStyle(document.body) || document.defaultView.getComputedStyle(document.body)){
               clearInterval(_interval);
        <?php } ?>
               <!-- ReplaceValueProcess:loaded-script -->
        <?php if($testComputedStyleForFirefox) { ?>
            }
        }, 20);
		<?php }  ?>
        

       
    })();
    </script>
</body>
</html>
