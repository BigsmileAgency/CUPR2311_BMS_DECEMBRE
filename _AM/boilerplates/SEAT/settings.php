<?php

// Default value
$logo_style = 'default'; // default/inline
$logo_color = '#ffffff';

$main_color = '#3bd4a6';
$txt_color = 'white';

$cta_main_color = '#ffffff';
$cta_main_txt_color = '#ffffff';
$cta_hover_color = '#ffffff';
$cta_hover_txt_color = '#000000';

// Logo type
if (in_array($format, array('300x250', '300x600'))) {
  $logo_style = 'inline';
}

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => false
];

$theme = [
  'logo_style' => $logo_style,
  'logo_color' => $logo_color,
  'color' => $main_color,
  'txt_color' => $txt_color,
  'cta_main_color' => $cta_main_color,
  'cta_main_txt_color' => $cta_main_txt_color,
  'cta_hover_color' => $cta_hover_color,
  'cta_hover_txt_color' => $cta_hover_txt_color
];

