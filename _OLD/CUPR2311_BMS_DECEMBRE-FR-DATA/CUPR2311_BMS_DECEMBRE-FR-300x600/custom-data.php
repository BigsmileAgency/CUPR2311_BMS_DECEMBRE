<?php
  require 'common/utils/config/images-dimensions.php';

  // ONLY VARIABLE VALUES !!

  $content_json['#car'] = array(
    'x' => array('init' => 300, 'anim1' => 0),
    'opacity' => array('init' => 1, 'anim1' => 1, 'anim2' => 0),
    'rotation' => array('init' => '0.1'),
  );

  $content_json['#visu1'] = array(
    'opacity' => array('init' => 1, 'anim2' => 0),
    'rotation' => array('init' => '0.1'),
  );

  $content_json['#visu4'] =
  $content_json['#visu3'] =
  $content_json['#visu2'] =
  $content_json['#visu1'];


?>
