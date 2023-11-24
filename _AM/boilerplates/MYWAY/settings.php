<?php

// Default value
$logo_subs = 'myway'; // myway/myway_buy/myway_direct
$logo_style = 'baseline'; // baseline/no-baseline/inline
$txt_color = 'black';
$gradient = "linear-gradient(25deg, rgba(54,60,137,1) 20%, rgba(5,168,222,1) 50%, rgba(31,182,128,1) 80%)";

if (in_array($format, array('300x100','300x150','320x50','320x100','640x200','728x90','970x90','1120x90','840x250','840x150','970x250'))) {
  $gradient = 'linear-gradient(25deg, rgba(31,182,128,1) 10%, rgba(5,168,222,1) 40%, rgba(54,60,137,1) 80%)';
}
// Logo type
if (in_array($format, array('300x250','600x500','320x250'))) {
  $logo_style = 'inline';
}
if (in_array($format, array('320x50','728x90','970x90','1120x90'))) {
  $logo_style = 'no-baseline';
}

$timeline_settings = [
  'startAnimation' => false,
  'endAnimation' => false
];

$theme = [
  'logo_subs' => $logo_subs,
  'logo_style' => $logo_style,
  'gradient' => $gradient,
  'txt_color' => $txt_color
];

