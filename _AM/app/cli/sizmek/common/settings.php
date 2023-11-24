<?php
 
  define('APP' , '../_am');

  require_once APP."/Autoload.php";
  require_once APP."/AppPath.php";

  AppPath::path(APP);
  Autoload::register();
  Cache::refresh();

  UI::select('Lumines');
  GSAPEngine::version([[version]]);
  GSAPEngine::toTweenMax();
  Template::usecdnLibraries(false);
  GSAPEngine::exportAddStyle();

  $banner_name = [[name]];
  $type = [[type]];
  $has_language = false;

  $settings = AutoSettings::get_settings($banner_name, $has_language);
  extract($settings);

  $clicktag = "#";

  $index_version = $project_name."-DATA/index.php";
  $css_version = "common/style.scss.php";
  $common_js = "common/common.js.php";
  $custom_css = $full_name."/custom.scss.php";

  require_once AppPath::getPath()."/helpers/helpers.php";
  require_once "common/assets.php";
  require_once $full_name."/data.php";
  require_once "common/data.php";

  $am = new AnimationManager();
  $campaign = new Campaign($banner_name.'-'.$language, $format);
  $current = $campaign -> getFullName().".php";
  $am -> setData(new JSONFormatData(json_encode($content_json), true));

 

?>