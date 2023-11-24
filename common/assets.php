<?php
	$assetCollection = new AssetCollection();

	$assetCollection -> add(new Asset('car', 'common/assets/car.png', AssetType::IMAGE, false));
	$assetCollection -> add(new Asset('bg', 'common/assets/'.$format.'/bg.jpg', AssetType::IMAGE, false));


  // NO TOUCH AFTER
  if ($useBoilerplate) { require_once('_am/boilerplates/'.$client.'/assets.php'); }
  // IF USE EXTERNAL LIBRARY
  if (!empty($extAssets)) { require_once('common/utils/config/settings/assets/extra_assets.php'); }
?>
