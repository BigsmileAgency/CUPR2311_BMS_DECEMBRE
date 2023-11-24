<?php

  $banner_name = "CUPR2311_BMS_DECEMBRE";

  $useBoilerplate = false; // FORMAT CHECK : 120x600, 160x600, 200x600, 250x600, 300x75, 300x250, 300x600, 320x50, 320x75, 320x100, 320x125, 320x200, 320x240, 320x250, 320x480, 375x100, 468x60, 600x500, 640x150, 640x100, 640x200, 728x90, 768x250, 800x150, 800x250, 840x150, 960x150, 970x90, 970x250, 995x123, 995x250, 1120x300.

  $client = ""; // AUDI, SEAT, SKODA, VW, CUPRA, CARREFOUR, CITROEN,CITROEN-V2, MYWAY
  $version = ""; // If Multiple version

  $customNameExport = ''; // Add custom export name
  $fullCustomNameExport = false; // If true, replace all the export name with
  $defaultSeparator = '-'; // Change separator between name, format, lang
  $swapEnd = false; // If true, put LANG at the end of export

  $type = "dcm"; // dcm, gdn, dcrm (Studio no dynamic), dcrm-dynamic, dcrm-expandable, classic-link, weborama-billboard, weborama-skins, weborama-header, xandr, gamned... Check : _AM -> app -> project -> ProjectFactory.php

  $extAssets = []; // ['DrawSVGPlugin','SplitText','MorphSVGPlugin','CSSRulePlugin'...] Check _AM -> engine -> gsap -> src -> 2.0.2 -> plugins

  require_once "common/utils/config/settings/top.php";

  if($language == 'NL'){ $clicktag = "#"; }
  if($language == 'FR'){ $clicktag = "#"; }
  if($language == 'LU'){ $clicktag = "#"; }

  require_once "common/utils/config/settings/bottom.php";

?>
