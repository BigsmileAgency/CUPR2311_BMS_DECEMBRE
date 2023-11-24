<?php

  $has_language = true;

  $debug = array('timeScale0','mockup0:4','delimiter0','timeStop0','mcolor0');

  define('APP' , '_AM/app');

  require_once APP."/Autoload.php";
  require_once APP."/AppPath.php";

  AppPath::path(APP);
  Autoload::register();

  UI::select('Horizon');

  GSAPEngine::version('2.0.2');

  if ($type == "gdn") {
    Template::usecdnLibraries(false);
  }else{
    Template::usecdnLibraries(true);
  }

  GSAPEngine::toTweenMax();
  GSAPEngine::exportAddStyle();
  AnimationManager::matrix(false);

  include "common/utils/config/settings/auto_path.php";

  if ($useBoilerplate) {
    require_once '_am/boilerplates/'.$client.'/settings.php';
  }

  require_once "common/utils/config/settings/functions.php";
  require_once "common/assets.php";
  require_once AppPath::getPath()."/helpers/copy.helper.php";

  $index_version = "common/index.php";
  $css_version = "common/common.scss.php";
  $custom_js = "common/common.js.php";
  $custom_css = $full_name."/custom.scss";

  require_once AppPath::getPath()."/helpers/helpers.php";
  require_once "common/common-data.php";
  require_once $full_name."/custom-data.php";
  require_once "common/utils/config/images-dimensions.php";

  if ($customNameExport != '') {
    if ($fullCustomNameExport) {
      $exportName = $swapEnd ? $customNameExport : $customNameExport.$defaultSeparator.$language;
    } else {
      $exportName = $swapEnd ? $banner_name.$defaultSeparator.$customNameExport : $banner_name.$defaultSeparator.$customNameExport.$defaultSeparator.$language;
    }
  } else {
    $exportName = $swapEnd ? $banner_name : $banner_name.$defaultSeparator.$language;
  }

  $am = new AnimationManager();
  $campaign = new Campaign($exportName, $format, $swapEnd ? $language : NULL, NULL, $defaultSeparator);
  $current = $campaign -> getFullName().".php";

  $project = ProjectFactory::get($type, $campaign, $am, $index_version, $css_version, $custom_css, $custom_js);

  include "common/utils/config/weborama-skins.php";
  if ($type == "weborama-interscroller") { include "common/utils/config/weborama-interscroller.php"; }
