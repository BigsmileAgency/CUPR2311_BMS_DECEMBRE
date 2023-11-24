<?php
 
  $project = ProjectFactory::get($type, $campaign, $am, $index_version, $css_version, $custom_css, $common_js);
 
  $pass = array(
    'banner_name' => $banner_name,
    'width' => $banner_width,
    'height' => $banner_height,
    'type' => $type,
    'format' => $format,
    'language' => $language
  );  

  $project -> passData($pass);
  $project -> clicktag($clicktag);
  $project -> addAssets($assetCollection);

 
  //VIDEO SETTINGS

  $project -> setVideo('video');
  $project -> setPoster('video.jpg');
  $project -> allowEvents(true);
  $project -> setAutoStopTime(15000);
  $project -> setLanguage(strtolower($language));
    
  $vars = compact('am', 'project', 'banner_width', 'banner_height', 'files', 'campaign', 'type');


?>