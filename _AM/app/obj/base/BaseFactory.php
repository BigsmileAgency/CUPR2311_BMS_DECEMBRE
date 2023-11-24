<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	final class BaseFactory {



		public static function get($name){
			if(!preg_match('/^(?:[a-zA-Z0-9]+\:)?(?:[a-zA-Z0-9]+)(?:\((.*?)\))?$/', $name)){
				throw new Exception(__CLASS__.': '.$name.' is invalid base');
				die();
			}
			if(preg_match('/^(?:(?:time)|(?:immediateRender)|(?:delay)|(?:ease)|(?:duration))(?:\((.*?)\))?$/i', $name)){
				throw new Exception(__CLASS__.': '.$name.' is invalid base');
				die();
			}


			if(preg_match('/^((?:[a-zA-Z0-9]+\:)?)([a-zA-Z0-9]+)\((.*?)\)$/', $name, $m)){

				$b = new AnimationBase();

				if(strtolower($m[2]) == 'translatex' || strtolower($m[2]) == 'x'){
					if($m[3] == '%'){
						$m[2] = 'xPercent';
						$m[3] = '';
					}
					else {
						$m[2] = 'x';
					}
				}
				if(strtolower($m[2]) == 'translatey' || strtolower($m[2]) == 'y'){
					if($m[3] == '%'){
						$m[2] = 'yPercent';
						$m[3] = '';
					}
					else {
						$m[2] = 'y';
					}
				}
				if(strtolower($m[2]) == 'translatez' || strtolower($m[2]) == 'z'){
					if($m[3] == '%'){
						$m[2] = 'zPercent';
						$m[3] = '';
					}
					else {
						$m[2] = 'z';
					}
				}

				if(strtolower($m[2]) == 'posx')
					$m[2] = 'left';
				if(strtolower($m[2]) == 'posy')
					$m[2] = 'top';


				$n_m = strtolower(substr( $m[2] , 0 , 1)) . substr( $m[2] , 1 );
				if(trim($m[1]) !== ''){
					$n_m = strtolower(substr( $m[1] , 0 , 1)) . substr( $m[1] , 1 ). $n_m;
				} 
				


				$p1 = new Property($n_m, array(new Prefix(PrefixType::NORMAL)), PropertyType::SINGLE);

				$m[3] = trim($m[3]);

				if($m[3] == "px")
					$ut = UnitType::PIXEL;
				elseif($m[3] == "pt")
					$ut = UnitType::POINT;
				elseif($m[3] == "pc")
						$ut = UnitType::PICAS;
				elseif($m[3] == "em")
					$ut = UnitType::EM;
				elseif($m[3] == "rem")
					$ut = UnitType::REM;
				elseif($m[3] == "%")
					$ut = UnitType::PERCENT;
				elseif($m[3] == "cm")
					$ut = UnitType::CENTIMETER;
				elseif($m[3] == "mm")
					$ut = UnitType::MILLIMETER;
				elseif($m[3] == "in")
					$ut = UnitType::INCH;
				elseif($m[3] == "deg")
						$ut = UnitType::DEG;
				elseif($m[3] == "rad")
						$ut = UnitType::RAD;
				elseif($m[3] == "")
						$ut = UnitType::NO_UNIT;

				$p1 -> add(array(new SingleValue(new PropertyValue($name, NULL, $ut, 0, 0))));
				$b -> add(array($p1));
			} else if(preg_match('/^((?:[a-zA-Z0-9]+\:)?)([a-zA-Z0-9]+)$/', $name, $m)){

				if(strtolower($m[2]) == 'translatex' || strtolower($m[2]) == 'x'){
					$m[2] = 'x';
				}
				if(strtolower($m[2]) == 'translatey' || strtolower($m[2]) == 'y'){
					$m[2] = 'y';
				}
				if(strtolower($m[2]) == 'translatez' || strtolower($m[2]) == 'z'){
					$m[2] = 'z';
				}

				if(strtolower($m[2]) == 'posx')
					$m[2] = 'left';
				if(strtolower($m[2]) == 'posy')
					$m[2] = 'top';

				$new_name = strtolower(substr($m[2] , 0 , 1)) .substr( $m[2] , 1 );

				if(trim($m[1]) !== ''){
					$new_name = strtolower(substr( $m[1] , 0 , 1)) . substr( $m[1] , 1 ). $new_name;
				} 

			 	$b = new AnimationBase();
				$p1 = new Property($new_name, array(new Prefix(PrefixType::NORMAL)), PropertyType::SINGLE);
				$p1 -> add(array(new SingleValue(new PropertyValue($name, NULL, UnitType::NO_UNIT, 0, 0))));
				$b -> add(array($p1));

			 }



			return $b;
		}


	}

?>
