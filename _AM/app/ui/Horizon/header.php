<?php 
  // $ms = Module::all();  
  $template_name = "Horizon";

  // var_dump(UI);
?>
<!doctype html>
<html class="<?= $type; ?>">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="generator" content="Powered by Big Smile Agency">
      <title>AM</title>

      <link rel="shortcut icon" href="<?= AppPath::getPath(); ?>/ui/<?= $template_name ?>/img/favicon/favicon.ico">

      <link rel="stylesheet" href="<?= AppPath::getPath(); ?>/ui/<?= $template_name ?>/css/style.css" media="screen" charset="utf-8">

    <script>
      var campaing_name = '<?= $campaign -> getNameNoLang() ?>';
      var type = '<?= $type; ?>';
      var width = '<?= $campaign -> getFormat() -> getWidth(); ?>';
      var height = '<?= $campaign -> getFormat() -> getHeight(); ?>';
    </script>
    <script type="text/javascript" src="<?= AppPath::getPath(); ?>/ui/<?= $template_name ?>/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="<?= AppPath::getPath(); ?>/engine/gsap/src/2.0.2/minified/TweenMax.min.js"></script>
    <script type="text/javascript" src="<?= AppPath::getPath(); ?>/engine/gsap/src/2.0.2/minified/plugins/GSDevTools.min.js"></script>
    <script type="text/javascript" src="<?= AppPath::getPath(); ?>/ui/<?= $template_name ?>/js/script.js"></script>
  </head>
<body>
