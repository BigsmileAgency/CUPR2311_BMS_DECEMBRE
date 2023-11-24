
<?php
$content_json['#'] = array(
  'Perspective'       => array('init' => 1400),
  'Force3D'           => array('init' => true),
  'scale'             => array('init' => 0, 'anim1' => 1),
  'scaleX'            => array('init' => 0, 'anim1' => 1),
  'scaleY'            => array('init' => 0, 'anim1' => 1),
  'transformOrigin'   => array('init' => '100% 100%'),
  'alpha'             => array('init' => 0, 'anim1' => 1),
  'Y'                 => array('init' => 0, 'anim1' => 10),
  'X'                 => array('init' => 0, 'anim1' => 10),
  'rotation'          => array('init' => 0.1),
  'backgroundColor'   => array('init' => '#ffffff'),
  'color'             => array('init' => '#ffffff'),
  'fill'              => array('init' => '#ffffff'),
  'boxShadow'         => array('init' => '0px 10px 10px 5px rgba(0,0,0,0.5)'),
);

// SAMPLE
// MORPH : import MorphSVGPlugin in setting.php then use this
$content_json['#FirstShape'] = array(
  'morphSVG' =>  array('init' =>  '#FirstShape', 'anim1' => '#SecondShape'),
);

// DRAW : import DrawSVGPlugin in setting.php then use this
$content_json['#IdPathToAnimate'] = array(
  'DrawSVG(%)' => array('init' => 0, 'anim1' =>  100),
);

// BEZIER : Follow path (check functions.js) -> import MorphSVGPlugin in setting.php then use this
for($i=0; $i <= 1; $i++){
  $content_json['#dot'.$i] = array(
    'bezier:values' => array('anim1' => 'js:path['.$i.']'),
    'bezier:type' => array('anim1' => 'cubic'),
  );
}

// FUNCTIONS
$content_json['#'] = soldes('50% 50%');

function soldes($origin){
  return array(
    'alpha' => array('init' => 0, 'anim1' => 1),
    'scale' => array('init' => 0, 'anim1' => 1),
    'transformOrigin' => array('init' => $origin),
    'rotation' => array('init' => 0.001),
  );
}
// TO BE UPDATED
