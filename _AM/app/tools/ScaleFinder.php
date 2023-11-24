<?php
	
	class ScaleFinder {
		public static $precision = 0.00000001;
		public static $iteration = -1;
		public static function find($w, $h, $smin, $smax){
			$c = (($smax - $smin) / 2) + $smin;
			$t = 1;
			$i = 0;
			$pa = array();
			$par = array();
			while(($c >= $smin && $c <= $smax) && ($i < self::$iteration || self::$iteration === -1)) {
				$i++;
				$tw = $w * $c;
				$th = $h * $c;
				if(!(self::contains($tw) || self::contains($th))){
					array_push($par, array('scale' => $c, 'width' => $tw, 'height' => $th));
				} else if((self::g1d($tw) && !self::contains($th)) || (self::g1d($th) && !self::contains($tw))){
					array_push($pa, array('scale' => $c, 'width' => $tw, 'height' => $th));
				}
				$c += ($t % 2 == 0)? ($t++) * self::$precision  : - ( ($t++) * self::$precision)  ;
			}
			if(count($pa) || count($par)) {
				if(count($par)) {
					usort($par, array('ScaleFinder', "sort") );
					var_dump($par);
				} 
				if(count($pa)) {
					usort($pa, array('ScaleFinder', "sort") );
					var_dump($pa);
				} 
				return true;
			} else {
				return false;
			}
		}
		private static function sort($a, $b){
		 	return  ($a == $b) ? 0 : ( ($a < $b) ? -1 : 1 ); 
		}
		private static function contains($p){
		 	return (strpos($p, "." ) !== false) ? true : false;
		}
		private static function g1d($p){
		 	return (preg_match('/\.[1-9]$/', $p)) ? true : false;
		}
	}
	ScaleFinder::$precision *= 100;
	ScaleFinder::find(140, 75, 0.9, 1);

?>