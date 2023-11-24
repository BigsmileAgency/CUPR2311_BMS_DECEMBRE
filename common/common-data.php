
<?php
  require 'common/utils/config/images-dimensions.php';

  $content_json['#container'] = array(
		'Perspective' => array('init' => 1400),
    'Force3D'     => array('init' => true),
    'Z()' => array('init' => 0),
    'transformStyle' => array('init' => 'flat'),
  );



  $content_json['#copy'] = array(
    'opacity' => array('init' => 0,'anim1' => 1),
    'rotation' => array('init' => '0.1'),
  );
  $content_json['#cta-2'] =
  $content_json['#cta'] =
  $content_json['#copy'];

  // NO TOUCH AFTER
  if ($useBoilerplate) {
    require_once('_am/boilerplates/'.$client.'/data.php');
  }

?>
