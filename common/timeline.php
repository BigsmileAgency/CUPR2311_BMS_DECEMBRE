<?php
  if ($useBoilerplate && $timeline_settings['startAnimation']) {
    require_once('_am/boilerplates/'.$client.'/timeline/start.php');
  }

  // START TIMELINE


  timeline();
  inc(3);
  resetAnim();
  timeline();
  inc(3);
  resetAnim();
  timeline();
  
  function timeline() {
    inc(.2);
    play('#car', 0.5, 1, "POWER2_OUT");
    inc(1.5);
    play('#copy', 0.7, 1, "POWER2_OUT");
    inc(1);
    play('#cta', 0.7, 1, "POWER2_OUT");
  }

  function resetAnim() {
    play('#car', 0, 0, "POWER2_OUT");
    play('#copy', 0, 0, "POWER2_OUT");
    play('#cta', 0, 0, "POWER2_OUT");
  }

  // END TIMELINE

  if ($useBoilerplate && $timeline_settings['endAnimation']) {
    require_once('_am/boilerplates/'.$client.'/timeline/end.php');
  }
?>
