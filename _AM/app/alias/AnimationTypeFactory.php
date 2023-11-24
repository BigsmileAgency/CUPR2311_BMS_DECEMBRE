<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class AnimationTypeFactory {
		protected static $_types = array(
			AnimationType::MOVE => array('alias' => array('mv', 'mo', 'mov', 'move')),
			AnimationType::SIZE => array('alias' => array('sz', 'siz', 'size')),
			AnimationType::FADE => array('alias' => array('fd', 'fad', 'fade')),
			AnimationType::SCALE => array('alias' => array('sc', 'sl', 'sca', 'scale')),
			AnimationType::SCALE3D => array('alias' => array('sc3d', 'sl3d', 'sca3d', 'scale3d')),
			AnimationType::SKEW => array('alias' => array('sk', 'sw', 'ske', 'skew')),
			AnimationType::ROTATION => array('alias' => array('rt', 'rn', 'rot', 'rtt', 'rotate', 'rotation')),
			AnimationType::GSAP_ROTATION => array('alias' => array('gsaprt', 'gsaprn', 'gsaprot', 'gsaprtt', 'gsaprotate', 'gsaprotation')),
			AnimationType::ROTATION3D => array('alias' => array('rt3d', 'rn3d', 'rot3d', 'rtt3d', 'rotate3d', 'rotation3d')),
			AnimationType::GLOBALROTATION3D => array('alias' => array('grt3d', 'grn3d', 'grot3d', 'grtt3d', 'grotate3d', 'grotation3d', 'globalrotate3d', 'globalrotation3d')),
			AnimationType::TRANSLATE => array('alias' => array('tr', 'ts', 'tl', 'tn', 'tra', 'translate')),
			AnimationType::TRANSLATE3D => array('alias' => array('tr3d', 'ts3d', 'tl3d', 'tn3d', 'tra3d', 'translate3d')),
			AnimationType::TRANSFORM_TO_MATRIX => array('alias' => array('mt', 'mx', 'mat', 'matrix')),
			AnimationType::TRANSFORM3D_TO_MATRIX => array('alias' => array('mt3d', 'mx3d', 'mat3d', 'matrix3d')),
			AnimationType::PERSPECTIVE => array('alias' => array('pv', 'pr', 'per', 'persp', 'perspective')),
			AnimationType::BEZIER_PATH => array('alias' => array('bz', 'bez', 'bzp', 'bezp', 'bezier', 'pth', 'path','bezierpath')),
			AnimationType::DRAW_SVG => array('alias' => array('draw', 'dsvg', 'drsvg', 'drawsvg')),
			AnimationType::MORPH_SVG => array('alias' => array('morph', 'msvg', 'mrsvg', 'mrphsvg', 'morphsvg')));

		public static function get($pType){
			$nT = 0;
			$pType = trim($pType);
			foreach(self::$_types as $k => $t){
				if(count($t['alias'])){
					foreach($t['alias'] as $alias){
						if(preg_match("#(?<=^|\s)(?:(?:-)?".$alias."(?:-)?)(?=$|\s)#", $pType)){
							$nT |= $k;
							break;
						}
					}
				}
			}
			return $nT;
		}

	}

?>
