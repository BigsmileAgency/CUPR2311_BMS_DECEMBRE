<?php

// Default value
$main_color = '#000000';
$txt_color = '#6e6e6e';

$white_border_size_corner = '15';
$white_border_size_bottom = '35';

$shadow_logo_simple = false;

$is_simple_logo = false;

$is_legal_extra = true; // add extra legal
$is_legal_extra_inline = false; // is extra legal column/inline

$is_legal_inline = false;
$is_legal_outside_border = false; // set legal in or out the white border

$is_white_border = true;

// Custom formats value
if (in_array($format, array('120x600'))) {
  $is_legal_extra_inline = false;
}
if (in_array($format, array('120x600', '160x600', '200x600', '250x600'))) {
  $txt_color = '#ffffff';
  $is_legal_outside_border = true;
}
if (in_array($format, array('320x100', '320x125', '375x100', '320x75', '300x75', '320x50', '468x60', '970x90'))) {
  $white_border_size_corner = '5';
  $white_border_size_bottom = '15';
}
if (in_array($format, array('320x100', '320x125', '375x100', '320x75', '300x75', '320x50', '468x60', '728x90', '970x90', '640x100'))) {
  $is_legal_inline = true;
}
if (in_array($format, array('728x90', '640x100'))) {
  $white_border_size_corner = '10';
  $white_border_size_bottom = '16';
}
if (in_array($format, array('970x250'))) {
  $white_border_size_corner = '18';
  $white_border_size_bottom = '36';
}
if (in_array($format, array('320x50'))) {
  $is_white_border = false;
  $txt_color = '#ffffff';
}

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => false
];

$theme = [
  'main_color' => $main_color,
  'txt_color' => $txt_color,
  'white_border_size_corner' => $white_border_size_corner,
  'white_border_size_bottom' => $white_border_size_bottom,
  'shadow_logo_simple' => $shadow_logo_simple,
  'is_simple_logo' => $is_simple_logo,
  'is_legal_extra' => $is_legal_extra,
  'is_legal_extra_inline' => $is_legal_extra_inline,
  'is_legal_inline' => $is_legal_inline,
  'is_legal_outside_border' => $is_legal_outside_border,
  'is_white_border' => $is_white_border
];

