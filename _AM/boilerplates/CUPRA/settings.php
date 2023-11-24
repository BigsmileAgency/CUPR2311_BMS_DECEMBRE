<?php

// Default value
$logo_color = '#95572B';
$logo_position_justify = 'right'; // left/right/center
$logo_position_align = 'bottom'; // top/center/bottom
$logo_padding = '10px 15px';

$main_color = '#ffffff';
$txt_color = '#000000';

$legal_padding = '10px 15px';
$is_conso_onload = false;
$show_legal_line = false;
$disable_legal = false;
$legal_conso_inline = false;

// Logo position
if (in_array($format, array('728x90', '320x50', '970x90'))) {
  $logo_position_align = 'center';
}
if (in_array($format, array('120x600', '160x600', '200x600', '250x600'))) {
  $logo_position_justify = 'center';
}

// Custom formats value
if (in_array($format, array('120x600'))) {
  $legal_padding = '10px 9px';
}
if (in_array($format, array('300x600'))) {
  $legal_padding = '15px 20px';
}
if (in_array($format, array('300x75', '320x100', '320x50', '375x100', '468x60'))) {
  $logo_padding = '10px';
  $legal_padding = '0 10px 5px';
}
if (in_array($format, array('970x90'))) {
  $legal_padding = '5px 15px';
}
if (in_array($format, array('320x125', '320x75', '300x75'))) {
  $logo_padding = '5px 10px';
  $legal_padding = '5px 10px';
}

// Format where legal not showed
if (in_array($format, array('320x50', '320x75', '300x75', '468x60'))) {
  $show_legal_line = false;
}
// Format where conso + legal one line
if (in_array($format, array('970x250', '960x150', '970x90', '840x150', '468x60', '320x75', '320x50'))) {
  $legal_conso_inline = true;
}

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => true
];

$theme = [
  'logo_color' => $logo_color,
  'logo_position_justify' => $logo_position_justify,
  'logo_position_align' => $logo_position_align,
  'logo_padding' => $logo_padding,
  'color' => $main_color,
  'txt_color' => $txt_color,
  'legal_padding' => $legal_padding,
  'show_legal_line' => $show_legal_line,
  'disable_legal' => $disable_legal,
  'legal_conso_inline' => $legal_conso_inline,
  'is_conso_onload' => $is_conso_onload,
];

