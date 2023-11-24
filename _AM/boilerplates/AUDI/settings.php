<?php
// Default value
$logo_style = 'default'; // default/large (bold)
$logo_color = '#000000';
$logo_position = 'left'; // left/right/center
$logo_padding = '15px';

$diet_logo_color = 'black'; // black/white

$mask_style = 'default'; // default/verti
$mask_color = '#000000';

$main_color = '#ffffff';
$txt_color = '#000000';

$cta_main_color = '#ffffff';
$cta_main_txt_color = '#ffffff';
$cta_hover_color = '#ffffff';
$cta_hover_txt_color = '#000000';

$legal_padding = '10px';
$legal_position = 'center'; // left/right/center

// mask type
if (in_array($format, array('120x600', '160x600'))) {
  $mask_style = 'verti';
}

// logo padding
if (in_array($format, array('120x600', '160x600', '300x600', '728x90'))) {
  $logo_padding = '12px';
}

if (in_array($format, array('375x100', '320x100', '320x125', '320x75', '320x50', '468x60', '300x75'))) {
  $logo_padding = '8px';
}

if (in_array($format, array('320x75', '320x50', '468x60', '300x75'))) {
  $legal_padding = '5px 10px';
}

$timeline_settings = [
  'startAnimation' => true,
  'endAnimation' => true
];

$theme = [
  'logo_style' => $logo_style,
  'logo_color' => $logo_color,
  'logo_position' => $logo_position,
  'logo_padding' => $logo_padding,
  'diet_logo_color' => $diet_logo_color,
  'mask_style' => $mask_style,
  'mask_color' => $mask_color,
  'main_color' => $main_color,
  'txt_color' => $txt_color,
  'cta_main_color' => $cta_main_color,
  'cta_main_txt_color' => $cta_main_txt_color,
  'cta_hover_color' => $cta_hover_color,
  'cta_hover_txt_color' => $cta_hover_txt_color,
  'legal_padding' => $legal_padding,
  'legal_position' => $legal_position,
];

