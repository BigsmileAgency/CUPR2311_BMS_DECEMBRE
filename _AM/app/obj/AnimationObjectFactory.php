<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class AnimationObjectFactory {
		
		/**
		 * @constructor
		 */
		public static function create($pName, $pIsId = false){
			if(is_array($pName)){
				$arrayReturn = array();
				foreach($pName as $obj){
					$nObj = $pIsId ? ($r = new AnimationObject(strval($obj), '#'.strval($obj), '#'.strval($obj), '#'.strval($obj))) :  ($r = new AnimationObject(strval($obj)));
					array_push($arrayReturn, $nObj);
				}
				return $arrayReturn;
			} else {
				return $pIsId ? ($r = new AnimationObject(strval($pName), '#'.strval($pName), '#'.strval($pName), '#'.strval($pName))) :  ($r = new AnimationObject(strval($pName)));
			}
		}
		
	}
	
?>