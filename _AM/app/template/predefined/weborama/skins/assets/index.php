<!DOCTYPE html>
<html>
<head>
  <title>Smart Skins - <?php echo ucfirst($position) ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="generator" content="Powered by Big Smile Agency">

  [weborama-open-meta] WEBORAMA SCREENAD META DATA (don"t edit/remove) [weborama-close-meta]
  [weborama-open-meta] SCRVERSION: screenad_interface_1.0.3 [weborama-close-meta]
  [weborama-open-meta] SCRFORMAT: layer [weborama-close-meta]
  [weborama-open-meta] SCRSTICKY: false [weborama-close-meta]
  [weborama-open-meta] SCRWIDTH: <!-- ReplaceValueProcess:width --> [weborama-close-meta]
  [weborama-open-meta] SCRHEIGHT: <!-- ReplaceValueProcess:height --> [weborama-close-meta]
  [weborama-open-meta] TEMPLATENAME: Smart Skins - <?php echo ucfirst($position) ?> [weborama-close-meta]
  [weborama-open-meta] TAGVARS: scrsticky (true, false, scroll), scrvalign (Force vertical align? top, banner or #id. Overwrites sitespecs value!) [weborama-close-meta]

  <script src="//media.adrcdn.com/scripts/screenad_interface_1.0.3_scrambled.js"></script>

  <!-- Need jQuery? Use: <script src="//media.adrcdn.com/scripts/jquery.min.js"></script> -->
  <!-- More libraries needed? Check: support.weborama.nl/hc/en-us/articles/210438526-Libraries -->
  <!-- ReplaceValueProcess:import -->

  <script type="text/javascript">

    <?php if(ucfirst($position) == 'Right') { ?>
    /* Template Settings */

    // Activate scaling? This setting affects the "ScalableContent" div
    var scaleContent = <?php echo is_bool($scalableContent) ? ($scalableContent ? 'true' : 'false') : "'".$scalableContent."'" ?>;
    // If so, how narrow can the scalable content get?
    var minWidth = <?php echo $minWidth ?>;
    // Want to modify the original/max width as well? Use the #scalableContent CSS class below.
    var scrollContent = false;
    
    <?php } else { ?>

      // Shared Background (Cross-Elements) for Skins and Header (if present)
      var BG_image = <?php echo is_bool($BG_image) ? ($BG_image ? 'true' : 'false') : "'".$BG_image."'" ?>;
      // Image file name. If non wanted, use: BG_image = false;
      var BG_color = '<?php echo $BG_color ?>'; // Color used in space not covered by image. Accepts any CSS color value.
      var BG_width = <?php echo is_numeric($BG_width) ? $BG_width : "'".$BG_width."'" ?>; // Width of the wallpaper. Use 'auto' for full viewport scalable size. Use a number for (non-scalabe) fixed size.
      /* Template Settings */

      // Activate scaling? This setting affects the "ScalableContent" div
      var scaleContent = <?php echo is_bool($scalableContent) ? ($scalableContent ? 'true' : 'false') : "'".$scalableContent."'" ?>;
      // If so, how narrow can the scalable content get?
      var minWidth = <?php echo $minWidth ?>;
      // Want to modify the original/max width as well? Use the #scalableContent CSS class below.
      var scrollContent = false;

    <?php } ?>

    /* Template Handlers */
    <!-- ReplaceValueProcess:gsapinstance_null -->
    <!-- ReplaceValueProcess:custom-vars -->


    // Custom start-up actions before ad set starts
    function onInit() {
      // Optional (next to initial CSS values)
      <!-- ReplaceValueProcess:loaded-script -->
    }

    // Actions for when all elements show on screen
    function onStart() {
    }

    function init(){
      <!-- ReplaceValueProcess:custom-events -->
      instances();
      reset();
      animations();
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

    function launch(){
      <!-- ReplaceValueProcess:gsapplay -->
    }

    <!-- ReplaceValueProcess:custom-function -->

  </script>
  <script src="skin<?php echo ucfirst($position) ?>.js"></script>
  <style type="text/css">

    /* Mandatory Template CSS */
    html, body, div {
      margin: 0;
      padding: 0;
    }
    #container {
      width: <!-- ReplaceValueProcess:width -->px;
      height: <!-- ReplaceValueProcess:height -->px;
      z-index: 50;
      cursor: pointer;
    }
    #content {
      position: absolute;
      width: <!-- ReplaceValueProcess:width -->px;
      height: <!-- ReplaceValueProcess:height -->px;
      z-index: 100;
    }
    #scalableContent {
      position: absolute;
      left: 0px;
      top: 0px;
      width: <?php echo $scalableContentWidth ?>px;
      height: <?php echo $scalableContentHeight ?>px;
      z-index: 150;
      transform-origin: 0% 0%;
    }
    /* Your Content CSS */
    <!-- ReplaceValueProcess:style -->
    <!-- ReplaceValueProcess:custom-style -->

  </style>
</head>
<body>

  <div id="container" onclick="screenad.click();">

    <div id="content">
      <!-- Your Regular HTML Content -->
      <!-- ReplaceValueProcess:content -->

    </div>

    <div id="scalableContent">
      <!-- Your Scalable HTML Content -->
      <!-- ReplaceValueProcess:scalable-content -->

    </div>

  </div>

  <!-- Automated Shared Background - No editing please -->
  <div id="sharedBackground"></div>

</body>
</html>