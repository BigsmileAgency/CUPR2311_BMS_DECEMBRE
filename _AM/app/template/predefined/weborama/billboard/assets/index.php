<!DOCTYPE html>
<html>

<head>
  [weborama-open-meta] WEBORAMA SCREENAD META DATA (don't edit/remove) [weborama-close-meta]
  [weborama-open-meta] SCRVERSION: screenad_interface_1.0.3 [weborama-close-meta]
  [weborama-open-meta] SCRFORMAT: layer [weborama-close-meta]
  [weborama-open-meta] SCRSTICKY: false [weborama-close-meta]
  [weborama-open-meta] SCRWIDTH: <!-- ReplaceValueProcess:width --> [weborama-close-meta]
  [weborama-open-meta] SCRHEIGHT: <!-- ReplaceValueProcess:height --> [weborama-close-meta]
  [weborama-open-meta] TEMPLATENAME: Smart Billboard 970x250 HTML5 [weborama-close-meta]
  [weborama-open-meta] TEMPLATEDATE: 2018-02-18 [weborama-close-meta]

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="generator" content="Powered by Big Smile Agency">

  <script src="//media.adrcdn.com/scripts/screenad_interface_1.0.3_scrambled.js"></script>
  <script src="//media.adrcdn.com/ad-resources/billboard/3.0.0/billboard.min.js"></script>
  <!-- ReplaceValueProcess:import -->

  <script>
  <!-- ReplaceValueProcess:gsapinstance_null -->
  <!-- ReplaceValueProcess:custom-vars -->
    /**
     *  Mandatory Weborama JavaScript
     */

    function init() {
      <!-- ReplaceValueProcess:custom-events -->
      instances();
			reset();
			animations();
      <!-- ReplaceValueProcess:custom-script -->
			<!-- ReplaceValueProcess:custom-init -->
    }



    /* Your JS :: Custom Actions */
    function onDocumentReady() {
      // Your initialization code
      // $('#container').css('opacity', '0'); // Not mandatory (example)

      <!-- ReplaceValueProcess:loaded-script -->
    }

    function onAdStart() {
      // Your ad start-up code (called only once when ad starts)
      setStyle('container', { opacity: 1 }, 300); // Not mandatory (example)
    }

    function onExpandStart() {
      // Your code for when expanding
      setStyle('container', { opacity: 1 }); // Not mandatory (example)
    }

    function onExpandComplete() {
      // Your code for when expanding
      main_timeline.play(0);
    }

    function onCollapseStart() {
      // Your code for when collapsing
      main_timeline.pause();
    }

    function onCollapseComplete() {
      // Custom code
      setStyle('container', { opacity: 0 }); // Not mandatory (example)
      main_timeline.pause(0);
    }

        /* Mandatory JS */

    /** Called when current HTML document is preloaded */
    screenad.onPreloadComplete = function() {
      // Mandatory settings! Edition only allowed with approval
      var settings = {
        collapsedWidth: 44,
        collapsedHeight: 44,
        expandedWidth: 970,
        expandedHeight: 250
      };
      weborama.initBillboard(settings);
    }
    /** Sets CSS properties for a specific element
      * @param {String} objectId - Id of the target HTML object
      * @param {Object} propertyObject - Object with CSS properties and values
      * @param {Number} [delay=0] - Optional. Delay in milliseconds
      */
    function setStyle(objectId, propertyObject, delay) {
      var element = document.getElementById(objectId), delay = (typeof delay !== undefined) ? delay : 0;
      if (element) {
        setTimeout(function(){
          for (var property in propertyObject) {
            element.style[property] = propertyObject[property];
          }
        }, delay);
      }
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

		function launch(){
			<!-- ReplaceValueProcess:gsapplay -->
		}

		<!-- ReplaceValueProcess:custom-function -->

  </script>

  <style>

    /* Mandatory CSS */

    html, body, div {
      margin: 0;
      padding: 0;
    }
	@media print {
		*{
			display: none !important;
			background: none !important;
		}
	}
    body {
      height: 100%;
    }
    #container {
      width: <!-- ReplaceValueProcess:width -->px;
      height: <!-- ReplaceValueProcess:height -->px;
      cursor: pointer;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 10;
      // -webkit-transition: 0.5s linear;
      // transition: 0.5s linear;
    }

    #close-open-button {
      width: 44px;
      height: 44px;
      position: absolute;
      top: 0px;
      right: 0px;
      z-index: 90;
      cursor: pointer;
    }

    <!-- ReplaceValueProcess:style -->
    <!-- ReplaceValueProcess:custom-style -->
  </style>
</head>

<body style="height: 100%">

<!-- Mandatory -->
<img id="close-open-button" src="//media.adrcdn.com/ad-resources/weborama_close_88x88.png" />
<div id="container" onclick="screenad.click();">

<!-- ReplaceValueProcess:content -->
  
</div>


</body>

</html>
