<?php

// Default value
$logo_style = 'default'; // default/line_hori/line_verti
$logo_color = '#ffffff';

$main_color = '#000000';
$txt_color = '#ffffff';

$diet_logo_color = 'white'; // black/white

$cta_main_color = '#ffffff';
$cta_main_txt_color = '#001e50';
$cta_hover_color = '#001e50';
$cta_hover_txt_color = '#ffffff';

$legal_padding = '10px 15px';
$conso_inline_dieteren = false;
$show_legal = true;
$legal_conso_inline = false;

// Custom formats value
if (in_array($format, array('120x600'))) {
  $legal_padding = '10px 9px';
}
if (in_array($format, array('300x600'))) {
  $legal_padding = '15px 20px';
}
if (in_array($format, array('320x100', '320x50', '375x100', '468x60'))) {
  $legal_padding = '0 10px 5px';
}
if (in_array($format, array('970x90'))) {
  $legal_padding = '5px 15px';
}
if (in_array($format, array('320x125', '320x75', '300x75'))) {
  $legal_padding = '5px 10px';
}

// Logo type
if (in_array($format, array('120x600', '160x600', '300x600'))) {
  $logo_style = 'line_hori';
}
if (in_array($format, array('995x123', '960x150', '840x150', '728x90', '640x150'))) {
  $logo_style = 'line_verti';
}

// Format where conso are align with dieteren logo
$format_conso_inline_dieteren = array('970x250', '960x150', '970x90', '840x150', '468x60', '320x125', '320x100', '320x75', '320x50', '300x75');
if (in_array($format, $format_conso_inline_dieteren)) {
  $conso_inline_dieteren = true;
}
// Format where legal not showed
if (in_array($format, array('320x100', '320x50', '320x75', '300x75', '468x60'))) {
  $show_legal = false;
}
// Format where conso + legal one line
if (in_array($format, array('375x100'))) {
  $legal_conso_inline = true;
}

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => true
];

$theme = [
  'logo_style' => $logo_style,
  'logo_color' => $logo_color,
  'color' => $main_color,
  'txt_color' => $txt_color,
  'diet_logo_color' => $diet_logo_color,
  'cta_main_color' => $cta_main_color,
  'cta_main_txt_color' => $cta_main_txt_color,
  'cta_hover_color' => $cta_hover_color,
  'cta_hover_txt_color' => $cta_hover_txt_color,
  'legal_padding' => $legal_padding,
  'format_conso_inline_dieteren' => $format_conso_inline_dieteren,
  'show_legal' => $show_legal,
  'legal_conso_inline' => $legal_conso_inline,
  'conso_inline_dieteren' => $conso_inline_dieteren,
];

