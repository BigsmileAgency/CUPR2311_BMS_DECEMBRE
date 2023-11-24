<!-- GetValueProcess:beginVars -->

  var mouse_allow = false;
  var lang = '<?= $language; ?>';
  var format = '<?= $format; ?>';
  var width = '<?= $width; ?>';
  var height = '<?= $height; ?>';

<!-- GetValueProcess:endVars -->
<!-- GetValueProcess:beginLoaded -->

  <?php if ($type == "dcrm-dynamic") {
    if ($language == 'FR') { ?>
    Enabler.setProfileId(10488774);
    <?php } else { ?>
    Enabler.setProfileId(10493360); <?php } ?>

    dynamic_content();
  <?php } ?>

  TweenMax.set('#container', { autoAlpha: 1});
  init();

<!-- GetValueProcess:endLoaded -->
<!-- GetValueProcess:beginInit -->

  main_timeline.call(allowMouseEvent);
	launch();

<!-- GetValueProcess:endInit -->

<!-- GetValueProcess:beginEvents -->

<?php if ($type == "weborama-billboard" || $type == "weborama-header" || $type == "weborama-skins" || $type == "weborama-interscroller") { ?>
  var clickTarget = 'container';
<?php }else { ?>
  var clickTarget = 'clickThroughBtn';
<?php } ?>

<?php if ($type == "gamned") { ?>
  document.getElementsByTagName('a')[0].addEventListener('mouseenter', onMouseEnterHandler, false);
  document.getElementsByTagName('a')[0].addEventListener('mouseleave', onMouseLeaveHandler, false);
<?php } else { ?>
  document.getElementById(clickTarget).addEventListener('mouseenter', onMouseEnterHandler, false);
  document.getElementById(clickTarget).addEventListener('mouseleave', onMouseLeaveHandler, false);
<?php } ?>

<!-- GetValueProcess:endEvents -->
<!-- GetValueProcess:beginFunctions -->

  <?php if ($useBoilerplate) {
    include '_am/boilerplates/'.$client.'/js/functions.js.php';
  }else {
    include "common/utils/js/functions.js";
  } ?>

  <?php if ($type == "dcrm-dynamic") { include "common/utils/js/dynamic.js"; } ?>
  <?php if ($type == "dcrm-expandable") { include "common/utils/js/expandable.js"; } ?>

<!-- GetValueProcess:endFunctions -->
