<?php 
	
	/*
 	 * Version: 2.00.0
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	if(!function_exists('set')){
		function set($p, $val){
			global $am;
			
			if($p == 'delay')
				$am -> delay = $val;
		}
	}
	
	if(!function_exists('get')){
		function get($p){
			global $am;
			
			if($p == 'delay')
				return $am -> delay;
		}
	}

	if(!function_exists('delay')){
		function delay(){
			global $am;
			return $am -> delay;
		}
	}

	if(!function_exists('inc')){
		function inc($val){
			global $am;
			$am -> delay += $val;
		}
	}

	if(!function_exists('dec')){
		function dec($val){
			global $am;
			$am -> delay -= $val;
		}
	}

	if(!function_exists('ic')){
		function ic($sel, $iter = 1){
			global $am;
			$am -> prepare($sel) -> useIterationCount($iter);
		}
	}

	if(!function_exists('dr')){
		function dr($sel, $dir = 'normal'){
			global $am;
			$am -> prepare($sel) -> useDirection($dir);
		}
	}	

	if(!function_exists('play')){
		function play($sel, $dur, $label, $ease = 'linear', $animDelay = 0){
			global $am;
			
			if($animDelay !== 0){
				if($label == 'init' || $label == 0)
					return $am -> initialize($sel, $dur, $ease) -> useDelay($animDelay) -> initAnim();
				else if($label == 'exit')
					return $am -> initialize($sel, $dur, $ease) -> useDelay($animDelay) -> closeAnim();
				else
					return $am -> initialize($sel, $dur, $ease) -> useDelay($animDelay) -> playAnim($label);
			} else { 
				if($label == 'init')
					return $am -> initialize($sel, $dur, $ease) -> initAnim();
				else if($label == 'exit')
					return $am -> initialize($sel, $dur, $ease) -> closeAnim();
				else
					return $am -> initialize($sel, $dur, $ease) -> playAnim($label);
			}
		}
	}

	if(!function_exists('stagger')){
		function stagger($sel, $dur, $label, $ease = 'linear', $delay = 0, $animDelay = 0){
			global $am;
			
			if($animDelay !== 0){
				if($label == 'init' || $label == 0)
					return $am -> initialize($sel, $dur, $ease) -> useDelay($animDelay) -> useStagger($delay) -> initAnim();
				else if($label == 'exit')
					return $am -> initialize($sel, $dur, $ease) -> useDelay($animDelay) -> useStagger($delay) -> closeAnim();
				else
					return $am -> initialize($sel, $dur, $ease) -> useDelay($animDelay) -> useStagger($delay) -> playAnim($label);
			} else { 
				if($label == 'init')
					return $am -> initialize($sel, $dur, $ease) -> useStagger($delay) -> initAnim();
				else if($label == 'exit')
					return $am -> initialize($sel, $dur, $ease) -> useStagger($delay) -> closeAnim();
				else
					return $am -> initialize($sel, $dur, $ease) -> useStagger($delay) -> playAnim($label);
			}
		}
	}

	if(!function_exists('chain')){
		function chain($sel, $dur, $label, $ease  = 'linear' , $delay = 0, $animDelay = 0){
			global $am;
			
			if($animDelay !== 0){
				if($label == 'init' || $label == 0)
					return $am -> chain($sel, $dur, $ease, $delay) -> useDelay($animDelay) -> initAnim();
				else if($label == 'exit')
					return $am -> chain($sel, $dur, $ease, $delay) -> useDelay($animDelay) -> closeAnim();
				else
					return $am -> chain($sel, $dur, $ease, $delay) -> useDelay($animDelay) -> playAnim($label);
			} else { 
				if($label == 'init')
					return $am -> chain($sel, $dur, $ease, $delay) -> initAnim();
				else if($label == 'exit')
					return $am -> chain($sel, $dur, $ease, $delay) -> closeAnim();
				else
					return $am -> chain($sel, $dur, $ease, $delay) -> playAnim($label);
			}
		}
	}

	if(!function_exists('ease')){
		function ease($value){
			return AnimationEaseFactory::get($value);
		}
	}


	


	
?>