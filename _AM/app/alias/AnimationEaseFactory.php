<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class AnimationEaseFactory {
		protected static $_storage = array();
		

		protected static $_eases = array(
			AnimationEaseType::LINEAR => array('alias' => array('pattern' => '(?:(?:(?:ease(?:\.|-|_)?)(?:none))|(?:linear))?')),
			AnimationEaseType::EASE => array('alias' => array('pattern' => '(?:linear(?:\.|-|_)?)?(?:ease)')),
			AnimationEaseType::EASEIN => array('alias' => array('pattern' => '(?:(?:linear(?:\.|-|_)?(?:ease(?:\.|-|_)?)?)|(?:ease(?:\.|-|_)?))in')),
			AnimationEaseType::EASEOUT => array('alias' => array('pattern' => '(?:(?:linear(?:\.|-|_)?(?:ease(?:\.|-|_)?)?)|(?:ease(?:\.|-|_)?))out')),
			AnimationEaseType::EASEINOUT => array('alias' => array('pattern' => '(?:(?:linear(?:\.|-|_)?(?:ease(?:\.|-|_)?)?)|(?:ease(?:\.|-|_)?))in(?:\.|-|_)?out')),
			AnimationEaseType::BEZIER => array('alias' => array('pattern' => '(?:cubic(?:\.|-|_)?)?bezier\(\s*((?:[0-9]+)|(?:[0-9]*\.[0-9]+))\s*(?:\,)\s*((?:[0-9]+)|(?:[0-9]*\.[0-9]+))\s*(?:\,)\s*((?:[0-9]+)|(?:[0-9]*\.[0-9]+))\s*(?:\,)\s*((?:[0-9]+)|(?:[0-9]*\.[0-9]+))\)')),
			AnimationEaseType::QUAD_IN => array('alias' => array('pattern' => 'quad(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::QUAD_OUT => array('alias' => array('pattern' => 'quad(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::QUAD_INOUT => array('alias' => array('pattern' => 'quad(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::CUBIC_IN => array('alias' => array('pattern' => 'cubic(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::CUBIC_OUT => array('alias' => array('pattern' => 'cubic(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::CUBIC_INOUT => array('alias' => array('pattern' => 'cubic(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::QUART_IN => array('alias' => array('pattern' => 'quart(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::QUART_OUT => array('alias' => array('pattern' => 'quart(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::QUART_INOUT => array('alias' => array('pattern' => 'quart(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::QUINT_IN => array('alias' => array('pattern' => 'quint(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::QUINT_OUT => array('alias' => array('pattern' => 'quint(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::QUINT_INOUT => array('alias' => array('pattern' => 'quint(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::STRONG_IN => array('alias' => array('pattern' => 'strong(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::STRONG_OUT => array('alias' => array('pattern' => 'strong(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::STRONG_INOUT => array('alias' => array('pattern' => 'strong(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::SINE_IN => array('alias' => array('pattern' => 'sine(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::SINE_OUT => array('alias' => array('pattern' => 'sine(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::SINE_INOUT => array('alias' => array('pattern' => 'sine(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::EXPO_IN => array('alias' => array('pattern' => 'expo(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::EXPO_OUT => array('alias' => array('pattern' => 'expo(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::EXPO_INOUT => array('alias' => array('pattern' => 'expo(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::CIRC_IN => array('alias' => array('pattern' => 'circ(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::CIRC_OUT => array('alias' => array('pattern' => 'circ(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::CIRC_INOUT => array('alias' => array('pattern' => 'circ(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::BACK_IN => array('alias' => array('pattern' => 'back(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in[:config(1):]')),
			AnimationEaseType::BACK_OUT => array('alias' => array('pattern' => 'back(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out[:config(1):]')),
			AnimationEaseType::BACK_INOUT => array('alias' => array('pattern' => 'back(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out[:config(1):]')),
			AnimationEaseType::ELASTIC_IN => array('alias' => array('pattern' => 'elastic(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in[:config(2):]')),
			AnimationEaseType::ELASTIC_OUT => array('alias' => array('pattern' => 'elastic(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out[:config(2):]')),
			AnimationEaseType::ELASTIC_INOUT => array('alias' => array('pattern' => 'elastic(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out[:config(2):]')),
			AnimationEaseType::BOUNCE_IN => array('alias' => array('pattern' => 'bounce(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::BOUNCE_OUT => array('alias' => array('pattern' => 'bounce(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::BOUNCE_INOUT => array('alias' => array('pattern' => 'bounce(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::POWER0 => array('alias' => array('pattern' => '(?:power0)?')),
			AnimationEaseType::POWER1_IN => array('alias' => array('pattern' => 'power1(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::POWER1_OUT => array('alias' => array('pattern' => 'power1(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::POWER1_INOUT => array('alias' => array('pattern' => 'power1(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::POWER2_IN => array('alias' => array('pattern' => 'power2(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::POWER2_OUT => array('alias' => array('pattern' => 'power2(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::POWER2_INOUT => array('alias' => array('pattern' => 'power2(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::POWER3_IN => array('alias' => array('pattern' => 'power3(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::POWER3_OUT => array('alias' => array('pattern' => 'power3(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::POWER3_INOUT => array('alias' => array('pattern' => 'power3(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::POWER4_IN => array('alias' => array('pattern' => 'power4(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in')),
			AnimationEaseType::POWER4_OUT => array('alias' => array('pattern' => 'power4(?:\.|-|_)?(?:ease(?:\.|-|_)?)?out')),
			AnimationEaseType::POWER4_INOUT => array('alias' => array('pattern' => 'power4(?:\.|-|_)?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out')),
			AnimationEaseType::SLOWMO => array('alias' => array('pattern' => '(?:slow(?:\.|-|_)?(?:mo(?:tion)?)?)(?:(?:\.|-|_)?(?:ease))?[:config(3):]')),
			AnimationEaseType::STEPPED => array('alias' => array('pattern' => '(?:step(?:ped)?)(?:(?:\.|-|_)?(?:ease))?[:config(1):]')),
			AnimationEaseType::CUSTOMEASE => array('alias' => array('pattern' => '(?:custom)(?:(?:\.|-|_)?(?:ease))?[:config(1):]')),
			AnimationEaseType::CUSTOMWIGGLE => array('alias' => array('pattern' => '(?:(?:custom)(?:\.|-|_)?)?(?:wiggles?)[:config(3):]')),
		);
		public static function get($pEase){
			$nE = new AnimationEase(AnimationEaseType::LINEAR, NULL);
			$pEase = trim($pEase);
			$exist_ease = false;
			if(isset(self::$_storage[$pEase])){
				return self::$_storage[$pEase];
			}
			foreach(self::$_eases as $k => $e){
				if(count($e['alias'])){
					$fpattern = preg_replace_callback('/\[\:config\(([1-3])\)\:\]/', function($matches) use ($k){
						if($k == AnimationEaseType::CUSTOMEASE) {
							if($matches[1] == 1){
								$p1 = '(?:(?:[MLHVCSQTA]?(?:[\-0-9\.,\s]*)[Z]?(?:\s*))+)';
								$p2 = '(\:(?:(?:`'.$p1.'`)|(?:´'.$p1.'´)|(?:\''.$p1.'\')|(?:"'.$p1.'")|(?:'.$p1.')))';
								$config_pat = $p2;
								return $config_pat;
							}
						} else if($k == AnimationEaseType::CUSTOMWIGGLE) {
							if($matches[1] == 3){
								$p1 = '(?:(?:(?:ease(?:\.|-|_)?)?out)|(?:(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out)|(?:anticipate)|(?:uniform)|(?:random){1}?)';
								$p2 = '(?:(?:\:\-?(?:(?:[1-9]|(?:[1-9][0-9]+)))){0,1})|(?:(?:\:\-?(?:(?:[1-9]|(?:[1-9][0-9]+)))){1}\:(?:(?:(?:`'.$p1.'`)|(?:´'.$p1.'´)|(?:\''.$p1.'\')|(?:"'.$p1.'")|(?:'.$p1.'))))';
								$config_pat = '((?:'.$p2.'))';
								return $config_pat;
							}
						} else {
							if($matches[1] == 3){
								$config_pat = '((?:(?:\:\-?(?:(?:(?:[0-9]*)\.(?:[0-9]+))|(?:[0-9]+))){0,2})|(?:(?:\:\-?(?:(?:(?:[0-9]*)\.(?:[0-9]+))|(?:[0-9]+))){2}\:(?:(?:true)|(?:false))))';
								return $config_pat;
							}else{
								$config_pat = '((?:\:\-?(?:(?:(?:[0-9]*)\.(?:[0-9]+))|(?:[0-9]+))){0,[:p:]})';
								return str_replace('[:p:]', $matches[1], $config_pat);
							}
						}
					 }, $e['alias']['pattern']);
					if(preg_match("#^".$fpattern."$#i", $pEase)){
						if($k === AnimationEaseType::BEZIER){
							$matches = array();
							preg_match("#^".$fpattern."$#i", $pEase, $matches);
							$nE = new AnimationEase($k, array($matches[1], $matches[2], $matches[3], $matches[4]));
						} else {
							preg_match("#^".$fpattern."$#i", $pEase, $matches);
							$nE = new AnimationEase($k, NULL);
							if(count($matches) > 1){
								if(strpos($matches[1],':') !== false){
									$explode = explode(':', $matches[1]);
									unset($explode[0]);
									$explode = array_values($explode);

									if($k == AnimationEaseType::CUSTOMEASE) {
										if(count($explode) == 1){
											$nE = new CustomEase(preg_replace('/[\'´`"]/', '', $explode[0]));		
										}
									} else if($k == AnimationEaseType::CUSTOMWIGGLE) {
										if(count($explode) == 1){
											$nE = new CustomWiggle($explode[0]);		
										}else if(count($explode) == 2){
											if(preg_match('#([\'´`"]?(?:ease(?:\.|-|_)?)?out[\'´`"]?)#i', trim($explode[1]))){
												$explode[1] = 'easeOut';
											} else if(preg_match('#([\'´`"]?(?:ease(?:\.|-|_)?)?in(?:\.|-|_)?out[\'´`"]?)#i', trim($explode[1]))){
												$explode[1] = 'easeInOut';
											} else {
												$explode[1] =  preg_replace('/[\'´`"]/', '', trim($explode[1]));
											}
											$nE = new CustomWiggle($explode[0], $explode[1]);		
										}
									} else {
										if(count($explode) == 1)
											$nE -> config($explode[0]);
										else if(count($explode) == 2)
											$nE -> config($explode[0], $explode[1]);
										else if(count($explode) == 3)
												$nE -> config($explode[0], $explode[1], $explode[2]);	
									}
									
								} else {
									if($k == AnimationEaseType::CUSTOMWIGGLE) {
										$nE = new CustomWiggle();
									}
								}
							}
						}
						self::$_storage[$pEase] = $nE;
						$exist_ease = true;
						break;
					} 
				}
			}
			if(!$exist_ease){
				throw new Exception('Ease '.$pEase.' cannot be interpreted');
			}
			return $nE;
		}

	}

?>
