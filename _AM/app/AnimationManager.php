<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	final class AnimationManager {

		protected $_objs;
		protected $_data;
		protected $_delay;
		protected $_cursor;
		protected $_cursor_obj;
		protected $_version;
		protected $_copyright;
		protected $_type_list;
		protected $_default_suffix_list;
		protected $_select_multiple;
		protected $_animation_scheme = array();
		protected $_chain_mode;
		protected $_chain_objs;
		protected $_chain_duration_value;
		protected $_obj_n = 1;
		protected $_generated = false;
		protected $_secure_end_animation = false;


		protected $_prefix_init;
		protected $_prefix_anim;
		protected $_prefix_exit;
		protected $_native_props = array('move' => array('PosX','PosY','Left','Right','Top','Bottom'),
										'fade' => array('Alpha'),
										'size' => array('Width','Height'),
										'perspective' => array('Perspective'),
										'translate' => array('TranslateX','TranslateY','X','Y'),
										'translate3d' => array('TranslateX','TranslateY','TranslateZ','X','Y','Z'),
										'scale' => array('ScaleX','ScaleY','Scale'),
										'scale3d' => array('ScaleX','ScaleY','ScaleZ','Scale'),
										'rotation' => array('Rotation'),
										'rotation3d' => array('RotationX','RotationY','RotationZ','Rotation'),
										'skew' => array('SkewX','SkewY'));

		protected static $auto_place = true;
		protected static $transformToMatrix = false;


		/**
		 * @constructor
		 *
		 * @param 'DataObject' Les données des objets qui seront stockés dans le gestionnaire.
		 */
		public function __construct(DataObject $pData = NULL){

			$this -> _cursor = array();
			$this -> _cursor_obj = array();
			$this -> _reset_modes();

			$this -> _prefix_init = "init";
			$this -> _prefix_anim = "anim";
			$this -> _prefix_exit = "exit";

			$this -> _type_list = array("move","fade","size","scale","skew","rotation","translate","translate3d","scale3d","rotation3d","global_rotation3d","matrix","perspective","matrix3d");
			$this -> _default_suffix_list = array();

			$this -> _default_suffix_list["move"] = "";
			$this -> _default_suffix_list["fade"] = "";
			$this -> _default_suffix_list["size"] = "";
			$this -> _default_suffix_list["scale"] = "";
			$this -> _default_suffix_list["skew"] = "";
			$this -> _default_suffix_list["rotation"] = "";
			$this -> _default_suffix_list["translate"] = "";
			$this -> _default_suffix_list["translate3d"] = "";
			$this -> _default_suffix_list["scale3d"] = "";
			$this -> _default_suffix_list["rotation3d"] = "";
			$this -> _default_suffix_list["global_rotation3d"] = "";
			$this -> _default_suffix_list["matrix"] = "";
			$this -> _default_suffix_list["perspective"] = "";
			$this -> _default_suffix_list["matrix3d"] = "";

			if(!is_null($pData))
				$this -> setData($pData);
			$this -> _objs = array();
			$this -> _version = "v2.01.10";
			$this -> _copyright = '© Copyright 2018 - Big Smile Agency';
		}

		public function setData(DataObject $pData){
			$this -> _data = $pData;
			if(self::$auto_place === true){
				$obj = $this -> _data -> getContent();
				foreach($obj as $k => $o){
					if(is_array($o) && count($o)){

						$placements = null;
						$attachements = array();

						foreach($o as $k2 => $o2){

							//on doit checker les props 3d
							if((in_array($k2, $this -> _native_props['translate3d']) ||
								in_array($k2, $this -> _native_props['scale3d']) ||
								in_array($k2, $this -> _native_props['rotation3d']) ||
								in_array($k2, $this -> _native_props['skew']) ||
								in_array($k2, $this -> _native_props['perspective']) ||
								in_array($k2, $this -> _native_props['rotation']))
								&& (isset($o['TranslateZ']) ||
									isset($o['Z']) ||
									isset($o['ScaleZ']) ||
									isset($o['RotationX']) ||
									isset($o['RotationY']) ||
									isset($o['RotationZ']))){


									$allow_matrix = $this -> _can_has_matrix('3d', $o);

									//propriété 3d
									if(!self::$transformToMatrix || $this -> has_custom_transforms('3d', $o) || $this -> has_custom_transforms('2d', $o) || !$allow_matrix){
										if(preg_match('/^Translate/', $k2) || strtolower($k2) == 'x' || strtolower($k2) == 'y' || strtolower($k2) == 'z') {
											$placements |= AnimationType::TRANSLATE3D;
										} else if(preg_match('/^Scale/', $k2)){
											$placements |= AnimationType::SCALE3D;
										} else if(preg_match('/^Rotation/', $k2)){
											$placements |= AnimationType::ROTATION3D;
										} else if(preg_match('/^Skew/', $k2)){
											$placements |= AnimationType::SKEW;
										} else if(preg_match('/^Perspective/', $k2)){
											$placements |= AnimationType::PERSPECTIVE;
										}

									} else {
										if(preg_match('/^Perspective/', $k2)){
											$placements |= AnimationType::PERSPECTIVE;
										} else {
											$placements |= AnimationType::TRANSFORM3D_TO_MATRIX;
										}
									}



							} elseif((in_array($k2, $this -> _native_props['translate']) ||
								in_array($k2, $this -> _native_props['scale']) ||
								in_array($k2, $this -> _native_props['skew']) ||
								in_array($k2, $this -> _native_props['perspective']) ||
								in_array($k2, $this -> _native_props['rotation']))) {

								$allow_matrix = $this -> _can_has_matrix('2d', $o);

								//propriété 2d
								if(!self::$transformToMatrix || $this -> has_custom_transforms('2d', $o) || $this -> has_custom_transforms('3d', $o) || !$allow_matrix){
									if(preg_match('/^Translate/', $k2) || strtolower($k2) == 'x' || strtolower($k2) == 'y') {
											$placements |= AnimationType::TRANSLATE;
									} else if(preg_match('/^Scale/', $k2)){
										$placements |= AnimationType::SCALE;
									} else if(preg_match('/^Rotation/', $k2)){
										$placements |= AnimationType::ROTATION;
									} else if(preg_match('/^Skew/', $k2)){
										$placements |= AnimationType::SKEW;
									} else if(preg_match('/^Perspective/', $k2)){
										$placements |= AnimationType::PERSPECTIVE;
									}
								} else {
									if(preg_match('/^Perspective/', $k2)){
										$placements |= AnimationType::PERSPECTIVE;
									}
									else {
										$placements |= AnimationType::TRANSFORM_TO_MATRIX;
									}
								}
							} elseif(in_array($k2, $this -> _native_props['fade'])){
								$placements |= AnimationType::FADE;
							} elseif(in_array($k2, $this -> _native_props['size'])){
								$placements |= AnimationType::SIZE;
							} elseif(in_array($k2, $this -> _native_props['move'])){
								$placements |= AnimationType::MOVE;
							} else {
								$b = BaseFactory::get($k2);
								if($b != false)
									array_push($attachements, $b);
							}
						}

						if(!count($attachements))
							$this -> place(new AnimationObject('obj_'.($this -> _obj_n++), $k, $k, $k), $placements);
						else
							$this -> place(new AnimationObject('obj_'.($this -> _obj_n++), $k, $k, $k), $placements) -> attach($attachements);



					}

				}
			}

		}

		/**
		 * @method
		 *
		 * Place un objet dans le gestionnaire d'animation.
		 *
		 * @param '*' L'objet ou les objets qui seront animés. Des informations.
		 * @param 'int' Le type d'animation qui sera appliqué à l'objet stocké. S'utilise grâce aux constantes dans AnimationType. Plusieurs constantes peuvent être utilisées en les séparant par |.
		 */
		protected function place($pObjects, $pAnimType = NULL){

			$this -> _cursor_obj = array();
			$this -> _cursor = array();
			$this -> _reset_modes();

			if(is_array($pObjects)){
				$this -> _select_multiple = true;
				foreach($pObjects as $obj){
					if($obj instanceof AnimationObjectCollection){
						$this -> _placeCollection($obj, $pAnimType);
					} else if($obj instanceof AnimationObject) {
						$this -> _place($obj, $pAnimType);
					} else {
						$this -> _place(new AnimationObject($obj), $pAnimType);
					}
				}
			} else if($pObjects instanceof AnimationObjectCollection) {
				$this -> _select_multiple = true;
				$this -> _placeCollection($pObjects, $pAnimType);
			} else if($pObjects instanceof AnimationObject) {
				$this -> _select_multiple = false;
				$this -> _place($pObjects, $pAnimType);
			} else {
				$this -> _select_multiple = false;
				$this -> _place(new AnimationObject($pObjects), $pAnimType);
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Place un objet dans le gestionnaire d'animation.
		 *
		 * @param 'AnimationObject' L'objet qui sera animé. Des informations.
		 * @param 'int' Le type d'animation qui sera appliqué à l'objet stocké. S'utilise grâce aux constantes dans AnimationType. Plusieurs constantes peuvent être utilisées en les séparant par |.
		 */
		protected function _place(AnimationObject $pObject, $pAnimType = NULL){

			if(is_string($pAnimType)){
				$pAnimType = $this -> _convert_alias_types($pAnimType);
			}

			$pObject -> setAnimationType($pAnimType);

			if($pAnimType	!== 0){
				foreach($this -> _type_list as $v){
					if($this -> _testType($v ,$pAnimType, $pAnimType)){
						$types = $pObject -> getAllowedTypes();
						array_push($types, $v);
						$pObject -> setAllowedTypes($types);
						$pObject -> setSuffixValue($v, $this-> _default_suffix_list[$v]);
					}
				}
			}

			if(!$this -> _find($pObject -> getSelector())){
				array_push($this -> _objs, $pObject);
			}
			else {
				throw new Exception($this -> _version.": An object with the name '".$pObject -> getSelector()."' is already placed in the manager at _place()");
				die();
			}

			if($this -> _select_multiple){
				$this -> _cursor_obj[] = $pObject;
				$this -> _cursor[] = count($this -> _objs) - 1;
			} else {
				$this -> _cursor_obj = array($pObject);
				$this -> _cursor = array(count($this -> _objs) - 1);
			}

			$this -> _objs[(count($this -> _objs) - 1)] -> setAnimationData($this -> _data -> parse($pObject));

			return $this;
		}

		/**
		 * @method
		 *
		 * Place une collection d'objets dans le gestionnaire d'animation.
		 *
		 * @param 'AnimationObjectCollection' La collection d'objets qui seront animés.
		 * @param 'int' Le type d'animation qui sera appliqué à l'ensemble d'objets stockés. S'utilise grâce aux constantes dans AnimationType. Plusieurs constantes peuvent être utilisées en les séparant par |.
		 */
		protected function _placeCollection(AnimationObjectCollection $pObjectCollection, $pAnimType = NULL){

			if(is_string($pAnimType)){
				$pAnimType = $this -> _convert_alias_types($pAnimType);
			}


			$objs = $pObjectCollection -> getObjects();
			if(count($objs)){
				foreach($objs as $obj){
					$obj -> setAnimationType($pAnimType);
					if($pAnimType	!== 0){
						foreach($this -> _type_list as $v){
							if($this -> _testType($v ,$pAnimType, $pAnimType)){
								$types = $obj -> getAllowedTypes();
								array_push($types, $v);
								$obj -> setAllowedTypes($types);
								$obj -> setSuffixValue($v, $this-> _default_suffix_list[$v]);
							}
						}
					}
					if(!$this -> _find($obj -> getSelector())){
						array_push($this -> _objs, $obj);
					}
					else {
						throw new Exception($this -> _version.": An object with the name '".$obj -> getSelector()."' is already placed in the manager at _placeCollection()");
						die();

					}

					if($this -> _select_multiple){
						$this -> _cursor_obj[] = $obj;
						$this -> _cursor[] = count($this -> _objs) - 1;
					} else {
						$this -> _cursor_obj = array($obj);
						$this -> _cursor = array(count($this -> _objs) - 1);
					}
					$this -> _objs[(count($this -> _objs) - 1)] -> setAnimationData($this -> _data -> parse($obj));
				}
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Prépare un objet stocké dans le gestionnaire d'animation.
		 *
		 * @param '*' L'objet qui sera préparé. Son index sera stocké au curseur. Il doit être stocké dans le gestionnaire grâce à la méthode 'place'.
		 */
		public function prepare($pObjects){

			$this -> _cursor_obj = array();
			$this -> _cursor = array();
			$this -> _reset_modes();

			if(is_array($pObjects)){
				$this -> _select_multiple = true;
				foreach($pObjects as $obj){
					if($obj instanceof AnimationObjectCollection){
						$this -> _prepareCollection($obj);
					} else if($obj instanceof AnimationObject) {
						$this -> _prepare($obj);
					} else {
						$objf = $this -> _find($obj);
						$this -> _prepare($objf);
					}
				}
			} else if($pObjects instanceof AnimationObjectCollection) {
				$this -> _select_multiple = true;
				$this -> _prepareCollection($pObjects);
			} else if($pObjects instanceof AnimationObject) {
				$this -> _select_multiple = false;
				$this -> _prepare($pObjects);
			} else {
				$this -> _select_multiple = false;
				$objf = $this -> _find($pObjects);
				$this -> _prepare($objf);
			}
			return $this;

		}

		/**
		 * @method
		 *
		 * Prépare un objet stocké dans le gestionnaire d'animation.
		 *
		 * @param 'AnimationObject' L'objet qui sera préparé. Son index sera stocké au curseur. Il doit être stocké dans le gestionnaire grâce à la méthode 'place'.
		 */
		protected function _prepare(AnimationObject $pObject){
			$ai = $this -> _getArrayIndex($pObject);
			if(is_int($ai)){
				if($this -> _select_multiple){
					$this -> _cursor_obj[] = $pObject;
					$this -> _cursor[] = $ai;
				} else {
					$this -> _cursor_obj = array($pObject);
					$this -> _cursor = array($ai);
				}
			} else {
				throw new Exception($this -> _version.": No item found at _prepare()");
				die();
			}
			return $this;
		}


		/**
		 * @method
		 *
		 * Prépare une collection d'objets stockée dans le gestionnaire d'animation.
		 *
		 * @param 'AnimationObjectCollection' La collection d'objets qui sera préparée. Les indexs seront stockés au curseur. Ils doivent être stockés dans le gestionnaire grâce à la méthode 'place'.
		 */
		protected function _prepareCollection(AnimationObjectCollection $pObject){
			$objs = $pObjectCollection -> getObjects();
			if(count($objs)){
				foreach($objs as $obj){
					$ai = $this -> _getArrayIndex($obj);
					if(is_int($ai)){
						if($this -> _select_multiple){
							$this -> _cursor_obj[] = $pObject;
							$this -> _cursor[] = $ai;
						} else {
							$this -> _cursor_obj = array($pObject);
							$this -> _cursor = array($ai);
						}
					} else {
							throw new Exception($this -> _version.": An item in collection not found at _prepareCollection()");
							die();
					}
				}
			} else {
				throw new Exception($this -> _version.": Empty collection at _prepareCollection()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Attache une base ou plusieur comprenant une/plusieur propriétés.
		 *
		 * @param '*' La base ou les bases.
		 */
		protected function attach($pBases){
			if(count($this -> _cursor_obj)){
				//foreach($this -> _cursor_obj as $cO){
					if(is_array($pBases)){
						foreach($pBases as $base){
							if($base instanceof BaseCollection){
								$this -> _attachCollection($base);
							} else {
								$this -> _attach($base);
							}
						}
					} else if($pBases instanceof BaseCollection) {
						$this -> _attachCollection($pBases);
					} else {
						$this -> _attach($pBases);
					}
				//}
			}else {
				throw new Exception($this -> _version.": No item selected at attach()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Attache une base comprenant une/plusieur propriétés.
		 *
		 * @param 'AnimationBase' La base.
		 */
		protected function _attach(AnimationBase $pBase){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$bases = $cO -> getBases();
					$bases -> add($pBase);
					$cO -> setBases($bases);
					//$cO -> setAnimationData($this -> _initBaseValues($cO));
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at _attach()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Attache une collection de bases comprenant une/plusieur propriétés.
		 *
		 * @param 'BaseCollection' L'ensemble de base.
		 */
		protected function _attachCollection(BaseCollection $pBases){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$bases = $cO -> getBases();
					$bases_2 = $pBases -> getObjects();
					foreach($base_2 as $base){
						$bases -> add($base);
					}
					$cO -> setBases($bases);
					//$cO -> setAnimationData($this -> _initBaseValues($cO));
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at _attachCollection()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Défini le type de la valeur pour le(s) type(s) de l'animation. 'px', '%', 'pt', 'em', 'cm' par exemple.
		 *
		 * @param 'int' Un ou plusieurs types d'animation séparés par |.
		 * @param 'string' Le suffixe utilisé pour les types séléctionnés.
		 */
		protected function suffixValue($pAnimType, $pSuffix){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$oAnimType = $cO -> getAnimationType();
					if(is_string($pSuffix)){
						if($pAnimType !== 0){
							foreach($this -> _type_list as $v){
								if($this -> _testType($v ,intval($pAnimType), intval($oAnimType))){
									$cO -> setSuffixValue($v, $pSuffix);
								}

							}
							$this -> _objs[$this -> _cursor[$i]] = $cO;
						}
					} else {
						throw new Exception($this -> _version.": Param is not a String at suffix_value()");
						die();
					}
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at suffix_value()");
				die();
			}
		}

		/**
		 * @method
		 *
		 * Prépare un objet stocké dans le gestionnaire d'animation et rajoute des données (durée & interpolation) pour sa prochaine animation lancée par 'playAnim' ou 'closeAnim'.
		 *
		 * @param '*' L'objet qui sera préparé pour la prochaine animation. Il doit être stocké dans le gestionnaire grâce à la méthode 'place'.
		 * @param 'int' La durée en seconde de la prochaine animation de l'objet préparé.
		 * @param 'AnimationEase' L'interpolation de la prochaine animation de l'objet préparé.
		 */
		public function initialize($pObjects, $pDuration, $pEase = 'linear'){

			if(!is_numeric($pDuration)){
				throw new Exception($this -> _version.": duration is not a numeric value at initialize()");
				die();
			} else if($pDuration < 0){
				throw new Exception($this -> _version.": duration cannot be negative value at initialize()");
				die();
			}

			$this -> _cursor_obj = array();
			$this -> _cursor = array();
			$this -> _reset_modes();

			if(is_string($pEase)){
				$pEase = $this -> _convert_alias_ease($pEase);
			}

			if(is_array($pObjects)){
				$this -> _select_multiple = true;
				foreach($pObjects as $obj){
					if($obj instanceof AnimationObjectCollection){
						$this -> _initializeCollection($obj, $pDuration, $pEase);
					} else if($obj instanceof AnimationObject) {
						$this -> _initialize($obj, $pDuration, $pEase);
					} else {
						$objf = $this -> _find($obj);
						$this -> _initialize($objf, $pDuration, $pEase);
					}
				}
			} else if($pObjects instanceof AnimationObjectCollection) {
				$this -> _select_multiple = true;
				$this -> _initializeCollection($pObjects, $pDuration, $pEase);
			} else if($pObjects instanceof AnimationObject) {
				$this -> _select_multiple = false;
				$this -> _initialize($pObjects, $pDuration, $pEase);
			} else {
				$this -> _select_multiple = false;
				$objf = $this -> _find($pObjects);
				$this -> _initialize($objf, $pDuration, $pEase);
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Prépare une séquence d'objet à animer par un interval.
		 *
		 * @param '*' Les objets qui seront animés.
		 * @param 'int' La durée en seconde de la prochaine animation de l'objet préparé.
		 * @param 'AnimationEase' L'interpolation de la prochaine animation de l'objet préparé.
		 * @param 'int' Interval entre chaque élément.
		 */
		public function chain($pObjects, $pDuration, $pEase = 'linear', $pDelayIteration = 0){

			if(!is_numeric($pDuration)){
				throw new Exception($this -> _version.": duration is not a numeric value at chain()");
				die();
			} else if($pDuration < 0){
				throw new Exception($this -> _version.": duration cannot be negative value at chain()");
				die();
			}

			$this -> _cursor_obj = array();
			$this -> _cursor = array();

			$this -> _reset_modes();
			$this -> _chain_mode = true;
			$this -> _chain_duration_value = $pDelayIteration;
			$i = 0;

			if(is_string($pEase)){
				$pEase = $this -> _convert_alias_ease($pEase);
			}

			if(is_array($pObjects)){


				$this -> _select_multiple = true;
				foreach($pObjects as $obj){
					if($obj instanceof AnimationObjectCollection){
						$this -> _initializeCollection($obj, $pDuration, $pEase, $this -> _delay + ($i * $pDelayIteration));
					} else if($obj instanceof AnimationObject) {
						$this -> _initialize($obj, $pDuration, $pEase, $this -> _delay + ($i * $pDelayIteration));
					} else {
						$obj = $this -> _find($obj);
						$this -> _initialize($obj, $pDuration, $pEase, $this -> _delay + ($i * $pDelayIteration));
					}
					array_push($this -> _chain_objs, $obj);
					$i++;
				}
			} else if($pObjects instanceof AnimationObjectCollection) {
				$this -> _select_multiple = true;
				$objs = $pObjectCollection -> getObjects();
				if(count($objs)){
					foreach($objs as $obj){
						$this -> _initialize($obj, $pDuration, $pEase, $this -> _delay + ($i * $pDelayIteration));
						array_push($this -> _chain_objs, $obj);
						$i++;
					}
				}
			} else if($pObjects instanceof AnimationObject) {
				$this -> _reset_modes();
				$this -> _initialize($pObjects, $pDuration, $pEase);
			} else {
				$this -> _reset_modes();
				$obj = $this -> _find($pObjects);
				$this -> _initialize($obj, $pDuration, $pEase);
			}
			return $this;
		}



		/**
		 * @method
		 *
		 * Prépare un objet stocké dans le gestionnaire d'animation et rajoute des données (durée & interpolation) pour sa prochaine animation lancée par 'playAnim' ou 'closeAnim'.
		 *
		 * @param 'AnimationObject' L'objet qui sera préparé pour la prochaine animation. Il doit être stocké dans le gestionnaire grâce à la méthode 'place'.
		 * @param 'int' La durée en seconde de la prochaine animation de l'objet préparé.
		 * @param 'AnimationEase' L'interpolation de la prochaine animation de l'objet préparé.
		 */
		protected function _initialize(AnimationObject $pObject, $pDuration, $pEase  = NULL, $pDelay = NULL){
			$ai = $this -> _getArrayIndex($pObject);
			$pDelay = $pDelay === NULL ? $this -> _delay : floatval($pDelay);
			if(is_int($ai)){
				//$pDuration = $pDuration > 0 ? $pDuration : 0.01;
				$this -> _objs[$ai] -> setTemporary("duration", $pDuration);
				$this -> _objs[$ai] -> setTemporary("delay", $pDelay);
				$this -> _objs[$ai] -> setTemporary("ease", $pEase);
				$this -> _objs[$ai] -> setTemporary("stagger_delay", NULL);

				if($this -> _select_multiple){
					$this -> _cursor_obj[] = $pObject;
					$this -> _cursor[] = $ai;
				} else {
					$this -> _cursor_obj = array($pObject);
					$this -> _cursor = array($ai);
				}
			} else {
				throw new Exception($this -> _version.": No item found at _initialize()");
				die();
			}
			return $this;
		}


		/**
		 * @method
		 *
		 * Prépare une collection d'objets stockée dans le gestionnaire d'animation et rajoute des données (durée & interpolation) pour sa prochaine animation lancée par 'playAnim' ou 'closeAnim'.
		 *
		 * @param 'AnimationObjectCollection' La collection d'objets qui sera préparé pour la prochaine animation. Ils doivent être stockés dans le gestionnaire grâce à la méthode 'place'.
		 * @param 'int' La durée en seconde de la prochaine animation de l'objet préparé.
		 * @param 'AnimationEase' L'interpolation de la prochaine animation de l'objet préparé.
		 */
		protected function _initializeCollection(AnimationObjectCollection $pObject, $pDuration, $pEase = NULL, $pDelay = NULL){
			$objs = $pObjectCollection -> getObjects();
			$pDelay = $pDelay === NULL ? $this -> _delay : floatval($pDelay);
			if(count($objs)){
				foreach($objs as $obj){
					$ai = $this -> _getArrayIndex($obj);
					if(is_int($ai)){
						$this -> _objs[$ai] -> setTemporary("duration", $pDuration);
						$this -> _objs[$ai] -> setTemporary("delay", $pDelay);
						$this -> _objs[$ai] -> setTemporary("ease", $pEase);
						if($this -> _select_multiple){
							$this -> _cursor_obj[] = $pObject;
							$this -> _cursor[] = $ai;
						} else {
							$this -> _cursor_obj = array($pObject);
							$this -> _cursor = array($ai);
						}
					} else {
						throw new Exception($this -> _version.": An item in collection not found at _initializeCollection()");
						die();
					}
				}
			} else {
				throw new Exception($this -> _version.": Empty collection at _initializeCollection()");
				die();
			}

			return $this;
		}


		/**
		 * @method
		 *
		 * Lance le processus d'animation d'un objet préparé (placé dans le curseur) et initialisé. Dépend du moteur (engine).
		 *
		 * @param 'int' L'étape lancée (numéro de l'animation). anim(n){Prop}.
		 */
		public function playAnim($pStep){
			if(count($this -> _cursor_obj)){
				$this -> _addAnimation($this -> _prefix_anim.$pStep);
			} else {
				throw new Exception($this -> _version.": No item selected at playAnim()");
				die();
			}
			return $this;
		}



		/**
		 * @method
		 *
		 * Lance le processus d'animation d'un objet préparé (placé dans le curseur) et initialisé. Dépend du moteur (engine).
		 *
		 */
		public function initAnim(){
			if(count($this -> _cursor_obj)){
				$this -> _addAnimation($this -> _prefix_init);
			} else {
				throw new Exception($this -> _version.": No item selected at initAnim()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Lance le processus d'animation d'un objet préparé (placé dans le curseur) et initialisé. Utilise la valeur dans exit{Prop}. Dépend du moteur (engine).
		 */
		public function closeAnim(){
			if(count($this -> _cursor_obj)){
				$this -> _addAnimation($this -> _prefix_exit);
			} else {
				throw new Exception($this -> _version.": No item selected at closeAnim()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Initialise les valeurs d'un objet préparé (placé dans le curseur) dans init{Prop} avec les valeurs initiales par défaut (majoritairement à 0).
		 */
		protected function init(){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$animType = $cO -> getAnimationType();
					$animData = $cO -> getAnimationData();

					if($this -> _testType("move", $animType, $animType)){
						$animData[$this -> _prefix_init."PosX"] = 0;
						$animData[$this -> _prefix_init."PosY"] = 0;
					}
					if($this -> _testType("fade", $animType, $animType)){
						$animData[$this -> _prefix_init."Fade"] = 0;
					}
					if($this -> _testType("size", $animType, $animType)){
						$animData[$this -> _prefix_init."Width"] = 0;
						$animData[$this -> _prefix_init."Height"] = 0;
					}
					if($this -> _testType("skew", $animType, $animType)){
						$animData[$this -> _prefix_init."SkewX"] = 0;
						$animData[$this -> _prefix_init."SkewY"] = 0;
					}
					if($this -> _testType("rotation", $animType, $animType)){
						$animData[$this -> _prefix_init."Rotation"] = 0;
					}
					if($this -> _testType("rotation3d", $animType, $animType)){
						$animData[$this -> _prefix_init."RotationX"] = 0;
						$animData[$this -> _prefix_init."RotationY"] = 0;
						$animData[$this -> _prefix_init."RotationZ"] = 0;
					}
					if($this -> _testType("global_rotation3d", $animType, $animType)){
						$animData[$this -> _prefix_init."RotationX"] = 0;
						$animData[$this -> _prefix_init."RotationY"] = 0;
						$animData[$this -> _prefix_init."RotationZ"] = 0;
						$animData[$this -> _prefix_init."Angle"] = 0;
					}
					if($this -> _testType("translate", $animType, $animType)){
						$animData[$this -> _prefix_init."TranslateX"] = 0;
						$animData[$this -> _prefix_init."TranslateY"] = 0;
					}
					if($this -> _testType("translate3d", $animType, $animType)){
						$animData[$this -> _prefix_init."TranslateX"] = 0;
						$animData[$this -> _prefix_init."TranslateY"] = 0;
						$animData[$this -> _prefix_init."TranslateZ"] = 0;
					}
					if($this -> _testType("scale", $animType, $animType)){
						$animData[$this -> _prefix_init."ScaleX"] = 1;
						$animData[$this -> _prefix_init."ScaleY"] = 1;
						$animData[$this -> _prefix_init."Scale"] = 1;
					}
					if($this -> _testType("scale3d", $animType, $animType)){
						$animData[$this -> _prefix_init."ScaleX"] = 1;
						$animData[$this -> _prefix_init."ScaleY"] = 1;
						$animData[$this -> _prefix_init."ScaleZ"] = 1;
						$animData[$this -> _prefix_init."ScaleY"] = 1;
					}
					if($this -> _testType("matrix", $animType, $animType)){
						$animData[$this -> _prefix_init."SkewX"] = 0;
						$animData[$this -> _prefix_init."SkewY"] = 0;
						$animData[$this -> _prefix_init."Rotation"] = 0;
						$animData[$this -> _prefix_init."TranslateX"] = 0;
						$animData[$this -> _prefix_init."TranslateY"] = 0;
						$animData[$this -> _prefix_init."ScaleX"] = 1;
						$animData[$this -> _prefix_init."ScaleY"] = 1;

					}
					if($this -> _testType("perspective", $animType, $animType)){
						$animData[$this -> _prefix_init."Perspective"] = 0;
					}
					if($this -> _testType("matrix3d", $animType, $animType)){
						$animData[$this -> _prefix_init."SkewX"] = 0;
						$animData[$this -> _prefix_init."SkewY"] = 0;
						$animData[$this -> _prefix_init."RotationX"] = 0;
						$animData[$this -> _prefix_init."RotationY"] = 0;
						$animData[$this -> _prefix_init."RotationZ"] = 0;
						$animData[$this -> _prefix_init."TranslateX"] = 0;
						$animData[$this -> _prefix_init."TranslateY"] = 0;
						$animData[$this -> _prefix_init."TranslateZ"] = 0;
						$animData[$this -> _prefix_init."ScaleX"] = 1;
						$animData[$this -> _prefix_init."ScaleY"] = 1;
						$animData[$this -> _prefix_init."ScaleZ"] = 1;
					}
					$this -> _objs[$this -> _cursor[$i]] -> setAnimationData($animData);
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at init()");
				die();
			}
			return $this;
		}




		public function useStagger($pStagger){
			if(!is_numeric($pStagger)){
				throw new Exception($this -> _version.": stagger is not a numeric value at useStagger()");
				die();
			} else if($pStagger < 0){
				throw new Exception($this -> _version.": stagger cannot be negative value at useStagger()");
				die();
			}

			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$cO -> setTemporary("stagger_delay", $pStagger);
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at useStagger()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Change le délais de l'objet dans le curseur pour sa prochaine animation. Ne fait plus dépendre la prochaine animation du délais interne.
		 *
		 * @param 'int' Le délais en seconde de la prochaine animation de l'objet préparé.
		 */
		public function useDelay($pDelay){

			if(!is_numeric($pDelay)){
				throw new Exception($this -> _version.": delay is not a numeric value at useDelay()");
				die();
			} else if($pDelay < 0){
				throw new Exception($this -> _version.": delay cannot be negative value at useDelay()");
				die();
			}

			if(!$this -> _chain_mode && count($this -> _cursor_obj) == 0){
				throw new Exception($this -> _version.": No item selected at useDelay()");
				die();
			}
			else if($this -> _chain_mode){
				if(count($this -> _chain_objs)){
					$i = 0;
					foreach($this -> _chain_objs as $cO){
						$cO -> setTemporary("delay", (($i * $this -> _chain_duration_value) + $pDelay));
						$this -> _objs[$this -> _cursor[$i]] = $cO;
						$i++;
					}
				}
			}
			else if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$cO -> setTemporary("delay", $pDelay);
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Défini un nombre de boucle pour toutes les animations de l'objet dans le curseur.
		 *
		 * @param 'int ou string' Le nombre de boucle pour l'ensemble d'animations. Peut également être à 'infinite'.
		 */
		public function useIterationCount($pCount){
			if(!is_numeric($pCount)){
				throw new Exception($this -> _version.": count is not a numeric value at useIterationCount()");
				die();
			} else if($pCount < 1){
				throw new Exception($this -> _version.": count cannot be under 1 at useIterationCount()");
				die();
			}
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$cO -> setIterationCount(intval($pCount));
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at useIterationCount()");
				die();
			}
			return $this;
		}

		/**
		 * @method
		 *
		 * Défini le type boucle pour toutes les animations de l'objet dans le curseur.
		 *
		 * @param 'string' 'normal' pour revenir à sa position initial au lancement d'une nouvelle boucle. 'alternate' pour lancer la seconde boucle en rewind.
		 */
		public function useDirection($pDirection){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$cO -> setDirection($pDirection);
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at useDirection()");
				die();
			}
			return $this;
		}


		/**
		 * @method
		 *
		 * Défini le fill-mode (CSS3 Engine uniquement).
		 *
		 * @param 'string' 'forwards' 'backwards' 'both'.
		 */
		public function useFillMode($pFillMode){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$cO -> setFillMode($pFillMode);
					$this -> _objs[$this -> _cursor[$i]] = $cO;
					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at useFillMode()");
				die();
			}
			return $this;
		}


		protected function _testType($pProp, $value1, $value2){

			$ret = false;

			switch($pProp){
				case "move" :
					$ret = $value1 & AnimationType::MOVE;
					break;
				case "scale" :
					$ret = $value1 & AnimationType::SCALE && !($value2 & AnimationType::SCALE3D || $value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "skew" :
					$ret = $value1 & AnimationType::SKEW && !($value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "rotation" :
					$ret = $value1 & AnimationType::ROTATION && !($value2 & AnimationType::ROTATION3D || $value2 & AnimationType::GLOBALROTATION3D || $value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "fade" :
					$ret = $value1 & AnimationType::FADE;
					break;
				case "translate" :
					$ret = $value1 & AnimationType::TRANSLATE && !($value2 & AnimationType::TRANSLATE3D || $value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "translate3d" :
					$ret = $value1 & AnimationType::TRANSLATE3D && !($value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "rotation3d" :
					$ret = $value1 & AnimationType::ROTATION3D && !($value2 & AnimationType::GLOBALROTATION3D || $value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "scale3d" :
					$ret = $value1 & AnimationType::SCALE3D && !($value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "global_rotation3d" :
					$ret = $value1 & AnimationType::GLOBALROTATION3D && !($value2 & AnimationType::TRANSFORM_TO_MATRIX || $value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "size" :
					$ret = $value1 & AnimationType::SIZE;
					break;
				case "matrix" :
					$ret = $value1 & AnimationType::TRANSFORM_TO_MATRIX && !($value2 & AnimationType::TRANSFORM3D_TO_MATRIX);
					break;
				case "perspective" :
					$ret = $value1 & AnimationType::PERSPECTIVE;
					break;
				case "matrix3d" :
					$ret = $value1 & AnimationType::TRANSFORM3D_TO_MATRIX;
					break;
				default :
					$ret = false;
					break;
			}

			return $ret;
		}

		protected function _getArrayIndex(AnimationObject $pObject){
			$ret = NULL;
			$or = $pObject -> getSelector();
			for($i = 0; $i < count($this -> _objs); $i++){
				$n = $this -> _objs[$i] -> getSelector();
				if($n === $or){
					$ret = $i;
					break;
				}
			}
			return $ret;
		}

		protected function _find($pObjectName){
			$ret = NULL;
			for($i = 0; $i < count($this -> _objs); $i++){
				$n = $this -> _objs[$i] -> getSelector();
				if($n === $pObjectName){
					$ret = $this -> _objs[$i];
					break;
				}
			}
			return $ret;
		}

		protected function _replace($pObjectName, $obj){
			$ret = NULL;
			for($i = 0; $i < count($this -> _objs); $i++){
				$n = $this -> _objs[$i] -> getSelector();
				if($n === $pObjectName){
					$this -> _objs[$i] = $obj;
					break;
				}
			}
		}

		protected function _addAnimation($prefix){
			if(count($this -> _cursor_obj)){
				$i = 0;
				foreach($this -> _cursor_obj as $cO){
					$obj = $cO;
					$delay = $obj -> getTemporary("delay");
					$duration = $obj -> getTemporary("duration");
					$ease = $obj -> getTemporary("ease");
					$stagger_delay = $obj -> getTemporary("stagger_delay");

					$obj -> setTemporary("duration", NULL);
					$obj -> setTemporary("delay", NULL);
					$obj -> setTemporary("ease", NULL);
					$obj -> setTemporary("stagger_delay", NULL);

					if(!is_null($stagger_delay)){
						$this -> _animation_scheme[$obj -> getSelector()][] = array('delay' => $delay, 'duration' => $duration, 'ease' => $ease, 'prefix' => $prefix, 'stagger' => $stagger_delay);

					} else {
						$this -> _animation_scheme[$obj -> getSelector()][] = array('delay' => $delay, 'duration' => $duration, 'ease' => $ease, 'prefix' => $prefix);
					}

					$this -> _objs[$this -> _cursor[$i]] = $obj;

					$i++;
				}
			} else {
				throw new Exception($this -> _version.": No item selected at _addAnimation()");
				die();
			}
			return $this;
		}

		protected function _sortAnimation(){
			foreach($this -> _animation_scheme as $name => $value){
				usort($this -> _animation_scheme[$name], function($a, $b){
					if ($a['delay'] == $b['delay']) {
        		return 0;
    			}
    			return ($a['delay'] < $b['delay']) ? -1 : 1;
				});
			}
		}

		public function gen(){
			if($this -> _generated)
				return;
			$this -> _sortAnimation();
			foreach($this -> _animation_scheme as $cO => $val){
				$obj = $this -> _find($cO);
				foreach($val as  $v){

					$animations = $obj -> getAnimations();
					$count_animations = count($animations);
					$init = $count_animations ? true : false;

					if($init){
						$duration_prev = $animations[$count_animations - 1] -> getDuration();
						$delay_prev = $animations[$count_animations - 1] -> getDelay();
						$true_delay =  $v["delay"] - $obj -> getFirstDelay();

						$cond1 = floatval($true_delay - $delay_prev);
						$cond2 = floatval($duration_prev);
						if($this -> _secure_end_animation){
							if( round($cond1, 8) < round($cond2, 8)){
								throw new Exception($this -> _version.": Playing animation after an uncomplete animation for ".$obj -> getSelector()." at addAnimation().");
								die();
							}
						}
						if(isset($v["stagger"]))
							$animation = new Animation($v["prefix"], $true_delay, $v["duration"], $v["ease"], true, $v["stagger"]);
						else
							$animation = new Animation($v["prefix"], $true_delay, $v["duration"], $v["ease"]);
						$animation -> setEndKey($true_delay + $v["duration"]);

					} else {

						if(isset($v["stagger"]))
							$animation = new Animation($v["prefix"], 0, $v["duration"], $v["ease"], true, $v["stagger"]);
						else
							$animation = new Animation($v["prefix"], 0, $v["duration"], $v["ease"]);

						$animation -> setEndKey($v["duration"]);
						$obj -> setFirstDelay($v["delay"]);
					}

					array_push($animations, $animation);

					$obj -> setAnimations($animations);
					$obj -> setTotalDuration((($v["delay"] + $v["duration"])) - $obj -> getFirstDelay());

					$this -> _replace($obj -> getSelector(), $obj);
				}

			}

			$this -> _generated = true;

		}

		protected function _initBaseValues(AnimationObject $pObj){
			$b = $pObj -> getBases() -> getObjects();

			foreach($b as $base){
				$base -> initVars($pObj);
			}
			return $pObj -> getAnimationData();
		}

		/**
		 * @setter
		 *
		 * Permet d'attribuer une valeur à une propriété 'protected'. Le délai interne par exemple.
		 *
		 * @param 'string' La propriété à changer.
		 * @param '*' Attribue une valeur à certaines propriétés 'protected' comme le délais interne.
		 */
		public function __set($pProp, $pValue){
			switch($pProp){
				case "delay" :
					if(!is_numeric($pValue)){
						throw new Exception($this -> _version.": delay is not a numeric value at delay");
						die();
					} else if($pValue < 0){
						throw new Exception($this -> _version.": delay cannot be negative value at delay");
						die();
					}
					$this -> _delay = round(floatval($pValue),8);
					break;
				default :
					break;
			}
		}

		/**
		 * @getter
		 *
		 * Permet de récupéré une valeur d'une propriété 'protected'. Le délai interne par exemple.
		 *
		 * @param '*' Récupère la valeur de certaines propriétés 'protected' comme le délais interne.
		 */
		public function __get($pProp){
			$ret = NULL;
			switch($pProp){
				case "delay" :
					$ret = $this -> _delay;
					break;
				/*case "duration" :
					$ret = $this -> _getTotalDuration();
					break;*/
				case "version" :
						$ret = $this -> _version;
						break;
				case "copyright" :
						$ret = $this -> _copyright;
						break;
				default :
					break;
			}
		 	return $ret;
		}


		/**
		 * @getter
		 *
		 * Permet de récupéré une valeur d'une propriété 'protected'. Le délai interne par exemple.
		 *
		 * @param '*' Récupère la valeur de certaines propriétés 'protected' comme le délais interne.
		 */
		private function _getTotalDuration(){
			$this -> gen();
			$duration = 0;
			$current_duration = 0;
			foreach($this -> _objs as $o){
				$animations = $o -> getAnimations();
				if(count($animations) > 0){
					$current_duration = (($animations[count($animations) - 1] -> getEndKey()) * $o -> getIterationCount()) +  $o -> getFirstDelay();
					$duration = $current_duration > $duration ? $current_duration : $duration;
				}

			}
			return $duration;
		}

		/**
		 * @getter
		 *
		 * Permet de récupéré les objets.
		 *
		 */
		public function getObjects(){
		 	return $this -> _objs;
		}

		/**
		 * @setter
		 *
		 * Permet de remplacer les objets.
		 *
		 * @param mixed les objets
		 */
		public function setObjects($v){
			 $this -> _objs = $v;
		}

		/**
		 * @method
		 *
		 * Réinitialise les modes.
		 *
		 */
		protected function _reset_modes(){
			$this -> _select_multiple = false;
			$this -> _chain_mode = false;
			$this -> _chain_objs = array();
			$this -> _chain_duration_value = 0;
		}


		private function _convert_alias_types($pAnimType){
			return AnimationTypeFactory::get($pAnimType);
		}

		private function _convert_alias_ease($pEase){
			return AnimationEaseFactory::get($pEase);
		}

		private function has_custom_transforms($context, $o){
			$keys = array_keys($o);

			if($context == '2d'){
				foreach($o as $key => $vals){
					foreach($vals as $v){
						if(preg_match('/^(?:X|Y|(?:Rotation)|(?:Scale)|(?:(?:(?:Translate)|(?:Scale)|(?:Skew))(?:X|Y)))$/i', $key)){
							if(strpos($v, 'js:') === 0)
								return true;
						}
					}
				}
				foreach($keys as $k){
					if(preg_match('/^(?:X|Y|(?:Rotation)|(?:Scale)|(?:(?:(?:Translate)|(?:Scale)|(?:Skew))(?:X|Y)))\((.*?)\)$/i', $k)){
						return true;
					}
				}
			} elseif($context == '3d'){
				foreach($o as $key => $vals){
					foreach($vals as $v){
						if(preg_match('/^(?:X|Y|Z|(?:Rotation(?:X|Y|Z)?)|(?:Scale)|(?:(?:(?:Translate)|(?:Scale))(?:X|Y|Z))|(?:(?:SkewX)|(?:SkewY)))$/i', $key)){
							if(strpos($v, 'js:') === 0)
								return true;
						}
					}
				}
				foreach($keys as $k){
					if(preg_match('/^(?:X|Y|Z|(?:Rotation(?:X|Y|Z)?)|(?:Scale)|(?:(?:(?:Translate)|(?:Scale))(?:X|Y|Z))|(?:(?:SkewX)|(?:SkewY)))\((.*?)\)$/i', $k)){
						return true;
					}
				}
			}
			return false;
		}


		private function _can_has_matrix($context, $o){
			$keys = array_keys($o);

			if($context == '2d'){
				foreach($o as $key => $vals){
					foreach($vals as $v){
						if(preg_match('/^(?:X|Y|(?:Rotation)|(?:Scale)|(?:(?:(?:Translate)|(?:Scale)|(?:Skew))(?:X|Y)))$/i', $key)){
							if(is_string($v))
								return false;
						}
					}
				}
			} elseif($context == '3d'){
				foreach($o as $key => $vals){
					foreach($vals as $v){
						if(preg_match('/^(?:X|Y|Z|(?:Rotation(?:X|Y|Z)?)|(?:Scale)|(?:(?:(?:Translate)|(?:Scale))(?:X|Y|Z))|(?:(?:SkewX)|(?:SkewY)))$/i', $key)){
							if(is_string($v))
								return false;
						}
					}
				}
			}
			return true;
		}

		public static function matrix($bool){
			self::$transformToMatrix = (bool)$bool;
		}

		public function SecureEndFrames($bool){
			$this -> _secure_end_animation = (bool)$bool;
		}

	}

?>
