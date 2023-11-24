<?php

  	require_once 'common/utils/config/settings/functions.php';

	$content_json = array(

		[[exemple]]//EXEMPLE OF ANIMATION DATA OBJECT

		/*'#obj1' => array(
			'X' => array('init' => 0, 'anim1' => 50),
			'Y' => array('init' => 0, 'anim3' => -20),
			'Scale' => array('init' => 1, 'anim2' => 0.8),
			'AutoAlpha' => array('init' => 0, 'anim1' => 1),
			'SkewX' => array('init' => 0, 'anim2' => 5),
			'SkewY' => array('init' => 0, 'anim4' => -5),
			'Rotation' => array('init' => -10, 'anim1' => 20),
		),*/

		[[splitText]]

		//SPLITTEXT
		/*'js:o1Lines' => array(
			'X' => array('init' => -20, 'anim1' => 0),
			'AutoAlpha' => array('init' => 0, 'anim1' => 1),
		),
		'js:o1Words' => array(
			'Y' => array('init' => -20, 'anim1' => 0),
		),
		'js:o1Chars' => array(
			'Rotation' => array('init' => -20, 'anim1' => 0),
		),
		'js:o2Chars' => array(
			'SkewX' => array('init' => -10, 'anim1' => 0),
		),
		'js:o3Lines' => array(
			'ScaleX' => array('init' => 1.4, 'anim1' => 1),
		),*/

		[[!splitText]]
		[[drawSVG]]

		//DRAWSVG
		/*'#ob1_dr' => array(
			'DrawSVG(%)' => array('init' => 0, 'anim1' => 100),
		),
		'#ob2_dr' => array(
			'DrawSVG' => array('init' => '0%', 'anim1' => '20% 100%'),
		),*/


		[[!drawSVG]]
		[[morphSVG]]

		//MORPHSVG
		/*'#ob1_morhp' => array(
			'morphSVG' => array('anim1' => '#moprh2'),
		),
		'#ob2_morph' => array(
			'morphSVG:shape' => array('anim1' => '#moprh2'),
			'morphSVG:shapeIndex' => array('anim1' =>6),
		),*/


		[[!morphSVG]]

		//EXEMPLE OF FIX DATA OBJECT
		/*'.fix' => array(
			'Z' => array('init' => 0),
			'BackfaceVisibility' => array('init' => 'hidden'),
		),*/[[!exemple]]
	);


?>
