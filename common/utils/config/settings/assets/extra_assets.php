<?php

if (!empty($extAssets)) {
  foreach ($extAssets as $assets) {
    $assetCollection -> add(new Asset($assets, "_am/app/engine/gsap/src/2.0.2/minified/plugins/$assets.min.js", AssetType::JS, false));
  }
}
