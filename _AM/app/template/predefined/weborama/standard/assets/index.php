<html>

<head>
  [weborama-open-meta] WEBORAMA SCREENAD META DATA (don't edit/remove) [weborama-close-meta]
  [weborama-open-meta] SCRVERSION: screenad_interface_1.0.3 [weborama-close-meta]
  [weborama-open-meta] SCRFORMAT: banner [weborama-close-meta]
  [weborama-open-meta] SCRSTICKY: true [weborama-close-meta]
  [weborama-open-meta] SCRWIDTH: <!-- ReplaceValueProcess:width --> [weborama-close-meta]
  [weborama-open-meta] SCRHEIGHT: <!-- ReplaceValueProcess:height --> [weborama-close-meta]
  [weborama-open-meta] TEMPLATENAME: Weborama Banner [weborama-close-meta]
  [weborama-open-meta] TEMPLATEDATE: 201607 [weborama-close-meta]

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="generator" content="Powered by Big Smile Agency">

  <script src="//media.adrcdn.com/scripts/screenad_interface_1.0.3_scrambled.js"></script>
  <!-- ReplaceValueProcess:import -->

  <script>
  <!-- ReplaceValueProcess:gsapinstance_null -->
  <!-- ReplaceValueProcess:custom-vars -->
    /**
     *  Mandatory Weborama JavaScript
     */

    screenad.onPreloadComplete = function() {
      <!-- ReplaceValueProcess:loaded-script -->
      addEventListener();

    };

    function init() {
      instances();
			reset();
			animations();
      <!-- ReplaceValueProcess:custom-script -->
			<!-- ReplaceValueProcess:custom-init -->
    }

    function addEventListener() {
      if (document.getElementById('clickThroughBtn')) {
        document.getElementById('clickThroughBtn').addEventListener('click', exitClick);
      }
      <!-- ReplaceValueProcess:custom-events -->

    }

    function exitClick() {
      screenad.click();
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

    body, div{
      margin:0;
      padding:0;
    }
    #container {
      position: absolute;
      left: 0;
      top: 0;
      width: <!-- ReplaceValueProcess:width -->px;
      height: <!-- ReplaceValueProcess:height -->px;
      cursor: pointer;
      z-index: 10;
    }
    .click {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      background-color: #FFF;
      background-color: rgba(255, 0, 0, 0);
      z-index: 200;
    }

    <!-- ReplaceValueProcess:style -->
    <!-- ReplaceValueProcess:custom-style -->
  </style>
</head>

<body>

  <div id="container">

    <div class="click" id="clickThroughBtn"></div>

    <!-- ReplaceValueProcess:content -->


  </div>

</body>

</html>
