<?php

require 'vars.php';

//! Colours guidelines in "vars.php"
// Default value
$logo_style = 'default'; // default/full
$logo_color = $electric; // electric/emerald preferably
$logo_position = 'right'; // left/right/center
$logo_padding = '15px';

$cta_style = 'light'; //dark/light/white

$main_color = $emerald;
$txt_color = $electric;

// Logo type
// if (in_array($format, array('160x600', '300x600'))) {
//   $logo_style = 'full';
// }
if (in_array($format, array('320x50', '468x60'))) {
  $logo_padding = '8px 10px';
}

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => false
];

$theme = [
  'logo_style' => $logo_style,
  'logo_color' => $logo_color,
  'logo_position' => $logo_position,
  'logo_padding' => $logo_padding,
  'color' => $main_color,
  'txt_color' => $txt_color,
  'cta_style' => $cta_style,
];

