<?php


$assetCollection -> add(new Asset('logo_full', '_am/boilerplates/'.$client.'/assets/logo_full.svg', AssetType::SVG, false));

if ($theme['shadow_logo_simple']) {
  $assetCollection -> add(new Asset('simple-logo-shadow-left', '_am/boilerplates/'.$client.'/assets/simple-logo-shadow-left.png', AssetType::IMAGE, false));
  $assetCollection -> add(new Asset('simple-logo-shadow-right', '_am/boilerplates/'.$client.'/assets/simple-logo-shadow-right.png', AssetType::IMAGE, false));
}

?>
