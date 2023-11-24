<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  [weborama-open-meta] WEBORAMA SCREENAD META DATA (don't edit/remove) [weborama-close-meta]
  [weborama-open-meta] SCRVERSION: screenad_interface_1.0.3 [weborama-close-meta]
  [weborama-open-meta] SCRFORMAT: layer [weborama-close-meta]
  [weborama-open-meta] SCRSTICKY: false [weborama-close-meta]
  [weborama-open-meta] SCRWIDTH: <!-- ReplaceValueProcess:width --> [weborama-close-meta]
  [weborama-open-meta] SCRHEIGHT: <!-- ReplaceValueProcess:height --> [weborama-close-meta]
  [weborama-open-meta] TEMPLATENAME: Weborama Interscroller [weborama-close-meta]
  [weborama-open-meta] TEMPLATEDATE: 201607 [weborama-close-meta]

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="generator" content="Powered by Big Smile Agency">

  <script language="javascript" src="//media.adrcdn.com/scripts/screenad_interface_1.0.3_scrambled.js"></script>
  <script language="javascript" src="//media.adrcdn.com/ad-resources/interscroller/4.0.0/interscroller.min.js"></script>
  <!-- ReplaceValueProcess:import -->

  <script>
  <!-- ReplaceValueProcess:gsapinstance_null -->
  <!-- ReplaceValueProcess:custom-vars -->
    /* ---------- Weborama Settings and Controller ------------ */
    var settings = {
      deviceDrivenWallpaper: <?= is_bool($deviceDrivenWallpaper) ? ($deviceDrivenWallpaper ? 'true' : 'false') : "'".$deviceDrivenWallpaper."'" ?>,
      bgSmallPortrait: '<?= $bgSmallPortrait ?>',
      bgSmallLandscape: '<?= $bgSmallLandscape ?>',
      bgMediumPortrait: '<?= $bgMediumPortrait ?>',
      bgMediumLandscape: '<?= $bgMediumLandscape ?>',
      bgLarge: '<?= $bgLarge ?>',
    };
    var InterScroller;

    function init() {
      instances();
			reset();
			animations();
      <!-- ReplaceValueProcess:custom-script -->
      <!-- ReplaceValueProcess:custom-init -->
    }
    // resetStageSize is used to change the height of the stage depending on the visibility of the navigation bars (mobile)
    // this way, your content will always have the maximum space available when you use % in your css.
    function resetStageSize() {
      var stage = document.getElementById('container');
      stage.style.height = InterScroller.getTotalContentHeight + 'px';
      stage.style.top =  InterScroller.getContentOffset + 'px';
    }

    /* ------------------ Helper Tools --------------------- */
    /**
     * show or hide a div, this is done without jQuery
     * It is possible to send an array string with the function to change multiple id's at once.
     * @param {Stirng} elements elements
     * @param {string} display display type
     */
    function setDisplay(elementStr, display) {
      var elementString = elementStr.replace(/ +/g, '');
      var elements = [];
      if (elementString.indexOf(',') > -1) {
        elements = elementString.split(',');
      } else {
        elements = [elementString];
      }
      for (var index = 0; index < elements.length; index += 1) {
        if (document.getElementById(elements[index])) {
          document.getElementById(elements[index]).style.display = display;
        }
      }
    }

    /* --------- Event Listeners From Weborama Interscroller Library ---------- */
    // handleOnAdReady will be called when all calculations are done.
    function handleOnAdReady() {
      setDisplay('shared', 'block');
      resetStageSize();
      // switchToDeviceView();
      handleOrientationChange();
      // your code here
    }

    // handleOrientationChange is called when you change the orientation of your mobile device
    // check it with `screenad.screenorientation`
    function handleOrientationChange() {
      if (screenad.screenorientation === screenad.SCREEN_ORIENTATION_PORTRAIT) {
        // portrait view
      } else {
        // landscape view
      }
    }

    // handleResize is called when the browser view is changed
    // (when you resize the browser window or if navigation bars show/hide/resize on mobile devices)
    function handleResize() {
      resetStageSize();
      // switchToDeviceView();
      // your code here
    }

    // handleScroll is called when you scroll in the browser
    // use `screenad.scrolly` to get the current Y position
    function handleScroll() {
    }

    // handleVisibilityChange is called when the ad changes visibility.
    // it can be used to start an animation or video if the ad has its visibility.
    // check it with `screenad.hasVisibility` (will return true or false).
    function handleVisibilityChange() {
      if (screenad.hasVisibility) {
        // start content (animation, video, show content)
      } else {
        // stop content (animation, video, hide content)
      }
    }

    //switchToDeviceView will check the current device where the ad is running and show the corresponding div, hide all others.
    // function switchToDeviceView() {
    //     // desktop
    //     setDisplay('desktop', 'block');
    //     setDisplay('tablet, smartphone', 'none');
      
    // }

    function handlePreloadComplete() {
      <!-- ReplaceValueProcess:loaded-script -->
      
      InterScroller = new window.WeboramaTemplates.InterScroller(settings);
      
      InterScroller.addEventListener('onAdReady', handleOnAdReady);
      InterScroller.addEventListener('onResize', handleResize);
      InterScroller.addEventListener('onOrientationChange', handleOrientationChange);
      InterScroller.addEventListener('onScroll', handleScroll);
      InterScroller.addEventListener('onVisibilityChange', handleVisibilityChange);
    }

    screenad.onPreloadComplete = handlePreloadComplete;

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

    body{
      margin:0;
      padding:0;
    }
    #container {
      width: 100%!important;
      height: 100%!important;
      cursor: pointer;
      z-index: 10;
    }
    .content-holder {
      position: absolute;
      cursor: pointer;
      width: 100%!important;
      height: 100%!important;
      top: 0;
      display: none;
    }
    .background-image {
      background-color: #000000;
      background-position: center center;
      background-repeat: no-repeat;
      background-size: cover; 
      /* Note: Use "contain" if you prefer to show bg-image completely. */
    }
    <!-- ReplaceValueProcess:style -->
    <!-- ReplaceValueProcess:custom-style -->
  </style>
</head>

<body>

  <div id="container" onclick="screenad.click();">

    <div id="background-image" class="background-image"></div> <!-- Background image gets set automatically in the library, don't remove this div -->
    <!-- If you don't want to use the background-image, set `deviceDrivenWallpaper` to false in the settings above -->

    <div id="shared" class="content-holder">
      <!-- Your Shared Content. Visible in all 3 states -->
      
      <!-- ReplaceValueProcess:content -->
    </div>

  </div>

</body>

</html>
