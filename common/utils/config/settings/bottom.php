<?php

  $theme = $useBoilerplate ? $theme : [];
  $timeline_settings = $useBoilerplate ? $timeline_settings : [];

  $array_pass_data = array(
    'debug' => $debug,
    'banner_name' => $banner_name,
    'width' => $banner_width,
    'height' => $banner_height,
    'type' => $type,
    'format' => $format,
    'extAssets' => $extAssets,
    'position' => $position, // ONLY FOR SKINS
    'client'  => $client,
    'useBoilerplate' => $useBoilerplate,
    'timeline_settings' => $timeline_settings, // CHECK BOILERPLATE -> settings.php
    'theme' => $theme,
    'version' => $version,
    'dims' => $dims,
    'cm' => $cm,
    'isVertical' => $isVertical,
  );

  if($has_language){
    $array_pass_data['language'] = $language;
    $project -> setLanguage(strtolower($language));
  }

  $project -> passData($array_pass_data);
  $project -> addAssets($assetCollection);
  $project -> clicktag($clicktag);

  $am -> setData(new JSONFormatData(json_encode($content_json), true));

  $vars = compact('am', 'project', 'banner_width', 'banner_height', 'files', 'campaign', 'type', 'dims');
