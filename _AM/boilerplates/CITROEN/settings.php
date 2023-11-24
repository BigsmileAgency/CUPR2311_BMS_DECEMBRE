<?php

// Default value
$logo_style = 'left'; // left/right
$logo_color = '#ffffff';

$main_color = '#000000';
$txt_color = '#ffffff';

$white_border_size = '10';

if (in_array($format, array('120x600', '320x75', '468x60', '375x100', '300x50', '300x75', '300x100', '320x100', '320x50', '970x90', '728x90'))) {
  $white_border_size = '5';
}
if (in_array($format, array('1120x300', '600x500'))) {
  $white_border_size = '15';
}

$padding = $white_border_size;

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => true
];

$theme = [
  'logo_style' => $logo_style,
  'logo_color' => $logo_color,
  'color' => $main_color,
  'txt_color' => $txt_color,
  'white_border_size' => $white_border_size,
  'padding' => $padding,
];

