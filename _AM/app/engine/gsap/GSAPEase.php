<?php 
	
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */
 
	
	final class GSAPEase {
		
		private $_ease;
		
		public function __construct(AnimationEase $pEase){
			$this -> _ease = $pEase;
		}
		
		public function config(){
			return $this -> _ease -> getConfig();
		}

		public function ease(){
			return $this -> _ease;
		}

		public function getValue(){
			$type = $this -> _ease -> getType();
			$val = "";
			switch($type){
				case AnimationEaseType::LINEAR :
					$val .= $type;
					break;
				case AnimationEaseType::EASE :
					$val .= $type;
					break;	
				case AnimationEaseType::EASEIN :
					$val .= $type;
					break;	
				case AnimationEaseType::EASEOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::EASEINOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::BEZIER :
					$val .="new Ease(BezierEasing(";
					$val .= implode(", ",$this -> _ease -> getCubicArray());
					$val .="))";
					break;
				case AnimationEaseType::QUAD_IN :
					$val .= $type;
					break;
				case AnimationEaseType::QUAD_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::QUAD_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::CUBIC_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::CUBIC_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::CUBIC_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::QUART_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::QUART_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::QUART_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::QUINT_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::QUINT_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::QUINT_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::STRONG_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::STRONG_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::STRONG_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::SINE_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::SINE_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::SINE_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::EXPO_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::EXPO_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::EXPO_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::CIRC_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::CIRC_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::CIRC_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::BACK_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::BACK_OUT :
					$val .= $type;
					break;	
				case AnimationEaseType::BACK_INOUT :
					$val .= $type;
					break;	
				case AnimationEaseType::ELASTIC_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::ELASTIC_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::ELASTIC_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::BOUNCE_IN :
					$val .= $type;
					break;	
				case AnimationEaseType::BOUNCE_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::BOUNCE_INOUT :
					$val .= $type;
					break;

				case AnimationEaseType::POWER0 :
					$val .= $type;
					break;
				case AnimationEaseType::POWER1_IN :
					$val .= $type;
					break;
				case AnimationEaseType::POWER1_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER1_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER2_IN :
					$val .= $type;
					break;
				case AnimationEaseType::POWER2_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER2_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER3_IN :
					$val .= $type;
					break;
				case AnimationEaseType::POWER3_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER3_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER4_IN :
					$val .= $type;
					break;
				case AnimationEaseType::POWER4_INOUT :
					$val .= $type;
					break;
				case AnimationEaseType::POWER4_OUT :
					$val .= $type;
					break;
				case AnimationEaseType::SLOWMO :
					$val .= $type;
					break;
				case AnimationEaseType::STEPPED :
					$val .= $type;
					break;
				case AnimationEaseType::CUSTOMEASE :
					$val .= GSAPEngine::$quotes.$this -> _ease -> name().GSAPEngine::$quotes;
					break;
				case AnimationEaseType::CUSTOMWIGGLE :
					$val .= GSAPEngine::$quotes.$this -> _ease -> name().GSAPEngine::$quotes;
					break;
				case AnimationEaseType::CUSTOMBOUNCE :
					$val .= GSAPEngine::$quotes.$this -> _ease -> name().GSAPEngine::$quotes;
					break;
				case AnimationEaseType::SQUASHBOUNCE :
					$val .= GSAPEngine::$quotes.$this -> _ease -> name().GSAPEngine::$quotes;
					break;
				//STANDBY

				/*
				case AnimationEaseType::CUSTOMBOUNCE :
					$val .= $type;
					break;
				

				case AnimationEaseType::ROUGH :
					$val .= $type;
					break;*/
				default :
					$val .= $type;
					break;
			}
			
			return $val;
		}
		
	
	}

?>