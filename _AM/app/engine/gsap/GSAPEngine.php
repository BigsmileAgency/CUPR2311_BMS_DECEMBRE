<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class GSAPEngine extends AnimationEngine {

		/**
		 * @constructor
		 */

		protected $_name = "gsapengine";
		protected $_initPrefix = "init";
		protected $_exitPrefix = "exit";
		protected $_reflowed = false;
		protected static $_class;
		protected static $_tl_class;
		protected $_timeline_name;
		protected $_timeline_name_or;

		protected $_sharedMatrix = array();
		protected $_has_cubic_bezier;
		protected $_has_custom_ease;
		protected $_has_custom_wiggle;
		protected $_has_custom_bounce;
		protected $_data_storage = array();
		protected $_data_current_storage = array();
		protected $_jumpLine;
		protected $_defaultSpace;
		public static $quotes = '"';
		protected static $_add_style = false;
		protected $_add_duration = 0;
		protected static $_append_style = true;
		protected $_oop = false;
		protected $_append_duration = 0;
		protected $_append_data = array();

		protected $_default_zero_scale_matrix = 0.0001;
		protected $_default_round_matrix = 6;

		protected static $version = 'latest';
		protected static $avoidTransformStyle = true;
		protected static $forceTweenLite = false;
		protected static $defaultSkewType;
		protected static $defaultTransformPerspective;
		protected static $defaultSmoothOrigin = true;
		protected static $force3D = false;

		protected $useInternalStorage = false;

		public function __construct(AnimationManager $am, FormatEngine $formatter = NULL, $prefixs = NULL, $pTimelineName = "main", $oop = false) {

			if($formatter == NULL)
				$formatter = new GSAPFormatEngine();
			parent::__construct($am, $formatter);


			if(is_null(self::$_class)){
				self::$_class = 'TweenLite';
				self::$_tl_class = 'TimelineLite';
			}

			$this -> _has_cubic_bezier = false;
			$this -> _has_custom_ease = false;
			$this -> _has_custom_wiggle = false;
			$this -> _has_custom_bounce = false;
			$this -> _oop = $oop;

			$this -> _timeline_name = $pTimelineName;
			$this -> _timeline_name .= "_";
			$this -> _timeline_name_or = $this -> _timeline_name;

			if($this -> _oop) {
				$this -> _timeline_name = "self.".$this -> _timeline_name;
			}

			$this -> _jumpLine = "<!-- ".$this -> _name.":jumpLine -->";
			$this -> _defaultSpace = "<!-- ".$this -> _name.":defaultSpace -->";
			$this -> _adaptability();
			$this -> _soft_reflow();

		}

		public static function isTweenMax(){
			return self::$_class == 'TweenMax' ? true : false;
		}

		public function isOOP(){
			return $this -> _oop;
		}

		public static function isTweenLite(){
			return self::$_class == 'TweenLite' ? true : false;
		}

		public static function toTweenMax(){
			self::$forceTweenLite = false;
			self::$_class = 'TweenMax';
			self::$_tl_class = 'TimelineMax';

		}

		public static function toTweenLite(){
			self::$forceTweenLite = true;
			self::$_class = 'TweenLite';
			self::$_tl_class = 'TimelineLite';

		}

		public function hasCubicBezier() {
			if($this -> _has_cubic_bezier)
				return true;
			$objs = $this -> _am -> getObjects();
			foreach($objs as $o){
				$animations = $o -> getAnimations();
				if(count($animations)){
					foreach($animations as $a){
						if($a -> getEase() -> getType() === AnimationEaseType::BEZIER){
							$this -> _has_cubic_bezier = true;
							break;
						}
					}
				}
				if($this -> _has_cubic_bezier)
					break;
			}
			return $this -> _has_cubic_bezier;
		}

		public function hasCustomEase() {
			if($this -> _has_custom_ease)
				return true;
			$objs = $this -> _am -> getObjects();
			foreach($objs as $o){
				$animations = $o -> getAnimations();
				if(count($animations)){
					foreach($animations as $a){
						if($a -> getEase() -> getType() === AnimationEaseType::CUSTOMEASE || $a -> getEase() -> getType() === AnimationEaseType::CUSTOMWIGGLE || $a -> getEase() -> getType() === AnimationEaseType::CUSTOMBOUNCE){
							$this -> _has_custom_ease = true;
							break;
						}
					}
				}
				if($this -> _has_custom_ease)
					break;
			}
			return $this -> _has_custom_ease;
		}

		public function hasCustomWiggle() {
			if($this -> _has_custom_wiggle)
				return true;
			$objs = $this -> _am -> getObjects();
			foreach($objs as $o){
				$animations = $o -> getAnimations();
				if(count($animations)){
					foreach($animations as $a){
						if($a -> getEase() -> getType() === AnimationEaseType::CUSTOMWIGGLE){
							$this -> _has_custom_wiggle = true;
							break;
						}
					}
				}
				if($this -> _has_custom_wiggle)
					break;
			}
			return $this -> _has_custom_wiggle;
		}

		public function hasCustomBounce() {
			if($this -> _has_custom_bounce)
				return true;
			$objs = $this -> _am -> getObjects();
			foreach($objs as $o){
				$animations = $o -> getAnimations();
				if(count($animations)){
					foreach($animations as $a){
						if($a -> getEase() -> getType() === AnimationEaseType::CUSTOMBOUNCE){
							$this -> _has_custom_bounce = true;
							break;
						}
					}
				}
				if($this -> _has_custom_bounce)
					break;
			}
			return $this -> _has_custom_bounce;
		}

		public function resetResult() {
			$reset = $this -> _reset();
			return new EngineResult($this -> _formatter -> format($reset));
		}

		public function instanceResult() {
			$instance = $this -> _new_instances();
			return new EngineResult($this -> _formatter -> format($instance));
		}

		public function initResult() {
			$init = $this -> _init();
			return new EngineResult($this -> _formatter -> format($init));
		}

		public function animationResult() {
			$anim = $this -> _animation();
			return new EngineResult($this -> _formatter -> format($anim));
		}

		public function playResult() {
			$play = $this -> _play();
			return new EngineResult($this -> _formatter -> format($play));
		}

		public function stopResult() {
			$stop = $this -> _stop();
			return new EngineResult($this -> _formatter -> format($stop));
		}

		public function stopAtEndResult() {
			$stopAE = $this -> _stopAtEnd();
			return new EngineResult($this -> _formatter -> format($stopAE));
		}

		public function completeResult() {
			$full = $this -> _new_instances().$this -> _jumpLine.$this -> _init().$this -> _jumpLine.$this -> _animation();
			return new EngineResult($this -> _formatter -> format($full));
		}


		protected function _new_instances(){

			$ret = "";
			$objs = $this -> _am -> getObjects();
			$first_obj = true;


			if($this -> _oop)
				$ret .= "this.".$this -> _timeline_name_or."timeline;";
			else
				$ret .= "var ".$this -> _timeline_name."timeline;";


			if(!(self::$_add_style || self::$_append_style)){

				if($this -> _oop)
					$ret .= "this.".$this -> _timeline_name_or."timeline_objs = [];";
				else
					$ret .= "var ".$this -> _timeline_name."timeline_objs = [];";

			}
			$ret .= $this -> _jumpLine;
			return $ret;

		}


		protected function _init(){

			$ret = "";
			$objs = $this -> _am -> getObjects();
			$first_obj = true;
			$a_c = 0;

			$ret .= $this -> _jumpLine;
			$ret .= $this -> _timeline_name."timeline".$this -> _defaultSpace."=".$this -> _defaultSpace."new ".self::$_tl_class."({paused:".$this -> _defaultSpace."true});";


			if(self::$force3D === true){
				$ret .= $this -> _jumpLine;
				$ret .= "CSSPlugin.force3D".$this -> _defaultSpace."=".$this -> _defaultSpace."true;";
			}
			if(!is_null(self::$defaultSkewType)){
				$ret .= $this -> _jumpLine;
				$ret .= "CSSPlugin.defaultSkewType".$this -> _defaultSpace."=".$this -> _defaultSpace.self::$defaultSkewType.";";
			}
			if(!is_null(self::$defaultTransformPerspective)){
				$ret .= $this -> _jumpLine;
				$ret .= "CSSPlugin.defaultTransformPerspective".$this -> _defaultSpace."=".$this -> _defaultSpace.self::$defaultTransformPerspective.";";
			}
			if(self::$defaultSmoothOrigin === false){
				$ret .= $this -> _jumpLine;
				$ret .= "CSSPlugin.defaultSmoothOrigin".$this -> _defaultSpace."=".$this -> _defaultSpace."false;";
			}
			if(!(self::$_add_style || self::$_append_style)){
				foreach($objs as $obj) {
					$animations = $obj -> getAnimations();

					if($obj -> containsAnims()){
						$a_c++;
						$first_obj = false;
					}
				}
				if($a_c>0) {
					$ret .= "for(var i=0; i < ".$a_c."; i++){";
					$ret .= $this -> _timeline_name."timeline_objs.push(new ".self::$_tl_class."());";
					$ret .= "}";
				}
			}
			$ret .= $this -> _jumpLine;
			return $ret;

		}

		protected function _play(){

			return $this -> _timeline_name."timeline.play();";
		}

		protected function _stop(){

			return $this -> _timeline_name."timeline.pause(0);";
		}

		protected function _stopAtEnd(){
			return $this -> _timeline_name."timeline.pause(".$this -> _timeline_name."timeline.totalDuration());";
		}


		protected function _animation(){

			$this -> _reflow();

			$ret = "";
			$objs = $this -> _am -> getObjects();
			$first_obj = true;
			$lastDuration = 0;

			//Construction des custom Ease

			$custom_ease = CustomEase::stored();
			$useds = array_filter($custom_ease, function($e) {
				return $e -> used;
			});

			if(is_array($useds) && count($useds)){
				foreach($useds as $build){
					if($build instanceof CustomWiggle) {
						if(!is_null($build -> timing()) || !is_null($build -> amplitude())){

							$timingEase = !is_null($build -> timing()) ? new GSAPEase($build -> timing()) :  null;
							$amplitudeEase = !is_null($build -> amplitude()) ? new GSAPEase($build -> amplitude()) :  null;

							$ret .= 'CustomWiggle.create(
						'.self::$quotes.$build->name().self::$quotes.', { wiggles:'.$build->wiggles().(!is_null($timingEase) ?
							', timingEase:'.self::$quotes.$timingEase->getValue().self::$quotes : '' ).(!is_null($amplitudeEase) ?
							', amplitudeEase:'.self::$quotes.$amplitudeEase->getValue().self::$quotes : '' ).'});';
						} else {
							$ret .= 'CustomWiggle.create(
						'.self::$quotes.$build->name().self::$quotes.', { wiggles:'.$build->wiggles().', type:'.self::$quotes.$build->type().self::$quotes.'});';
						}
					}

					if($build instanceof CustomBounce) {
							$ret .= 'CustomBounce.create(
						'.self::$quotes.$build->name().self::$quotes.', { strength:'.$build->strength().', squash:'.$build->squash().', squashID:'.self::$quotes.$build->squashName().self::$quotes.'});';

					}

					if(!is_null($build -> path())){
						$ret .= 'CustomEase.create('.self::$quotes.$build->name().self::$quotes.', '.self::$quotes.$build->path().self::$quotes.');';

					}
				}
			}


			//Parcours des objets pour add Label
			foreach($objs as $obj) {

				$name = $obj -> getName();
				$animations = $obj -> getAnimations();
				$direction = $obj -> getDirection();
				$ic = $obj -> getIterationCount();

				if(count($animations)){
					$ret .= $this -> _getAddLabel($obj, '', '');
				}
			}
			$ret .= $this -> _jumpLine;
			//Parcours des objets pour add Timeline
			foreach($objs as $obj) {

				$name = $obj -> getName();
				$animations = $obj -> getAnimations();


				if(count($animations)){
					$ret .= $this -> _getAddTimeline($obj, '','');
				}
			}
			$ret .= $this -> _jumpLine;
			//Parcours des objets pour init
			foreach($objs as $obj) {


				$name = $obj -> getName();
				$sel = $obj -> getSelector();
				$first_delay = 0;
				$animations = $obj -> getAnimations();
				$delay = $first_delay;
				$lastDelay = 0;
				$lastDuration = 0;

				if(!count($this -> _append_data)){
					$this -> _append_data = $append_data = array(
					'name' => $obj -> getSelector(),
					'delay' => round(floatval($obj -> getFirstDelay()),8),
					'tl_delay' => round(floatval($obj -> getFirstDelay()),8),
					'obj_in_tl_delay' => 0,
					'end_key' => 0,
					'obj_in_tl_end_key' => 0);

				} else {
					$append_data = $this -> _append_data;
				}

				if(count($animations)){

					$beginDim = '';
					$endDim = '';
					$iterationCount = $obj -> getIterationCount();
					$direction = $obj -> getDirection();
					$iterationBeginDim = $beginDim;
					$iterationEndDim = $endDim;
					$iteration_anim = 0;
					unset($idata);
					if($direction == 'normal' || $direction == 'initial' || $direction == 'reverse' || (($direction == 'alternate' || $direction == 'alternate-reverse') && self::isTweenMax())){
						if($iterationCount > 1 && self::isTweenLite() && !(self::$_add_style || self::$_append_style)){
							$ret .= $iterationBeginDim."for(var obj".$name."_iteration = 0; obj".$name."_iteration < ".$iterationCount."; obj".$name."_iteration++){".$iterationEndDim;

							$beginDim .= '';
							$endDim .= '';
						}

						if(self::$_add_style){
							$this -> _add_duration = 0;
							if(count($animations) > 1)
								$ret .= $this -> _timeline_name."timeline.add([";
							else
								$ret .= $this -> _timeline_name."timeline.add(";
						} else if(self::$_append_style){
							$this -> _append_duration = 0;
							if(count($animations) > 1)
								$ret .= $this -> _timeline_name."timeline.append([";
							else
								$ret .= $this -> _timeline_name."timeline.append(";
						}


						for($i = 0; $i < count($animations) ; $i++){
							$anim = $animations[$i];
							$prefName = $anim -> getPrefix();
							$data = $this -> _getData($obj, $prefName, false, true, $anim -> getName());
							$idata = $this -> _getData($obj, $this -> _initPrefix, false, true);
							$duration = $anim -> getDuration();
							$delay = round(floatval($first_delay + $anim -> getDelay() - $lastDelay - $lastDuration),8);
							$lastDelay += round(floatval($first_delay + $anim -> getDelay() - $lastDelay),8);
							if(strval($delay) === "-0")
								$delay = 0;
							if(($iterationCount > 1 && 1 == ($iteration_anim + 1)) && self::isTweenLite()){
								$this -> _storeMatrix($obj, $this -> _initPrefix);
								$andata = $this -> _getAnimsFromTo($obj, $anim, $idata, $data, $delay, $beginDim, $endDim);
								$ret .= $andata;
							}
							else {
								$andata = $this -> _getAnimsTo($obj, $anim, $data, $delay, $beginDim, $endDim);
								$ret .= $andata;
								$this -> _storeMatrix($obj, $prefName);
							}
							$lastDuration = round(floatval($anim -> getDuration()),8);
							$iteration_anim++;
						}

						if(self::$_add_style){
							$ret = substr($ret , 0, -1);
							if(count($animations) > 1)
								$ret .= "],".$this->_defaultSpace.$obj->getFirstDelay().");";
							else
								$ret .= ",".$this->_defaultSpace.$obj->getFirstDelay().");";
						} else if(self::$_append_style){
							$ret = substr($ret , 0, -1);
							if(count($animations) > 1)
								$ret .= "],".$this->_defaultSpace.round(floatval($obj->getFirstDelay() - $append_data['end_key']), 8).");";
							else
								$ret .= ",".$this->_defaultSpace.round(floatval($obj->getFirstDelay() - $append_data['end_key']), 8).");";


						}

						if($iterationCount > 1 && self::isTweenLite() && !(self::$_add_style || self::$_append_style)){
							$ret .= $iterationBeginDim."}".$iterationEndDim;
						}

					} else {
						throw new Exception('Animation Direction '.$direction.' doesn\'t exist at _animations()');
						die();
					}
				}
				$lastDuration = 0;
			}

			return $ret;

		}


		protected function _reset(){

			$ret = "";
			$objs = $this -> _am -> getObjects();
			$first_obj = true;


			//Parcours des objets pour init
			foreach($objs as $obj) {

				$name = $obj -> getName();
				$sel = $obj -> getSelector();
				$first_delay = 0;


					$beginDim = '';
					$endDim = '';
					$idata = $this -> _getData($obj, $this -> _initPrefix, true, true);
					$ret .= $this -> _getReset($obj, $idata, $beginDim, $endDim);
					$this -> _storeMatrix($obj, $this -> _initPrefix);
			}

			return $ret;

		}

		protected function _getAddLabel(AnimationObject $pObj,$beginDim = "", $endDim = ""){
			if(self::$_add_style || self::$_append_style){
				return false;
			}
			$ret = "";
			$name = $pObj -> getName();
			$delay = $pObj -> getFirstDelay();
			$ret .= $beginDim.$this -> _timeline_name."timeline.add(".self::$quotes.$pObj -> getSelector().self::$quotes.",".$this -> _defaultSpace.$pObj -> getFirstDelay().");".$endDim;
			return $ret;
		}

		protected function _getAddTimeline(AnimationObject $pObj,$beginDim = "", $endDim = ""){
			if(self::$_add_style || self::$_append_style){
				return false;
			}
			$ret = "";
			$name = $pObj -> getName();
			$ret .= $beginDim.$this -> _timeline_name."timeline.add(".$this -> _timeline_name."timeline_objs[".$name."],".$this -> _defaultSpace.self::$quotes.$pObj -> getSelector().self::$quotes.");".$endDim;

			if($pObj -> getIterationCount() > 1 && self::isTweenMax()){
				$ret .= $beginDim.$this -> _timeline_name."timeline_objs[".$name."].repeat(".($pObj -> getIterationCount() - 1).");".$endDim;
			}
			if($pObj -> getDirection() == 'alternate' || $pObj -> getDirection() == 'alternate-reverse'){
				$ret .= $beginDim.$this -> _timeline_name."timeline_objs[".$name."].yoyo(true);".$endDim;
			}
			if($pObj -> getDirection() == 'reverse' || $pObj -> getDirection() == 'alternate-reverse'){
				$ret .= $beginDim.$this -> _timeline_name."timeline_objs[".$name."].reverse(0);".$endDim;
			}

			return $ret;
		}

		protected function _getReset(AnimationObject $pObj, $pParams, $beginDim = "", $endDim = ""){
			$ret = "";

			if(count($pParams) === 0)
				return '';

			//recreate Params for grp
			$params_grp = array();
			$root_params = array();

			foreach($pParams as $k => $v){
				if(preg_match('/^(?:([a-zA-Z0-9]+)\:)([a-zA-Z0-9]+)$/', $k, $m)){
					if(!isset($params_grp[$m[1]]))
						$params_grp[$m[1]] = array();
					$params_grp[$m[1]][$m[2]] =  $v;
				} else {
					$root_params[$k] = $v;
				}
			}

			$name = $pObj -> getName();


			$ret .= $beginDim.self::$_class.".set(".$this -> strval_sel($pObj -> getSelector()).",".$this -> _defaultSpace."{".$this -> _defaultSpace;

			$first_prop = true;
			if(count($root_params) > 0){
				foreach($root_params as $k => $v){
					if(isset($v["attributs"])){
						$first_attr = true;
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $this -> _formatPropName($k).":".$this -> _defaultSpace.self::$quotes;
						foreach($v["attributs"] as $n => $attr){
							$newValue = $n;
							if(!$first_attr)
								$ret .= " ";
							$ret .= $newValue."(";
							$ret .= implode(', ', $attr["values"]);
							$ret .= ")";
							$first_attr = false;
							$first_prop = false;
						}
						$ret .= self::$quotes;
					} else {
						$newValue = $this -> _formatPropName($k);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v["values"] = $this -> strval_map($v["values"]);
						$ret .= implode(' ', $v["values"]);
						$first_prop = false;
					}
				}
			}


			if(count($params_grp) > 0){
				$first_grp = true;
				if(!$first_prop){
					$ret .= ",".$this -> _defaultSpace;
				}
				foreach($params_grp as $k => $v){
					$first_prop = true;
					$newGrp = $this -> _formatPropName($k);
					if(!$first_grp)
						$ret .= ",".$this -> _defaultSpace;
					$ret .= $newGrp.":".$this -> _defaultSpace.'{';
					foreach($v as $k2 => $v2){

						$newValue = $this -> _formatPropName($k2);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v2["values"] = $this -> strval_map($v2["values"]);
						$ret .= implode(' ', $v2["values"]);
						$first_prop = false;

					}
					$first_grp = false;
					$ret .= '}';
				}
			}


			$ret .= "});".$endDim;

			return $ret;
		}

		protected function _adaptability(){
			$objs = $this -> _am -> getObjects();

			foreach($objs as $obj){

				if(($obj -> getDirection() == 'alternate' || $obj -> getDirection() == 'alternate-reverse' || $obj -> getIterationCount() > 1)){
					self::$_add_style = false;
					self::$_append_style = false;
				}

				if(($obj -> getDirection() == 'alternate' || $obj -> getDirection() == 'alternate-reverse' || $obj -> getIterationCount() > 1) && !self::$forceTweenLite){
					self::toTweenMax();
				}

				$anims = $obj -> getAnimations();

				foreach($anims as $anim){
					if($anim -> isStagger()){
						self::$_add_style = false;
						self::$_append_style = false;
					}
				}
			}
		}

		protected function _reflow(){
			if($this -> _reflowed)
				return;
			else
				$this -> _reflowed = true;
		$objs = $this -> _am -> getObjects();
		$i = 0;

		foreach($objs as $obj){
			$this -> _storeMatrix($obj, $this -> _initPrefix);
			$anims = $obj -> getAnimations();
			foreach($anims as $k => $anim){
				$data = $this -> _getData($obj, $anim -> getPrefix(), false, true);
				$this -> _storeMatrix($obj, $anim -> getPrefix());
				if(!count($data)){
					unset($anims[$k]);
				}
			}

			$anims = array_values($anims);

			if(count($anims)){
				$anims[0] -> first();
				$delay_to_dec = $anims[0] -> getDelay();
				$obj -> setName($i++);

				for($ian = 0; $ian < count($anims) ; $ian++ ){
					 $anims[$ian] -> setDelay(round($anims[$ian] -> getDelay() - $delay_to_dec, 8));
				}

				$obj -> setFirstDelay(round($obj -> getFirstDelay() + $delay_to_dec, 8));
			}

			$obj -> setAnimations($anims);
		}
		$this -> _am -> setObjects($objs);

		$this -> _data_current_storage = array();
		$this -> _sharedMatrix = array();

		$objs = $this -> _am -> getObjects();
		foreach($objs as $obj){
			$this -> _getData($obj, $this -> _initPrefix, false, true);
			$this -> _storeMatrix($obj, $this -> _initPrefix);

			$anims = $obj -> getAnimations();

			foreach($anims as $k => $anim){
				$this -> _getData($obj, $anim -> getPrefix(), false, true, $anim -> getName());
				$this -> _storeMatrix($obj, $anim -> getPrefix());

			}

			$this -> _sharedMatrix = array();
			$this -> _storeMatrix($obj, $this -> _initPrefix);

		}
		}

		protected function _soft_reflow(){

			$objs = $this -> _am -> getObjects();
			$i = 0;


			foreach($objs as $obj){
				$anims = $obj -> getAnimations();
				$obj_anims = 0;
				$this -> _getData($obj, $this -> _initPrefix, true, true);
				foreach($anims as $k => $anim){
					$data = $this -> _getData($obj, $anim -> getPrefix(), false, true);
					if(count($data)){
						$obj_anims++;
					}
				}

				if($obj_anims > 0){
					$obj -> hasAnim(true);
				}

				$obj -> setAnimations($anims);
			}
			$this -> _am -> setObjects($objs);
			$this -> _data_current_storage = array();
			$this -> _sharedMatrix = array();

		}

		protected function _getAnimsTo(AnimationObject $pObj, Animation $pAnim, $pParams, $pDelay ,$beginDim = "", $endDim = ""){
			$ret = "";

			if(count($pParams) === 0)
				return '';

			//recreate Params for grp
			$params_grp = array();
			$root_params = array();

			foreach($pParams as $k => $v){
				if(preg_match('/^(?:([a-zA-Z0-9]+)\:)([a-zA-Z0-9]+)$/', $k, $m)){
					if(!isset($params_grp[$m[1]]))
						$params_grp[$m[1]] = array();
					$params_grp[$m[1]][$m[2]] =  $v;
				} else {
					$root_params[$k] = $v;
				}
			}

			$name = $pObj -> getName();
			$delay = $pAnim -> getDelay();
			$duration = $pAnim -> getDuration();

			$function_gsap = $pAnim -> isStagger() && $pAnim -> getStaggerDelay() > 0 ? 'staggerTo' : 'to';
			$addons = $pAnim -> isStagger() && $pAnim -> getStaggerDelay() > 0 ? ','.$this -> _defaultSpace.floatval($pAnim -> getStaggerDelay()) : '';

			if(self::$_add_style || self::$_append_style){
				$concret_sel = self::$_class;
			}
			else{
				$concret_sel = $this -> _timeline_name."timeline_objs[".$name."]";
			}
			$ret .= $beginDim.$concret_sel.".".$function_gsap ."(".$this -> strval_sel($pObj -> getSelector()).",".$this -> _defaultSpace.$duration.",".$this -> _defaultSpace."{";

			$first_prop = true;
			$ease = new GSAPEase($pAnim -> getEase());

			if(count($root_params) > 0){
				foreach($root_params as $k => $v){
					if(isset($v["attributs"])){
						$first_attr = true;
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $this -> _formatPropName($k).":".$this -> _defaultSpace.self::$quotes;
						foreach($v["attributs"] as $n => $attr){
							$newValue = $n;
							if(!$first_attr)
								$ret .= " ";
							$ret .= $newValue."(";
							$ret .= implode(', ', $attr["values"]);
							$ret .= ")";
							$first_attr = false;
							$first_prop = false;
						}
						$ret .= self::$quotes;
					} else {
						$newValue = $this -> _formatPropName($k);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v["values"] = $this -> strval_map($v["values"]);
						$ret .= implode(' ', $v["values"]);
						$first_prop = false;
					}
				}
			}
			if(count($params_grp) > 0){
				$first_grp = true;
				if(!$first_prop){
					$ret .= ",".$this -> _defaultSpace;
				}
				foreach($params_grp as $k => $v){
					$first_prop = true;
					$newGrp = $this -> _formatPropName($k);
					if(!$first_grp)
						$ret .= ",".$this -> _defaultSpace;
					$ret .= $newGrp.":".$this -> _defaultSpace.'{';
					foreach($v as $k2 => $v2){
						$newValue = $this -> _formatPropName($k2);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v2["values"] = $this -> strval_map($v2["values"]);
						$ret .= implode(' ', $v2["values"]);
						$first_prop = false;
					}
					$first_grp = false;
					$ret .= '}';
				}
			}

			if($duration < 0 || $duration == 0)
				$ret .= ",".$this -> _defaultSpace."immediateRender:".$this -> _defaultSpace.'false';

			if(self::$_add_style){
				$ret .= ",".$this -> _defaultSpace."ease:".$this -> _defaultSpace.$ease -> getValue().(!is_null($ease -> config())? ".config(".$ease -> config().")" : "");
				$this -> _add_duration = round(floatval($this -> _add_duration + $pDelay), 8);
				if(!$pAnim -> isFirst()){
					$ret .= ",".$this -> _defaultSpace."delay:".$this -> _defaultSpace.$this -> _add_duration;
				}
				$this -> _add_duration = round(floatval($this -> _add_duration + $duration), 8);
				$ret .= "}";
				$ret .= $addons;
				$ret .= "),";

			} else if(self::$_append_style){
				$ret .= ",".$this -> _defaultSpace."ease:".$this -> _defaultSpace.$ease -> getValue().(!is_null($ease -> config())? ".config(".$ease -> config().")" : "");
				$this -> _append_duration = round(floatval($this -> _append_duration + $pDelay), 8);
				if(!$pAnim -> isFirst()){
					$ret .= ",".$this -> _defaultSpace."delay:".$this -> _defaultSpace.$this -> _append_duration;
				}
				$this -> _append_duration = round(floatval($this -> _append_duration + $duration), 8);


				if(round(floatval($pObj -> getFirstDelay() + $this -> _append_duration),4 ) > $this -> _append_data['end_key']){
					$this -> _append_data = array(
						'name' => $pObj -> getSelector() ,
						'anim' => $pAnim -> getPrefix() ,
						'duration' => $duration,
						'delay' => round(floatval($pObj -> getFirstDelay() + $this -> _append_duration - $duration),8),
						'tl_delay' => round(floatval($pObj -> getFirstDelay()),4 ),
						'obj_in_tl_delay' => round(floatval($this -> _append_duration -  $duration),8),
						'end_key' => round(floatval($pObj -> getFirstDelay() + $this -> _append_duration),8),
						'obj_in_tl_end_key' => round(floatval($this -> _append_duration),4 )
					);
				}

				$ret .= "}";
				$ret .= $addons;
				$ret .= "),";

			} else{
				$ret .= ",".$this -> _defaultSpace."ease:".$this -> _defaultSpace.$ease -> getValue().(!is_null($ease -> config())? ".config(".$ease -> config().")" : "")."}";
				$ret .= $addons;
				if($pDelay > 0)
					$ret .= ",".$this -> _defaultSpace.self::$quotes."+=".$pDelay.self::$quotes;
				else if($pDelay < 0)
					$ret .= ",".$this -> _defaultSpace.self::$quotes."-=".(-$pDelay).self::$quotes;
				$ret .= ");".$endDim;

			}

			return $ret;
		}

		protected function _getAnimsFromTo(AnimationObject $pObj, Animation $pAnim, $pFromParams, $pParams, $pDelay ,$beginDim = "", $endDim = ""){
			$ret = "";

			if(count($pParams) === 0)
				return '';
			else if(count($pFromParams) === 0 ){
				return $this -> _getAnimsTo($pObj, $pAnim, $pParams, $pDelay ,$beginDim, $endDim);
			}

			//recreate Params for grp
			$params_grp = array();
			$root_params = array();
			$params_from_grp = array();
			$root_from_params = array();


			foreach($pParams as $k => $v){
				if(preg_match('/^(?:([a-zA-Z0-9]+)\:)([a-zA-Z0-9]+)$/', $k, $m)){
					if(!isset($params_grp[$m[1]]))
						$params_grp[$m[1]] = array();
					$params_grp[$m[1]][$m[2]] =  $v;
				} else {
					$root_params[$k] = $v;
				}
			}
			foreach($pFromParams as $k => $v){
				if(preg_match('/^(?:([a-zA-Z0-9]+)\:)([a-zA-Z0-9]+)$/', $k, $m)){
					if(!isset($params_from_grp[$m[1]]))
						$params_from_grp[$m[1]] = array();
					$params_from_grp[$m[1]][$m[2]] =  $v;
				} else {
					$root_from_params[$k] = $v;
				}
			}

			$name = $pObj -> getName();
			$delay = $pAnim -> getDelay();
			$duration = $pAnim -> getDuration();

			$ease = new GSAPEase($pAnim -> getEase());

			$function_gsap = $pAnim -> isStagger() && $pAnim -> getStaggerDelay() > 0 ? 'staggerFromTo' : 'fromTo';
			$addons = $pAnim -> isStagger() && $pAnim -> getStaggerDelay() > 0 ? ','.$this -> _defaultSpace.floatval($pAnim -> getStaggerDelay()) : '';

			if(self::$_add_style || self::$_append_style){
				$concret_sel = self::$_class;
			}
			else{
				$concret_sel = $this -> _timeline_name."timeline_objs[".$name."]";
			}
			$ret .= $beginDim.$concret_sel.".".$function_gsap."(".$this -> strval_sel($pObj -> getSelector()).",".$this -> _defaultSpace.$duration.",".$this -> _defaultSpace."{";

			$first_prop = true;
			if(count($root_from_params) > 0){
				foreach($root_from_params as $k => $v){
					if(isset($v["attributs"])){
						$first_attr = true;
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $this -> _formatPropName($k).":".$this -> _defaultSpace.self::$quotes;
						foreach($v["attributs"] as $n => $attr){
							$newValue = $n;
							if(!$first_attr)
								$ret .= " ";
							$ret .= $newValue."(";
							$ret .= implode(', ', $attr["values"]);
							$ret .= ")";
							$first_attr = false;
							$first_prop = false;
						}
						$ret .= self::$quotes;

					} else {
						$newValue = $this -> _formatPropName($k);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v["values"] = $this -> strval_map($v["values"]);
						$ret .= implode(', ', $v["values"]);
						$first_prop = false;
					}
				}
			}
			if(count($params_from_grp) > 0){
				$first_grp = true;
				if(!$first_prop){
					$ret .= ",".$this -> _defaultSpace;
				}
				foreach($params_from_grp as $k => $v){
					$first_prop = true;
					$newGrp = $this -> _formatPropName($k);
					if(!$first_grp)
						$ret .= ",".$this -> _defaultSpace;
					$ret .= $newGrp.":".$this -> _defaultSpace.'{';
					foreach($v as $k2 => $v2){
						$newValue = $this -> _formatPropName($k2);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v2["values"] = $this -> strval_map($v2["values"]);
						$ret .= implode(' ', $v2["values"]);
						$first_prop = false;
					}
					$first_grp = false;
					$ret .= '}';
				}
			}
			$ret .= "}, ".$this -> _defaultSpace."{";

			$first_prop = true;
			if(count($root_params) > 0){
				foreach($root_params as $k => $v){
					if(isset($v["attributs"])){
						$first_attr = true;
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $this -> _formatPropName($k).":".$this -> _defaultSpace.self::$quotes;
						foreach($v["attributs"] as $n => $attr){
							$newValue = $n;
							if(!$first_attr)
								$ret .= " ";
							$ret .= $newValue."(";
							$ret .= implode(', ', $attr["values"]);
							$ret .= ")";
							$first_attr = false;
							$first_prop = false;
						}
						$ret .= self::$quotes;

					} else {
						$newValue = $this -> _formatPropName($k);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v["values"] = $this -> strval_map($v["values"]);
						$ret .= implode(' ', $v["values"]);
						$first_prop = false;
					}
				}
			}
			if(count($params_grp) > 0){
				$first_grp = true;
				if(!$first_prop){
					$ret .= ",".$this -> _defaultSpace;
				}
				foreach($params_grp as $k => $v){
					$first_prop = true;
					$newGrp = $this -> _formatPropName($k);
					if(!$first_grp)
						$ret .= ",".$this -> _defaultSpace;
					$ret .= $newGrp.":".$this -> _defaultSpace.'{';
					foreach($v as $k2 => $v2){
						$newValue = $this -> _formatPropName($k2);
						if(!$first_prop)
							$ret .= ",".$this -> _defaultSpace;
						$ret .= $newValue.":".$this -> _defaultSpace;
						$v2["values"] = $this -> strval_map($v2["values"]);
						$ret .= implode(' ', $v2["values"]);
						$first_prop = false;
					}
					$first_grp = false;
					$ret .= '}';
				}
			}

			if($duration < 0 || $duration == 0)
				$ret .= ",".$this -> _defaultSpace."immediateRender:".$this -> _defaultSpace.'true';

			if(self::$_add_style){
				$ret .= ",".$this -> _defaultSpace."ease:".$this -> _defaultSpace.$ease -> getValue().(!is_null($ease -> config())? ".config(".$ease -> config().")" : "");
				$this -> _add_duration = round(floatval($this -> _add_duration + $pDelay), 8);
				if(!$pAnim -> isFirst()){
					$ret .= ",".$this -> _defaultSpace."delay:".$this -> _defaultSpace.$this -> _add_duration;
				}
				$this -> _add_duration = round(floatval($this -> _add_duration + $duration), 8);
				$ret .= "}";
				$ret .= $addons;
				$ret .= "),";

			} else if(self::$_append_style){
				$ret .= ",".$this -> _defaultSpace."ease:".$this -> _defaultSpace.$ease -> getValue().(!is_null($ease -> config())? ".config(".$ease -> config().")" : "");
				$this -> _append_duration = round(floatval($this -> _append_duration + $pDelay), 8);
				if(!$pAnim -> isFirst()){
					$ret .= ",".$this -> _defaultSpace."delay:".$this -> _defaultSpace.$this -> _append_duration;
				}
				$this -> _append_duration = round(floatval($this -> _append_duration + $duration), 8);


				if(round(floatval($pObj -> getFirstDelay() + $this -> _append_duration),4 ) > $this -> _append_data['end_key']){
					$this -> _append_data = array(
						'name' => $pObj -> getSelector() ,
						'anim' => $pAnim -> getPrefix() ,
						'duration' => $duration,
						'delay' => round(floatval($pObj -> getFirstDelay() + $this -> _append_duration - $duration),8 ),
						'tl_delay' => round(floatval($pObj -> getFirstDelay()),8),
						'obj_in_tl_delay' => round(floatval($this -> _append_duration -  $duration),8 ),
						'end_key' => round(floatval($pObj -> getFirstDelay() + $this -> _append_duration),8 ),
						'obj_in_tl_end_key' => round(floatval($this -> _append_duration),8 )
					);
				}

				$ret .= "}";
				$ret .= $addons;
				$ret .= "),";

			} else{
				$ret .= ",".$this -> _defaultSpace."ease:".$this -> _defaultSpace.$ease -> getValue().(!is_null($ease -> config())? ".config(".$ease -> config().")" : "")."}";
				$ret .= $addons;
				if($pDelay > 0)
					$ret .= ",".$this -> _defaultSpace.self::$quotes."+=".$pDelay.self::$quotes;
				else if($pDelay < 0)
					$ret .= ",".$this -> _defaultSpace.self::$quotes."-=".(-$pDelay).self::$quotes;
				$ret .= ");".$endDim;

			}

			return $ret;
		}


		protected function _formatPropName($v){
			$len = strlen($v);
			$letters = array();
			$nextLetterUpper = false;
    		$newName = "";
    		for($i = 0; $i < $len; $i ++) {
    			$letter =  substr($v, $i, 1);
    			if($letter === "-") {
    				$nextLetterUpper = true;
    			}
    			else {
    				if($nextLetterUpper){
    					array_push($letters, strtoupper($letter));
    					$nextLetterUpper = false;
    				} else {
    					array_push($letters, $letter);
    				}
    			}

    		}
    		return implode('', $letters);

		}

		protected function getCurrent($name, $suffix){
			if($this -> useInternalStorage) {
				return $this -> _data_current_storage[$name][$suffix];
			}
			return;
		}

		protected function storeCurrent($name, $suffix, $value){
			if($this -> useInternalStorage) {
				$this -> _data_current_storage[$name][$suffix] = $value;
			}
		}

		protected function detachCurrent($name, $suffix){
			if($this -> useInternalStorage) {
				unset($this -> _data_current_storage[$name][$suffix]);
			}
		}
		protected function hasCurrent($name, $suffix){
			if($this -> useInternalStorage) {
				return isset($this -> _data_current_storage[$name][$suffix]);
			}
			return false;
		}



		protected function _getData(AnimationObject $pObject, $pPrefix, $transformStyle = false, $allowSuffix = false, $animation_name = null){

			if(!is_null($animation_name)){
				if(isset($this -> _data_storage[$animation_name])){
					return $this -> _data_storage[$animation_name];
				}
			}
			if($this -> useInternalStorage) {
				if(!isset($this -> _data_current_storage[$pObject->getName()])){
					$this -> _data_current_storage[$pObject->getName()] = array();
				}
			}


			$types = $pObject -> getAllowedTypes();
			$data = $pObject -> getAnimationData();
			$name = $pObject -> getName();
			$selector = $pObject -> getSelector();
			$params = array();
			$bases = $pObject -> getBases();
			$transformTypes = array("translate", "translate3d", "scale", "scale3d", "rotation", "skew", "rotation3d", "global_rotation3d", "matrix","perspective", "matrix3d");
			$transform3dTypes = array("translate3d","translateZ","scale3d","scaleZ","rotation3d","rotationX","rotationY","rotationZ","global_rotation3d","matrix3d");


			if(in_array("move", $types)){

				$params["left"] = array();
				$params["right"] = array();
				$params["top"] = array();
				$params["bottom"] = array();


				$suffix = "PosX";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
						$posX = $data[$pPrefix.$suffix];
						$params["left"]["values"][] = !$allowSuffix  ? $posX : strval($posX).$pObject -> getSuffixValue("move");
						if(!$this -> _isRel($data[$pPrefix.$suffix]))
							$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
						else
							$this -> detachCurrent($pObject -> getName(), $suffix);
					}
				} elseif(isset($data[$pPrefix.'Left'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Left')
					&& $this -> getCurrent($pObject -> getName(), 'Left') !== $data[$pPrefix.'Left'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Left')){
						$posX = $data[$pPrefix.'Left'];
						$params["left"]["values"][] = !$allowSuffix  ? $posX : strval($posX).$pObject -> getSuffixValue("move");
						if(!$this -> _isRel($data[$pPrefix.'Left']))
							$this -> storeCurrent($pObject -> getName(), 'Left', $data[$pPrefix.'Left']);
						else
							$this -> detachCurrent($pObject -> getName(), 'Left');
					}
				} elseif(isset($data[$pPrefix.'Right'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Right')
					&& $this -> getCurrent($pObject -> getName(), 'Right') !== $data[$pPrefix.'Right'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Right')){
					$right = $data[$pPrefix.'Right'];
					$params["right"]["values"][] = !$allowSuffix   ? $right : strval($right).$pObject -> getSuffixValue("move");
					if(!$this -> _isRel($data[$pPrefix.'Right']))
							$this -> storeCurrent($pObject -> getName(), 'Right', $data[$pPrefix.'Right']);
						else
							$this -> detachCurrent($pObject -> getName(), 'Right');
				}}


				$suffix = "PosY";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$posY = $data[$pPrefix.$suffix];
					$params["top"]["values"][] = !$allowSuffix ? $posY : strval($posY).$pObject -> getSuffixValue("move");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
							$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
						else
							$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'Top'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Top')
					&& $this -> getCurrent($pObject -> getName(), 'Top') !== $data[$pPrefix.'Top'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Top')){
					$posY = $data[$pPrefix.'Top'];
					$params["top"]["values"][] = !$allowSuffix  ? $posY : strval($posY).$pObject -> getSuffixValue("move");
					if(!$this -> _isRel($data[$pPrefix.'Top']))
							$this -> storeCurrent($pObject -> getName(), 'Top', $data[$pPrefix.'Top']);
						else
							$this -> detachCurrent($pObject -> getName(), 'Top');
				}} elseif(isset($data[$pPrefix.'Bottom'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Bottom')
					&& $this -> getCurrent($pObject -> getName(), 'Bottom') !== $data[$pPrefix.'Bottom'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Bottom')){
					$bottom = $data[$pPrefix.'Bottom'];
					$params["bottom"]["values"][] = !$allowSuffix ? $bottom : strval($bottom).$pObject -> getSuffixValue("move");
					if(!$this -> _isRel($data[$pPrefix.'Bottom']))
							$this -> storeCurrent($pObject -> getName(), 'Bottom', $data[$pPrefix.'Bottom']);
						else
							$this -> detachCurrent($pObject -> getName(), 'Bottom');
				}}
			}
			if(in_array("fade", $types)){

				$params["alpha"] = array();

				$suffix = "Alpha";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$opacity = $data[$pPrefix.$suffix];
					$params["alpha"]["values"][] = !$allowSuffix ? $opacity : strval($opacity).$pObject -> getSuffixValue("fade");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}
			}
			if(in_array("size", $types)){

				$params["width"] = array();
				$params["height"] = array();

				$suffix = "Width";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$width = $data[$pPrefix.$suffix];
					$params["width"]["values"][] = !$allowSuffix  ? $width : strval($width).$pObject -> getSuffixValue("size");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}
				$suffix = "Height";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$height = $data[$pPrefix.$suffix];
					$params["height"]["values"][] = !$allowSuffix ? $height : strval($height).$pObject -> getSuffixValue("size");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}


			}
			if(in_array("perspective", $types)){

				$params["perspective"] = array();

				$suffix = "Perspective";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$perspective = $data[$pPrefix.$suffix];
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}

				if(isset($perspective)){
					$params["perspective"]["values"][] = !$allowSuffix  ? $perspective : strval($perspective).$pObject -> getSuffixValue("perspective");
				}

			}
			if(in_array("translate", $types)){

				$params["x"] = array();
				$params["y"] = array();

				$suffix = "TranslateX";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$translateX = $data[$pPrefix.$suffix];
					$params["x"]["values"][] = !$allowSuffix  ? $translateX: strval($translateX).$pObject -> getSuffixValue("translate");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'X'])){
					if(($this -> hasCurrent($pObject -> getName(), 'X')
					&& $this -> getCurrent($pObject -> getName(), 'X') !== $data[$pPrefix.'X'])
					|| !$this -> hasCurrent($pObject -> getName(), 'X')){
					$translateX = $data[$pPrefix.'X'];
					$params["x"]["values"][] = !$allowSuffix ? $translateX : strval($translateX).$pObject -> getSuffixValue("translate");
					if(!$this -> _isRel($data[$pPrefix.'X']))
						$this -> storeCurrent($pObject -> getName(), 'X', $data[$pPrefix.'X']);
					else
						$this -> detachCurrent($pObject -> getName(), 'X');
				}}


				$suffix = "TranslateY";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$translateY = $data[$pPrefix.$suffix];
					$params["y"]["values"][] = !$allowSuffix ? $translateY: strval($translateY).$pObject -> getSuffixValue("translate");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'Y'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Y')
					&& $this -> getCurrent($pObject -> getName(), 'Y') !== $data[$pPrefix.'Y'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Y')){
					$translateY = $data[$pPrefix.'Y'];
					$params["y"]["values"][] = !$allowSuffix ? $translateY : strval($translateY).$pObject -> getSuffixValue("translate");
					if(!$this -> _isRel($data[$pPrefix.'Y']))
						$this -> storeCurrent($pObject -> getName(), 'Y', $data[$pPrefix.'Y']);
					else
						$this -> detachCurrent($pObject -> getName(), 'Y');
				}}

			}
			if(in_array("translate3d", $types)){

				$params["x"] = array();
				$params["y"] = array();
				$params["z"] = array();

				$suffix = "TranslateX";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$translateX = $data[$pPrefix.$suffix];
					$params["x"]["values"][] = !$allowSuffix ? $translateX: strval($translateX).$pObject -> getSuffixValue("translate3d");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'X'])){
					if(($this -> hasCurrent($pObject -> getName(), 'X')
					&& $this -> getCurrent($pObject -> getName(), 'X') !== $data[$pPrefix.'X'])
					|| !$this -> hasCurrent($pObject -> getName(), 'X')){
					$translateX = $data[$pPrefix.'X'];
					$params["x"]["values"][] = !$allowSuffix  ? $translateX : strval($translateX).$pObject -> getSuffixValue("translate3d");
					if(!$this -> _isRel($data[$pPrefix.'X']))
						$this -> storeCurrent($pObject -> getName(), 'X', $data[$pPrefix.'X']);
					else
						$this -> detachCurrent($pObject -> getName(), 'X');
				}}
				$suffix = "TranslateY";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$translateY = $data[$pPrefix.$suffix];
					$params["y"]["values"][] = !$allowSuffix  ? $translateY: strval($translateY).$pObject -> getSuffixValue("translate3d");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'Y'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Y')
					&& $this -> getCurrent($pObject -> getName(), 'Y') !== $data[$pPrefix.'Y'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Y')){
					$translateY = $data[$pPrefix.'Y'];
					$params["y"]["values"][] = !$allowSuffix  ? $translateY : strval($translateY).$pObject -> getSuffixValue("translate3d");
					if(!$this -> _isRel($data[$pPrefix.'Y']))
						$this -> storeCurrent($pObject -> getName(), 'Y', $data[$pPrefix.'Y']);
					else
						$this -> detachCurrent($pObject -> getName(), 'Y');
				}}
				$suffix = "TranslateZ";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$translateZ = $data[$pPrefix.$suffix];
					$params["z"]["values"][] = !$allowSuffix  ? $translateZ: strval($translateZ).$pObject -> getSuffixValue("translate3d");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'Z'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Z')
					&& $this -> getCurrent($pObject -> getName(), 'Z') !== $data[$pPrefix.'Z'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Z')){
					$translateZ = $data[$pPrefix.'Z'];
					$params["z"]["values"][] = !$allowSuffix  ? $translateZ : strval($translateZ).$pObject -> getSuffixValue("translate3d");
					if(!$this -> _isRel($data[$pPrefix.'Z']))
						$this -> storeCurrent($pObject -> getName(), 'Z', $data[$pPrefix.'Z']);
					else
						$this -> detachCurrent($pObject -> getName(), 'Z');
				}}
			}
			if(in_array("scale", $types)){

				$params["scale"] = array();
				$params["scaleX"] = array();
				$params["scaleY"] = array();

				$suffix = "Scale";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$scale = $data[$pPrefix.$suffix];
					$params["scale"]["values"][] = !$allowSuffix ? $scale: strval($scale).$pObject -> getSuffixValue("scale");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} else {
					$suffix = "ScaleX";
					if(isset($data[$pPrefix.$suffix])){
						if(($this -> hasCurrent($pObject -> getName(), $suffix)
						&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
						|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
						$scaleX = $data[$pPrefix.$suffix];
						$params["scaleX"]["values"][] = !$allowSuffix ? $scaleX: strval($scaleX).$pObject -> getSuffixValue("scale");

						if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
					}}
					$suffix = "ScaleY";
					if(isset($data[$pPrefix.$suffix])){
						if(($this -> hasCurrent($pObject -> getName(), $suffix)
						&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
						|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
						$scaleY = $data[$pPrefix.$suffix];
						$params["scaleY"]["values"][] = !$allowSuffix ? $scaleY: strval($scaleY).$pObject -> getSuffixValue("scale");
						if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
					}}
				}

			}
			if(in_array("scale3d", $types)){

				$params["scale"] = array();
				$params["scaleX"] = array();
				$params["scaleY"] = array();
				$params["scaleZ"] = array();

				$suffix = "Scale";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$scale = $data[$pPrefix.$suffix];
					$params["scale"]["values"][] = !$allowSuffix ? $scale: strval($scale).$pObject -> getSuffixValue("scale3d");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} else {
					$suffix = "ScaleX";
					if(isset($data[$pPrefix.$suffix])){
						if(($this -> hasCurrent($pObject -> getName(), $suffix)
						&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
						|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
						$scaleX = $data[$pPrefix.$suffix];
						$params["scaleX"]["values"][] = !$allowSuffix ? $scaleX: strval($scaleX).$pObject -> getSuffixValue("scale3d");
						if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
					}}
					$suffix = "ScaleY";
					if(isset($data[$pPrefix.$suffix])){
						if(($this -> hasCurrent($pObject -> getName(), $suffix)
						&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
						|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
						$scaleY = $data[$pPrefix.$suffix];
						$params["scaleY"]["values"][] = !$allowSuffix ? $scaleY: strval($scaleY).$pObject -> getSuffixValue("scale3d");
						if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
					}}
					$suffix = "ScaleZ";
					if(isset($data[$pPrefix.$suffix])){
						if(($this -> hasCurrent($pObject -> getName(), $suffix)
						&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
						|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
						$scaleZ = $data[$pPrefix.$suffix];
						$params["scaleZ"]["values"][] = !$allowSuffix ? $scaleZ: strval($scaleZ).$pObject -> getSuffixValue("scale3d");
						if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
					}}
				}
			}
			if(in_array("rotation", $types)){

				$params["rotation"] = array();

				$suffix = "Rotation";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$rotation = $data[$pPrefix.$suffix];
					$params["rotation"]["values"][] = !$allowSuffix ? $rotation : strval($rotation).$pObject -> getSuffixValue("rotation");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}

			}
			if(in_array("rotation3d", $types)){

				$params["rotationX"] = array();
				$params["rotationY"] = array();
				$params["rotationZ"] = array();

				$suffix = "RotationX";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$rotationX = $data[$pPrefix.$suffix];
					$params["rotationX"]["values"][] = !$allowSuffix  ? $rotationX : strval($rotationX).$pObject -> getSuffixValue("rotation3d");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}
				$suffix = "RotationY";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$rotationY = $data[$pPrefix.$suffix];
					$params["rotationY"]["values"][] = !$allowSuffix ? $rotationY : strval($rotationY).$pObject -> getSuffixValue("rotation3d");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}
				$suffix = "RotationZ";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$rotationZ = $data[$pPrefix.$suffix];
					$params["rotationZ"]["values"][] = !$allowSuffix  ? $rotationZ : strval($rotationZ).$pObject -> getSuffixValue("rotation3d");
					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}} elseif(isset($data[$pPrefix.'Rotation'])){
					if(($this -> hasCurrent($pObject -> getName(), 'Rotation')
					&& $this -> getCurrent($pObject -> getName(), 'Rotation') !== $data[$pPrefix.'Rotation'])
					|| !$this -> hasCurrent($pObject -> getName(), 'Rotation')){
					$rotation = $data[$pPrefix.'Rotation'];
					$params["rotationZ"]["values"][] = !$allowSuffix   ? $rotation : strval($rotation).$pObject -> getSuffixValue("rotation3d");
					if(!$this -> _isRel($data[$pPrefix.'Rotation']))
						$this -> storeCurrent($pObject -> getName(), 'Rotation', $data[$pPrefix.'Rotation']);
					else
						$this -> detachCurrent($pObject -> getName(), 'Rotation');
				}}

			}

			if(in_array("skew", $types)){

				$params["skewX"] = array();
				$params["skewY"] = array();

				$suffix = "SkewX";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$skewX = $data[$pPrefix.$suffix];
					$params["skewX"]["values"][] = !$allowSuffix  ? $skewX : strval($skewX).$pObject -> getSuffixValue("skew");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}
				$suffix = "SkewY";
				if(isset($data[$pPrefix.$suffix])){
					if(($this -> hasCurrent($pObject -> getName(), $suffix)
					&& $this -> getCurrent($pObject -> getName(), $suffix) !== $data[$pPrefix.$suffix])
					|| !$this -> hasCurrent($pObject -> getName(), $suffix)){
					$skewY = $data[$pPrefix.$suffix];
					$params["skewY"]["values"][] = !$allowSuffix  ? $skewY : strval($skewY).$pObject -> getSuffixValue("skew");

					if(!$this -> _isRel($data[$pPrefix.$suffix]))
						$this -> storeCurrent($pObject -> getName(), $suffix, $data[$pPrefix.$suffix]);
					else
						$this -> detachCurrent($pObject -> getName(), $suffix);
				}}


			}
			if(in_array("matrix", $types)){
				$mfor_translate = array(1,0,0,1,0,0);
				$mfor_rotation = array(1,0,0,1,0,0);
				$mfor_scale = array(1,0,0,1,0,0);
				$mfor_skew = array(1,0,0,1,0,0);
				$deg2radians = floatval(floatval(pi()) * 2 / 360);


				$suffix = "Scale";
				if(isset($data[$pPrefix.$suffix])){
					$mfor_scale[0] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					$mfor_scale[3] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
				} else {
					$suffix = "ScaleX";
					if(isset($data[$pPrefix.$suffix])){
						$mfor_scale[0] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
						$mfor_scale[0] = $this -> _sharedMatrix[$selector][$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($this -> _sharedMatrix[$selector][$suffix]);
					} else if(isset($data[$this -> _initPrefix.$suffix])) {
						$mfor_scale[0] = $data[$this -> _initPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$this -> _initPrefix.$suffix]);

					}


					$suffix = "ScaleY";
					if(isset($data[$pPrefix.$suffix])){
						$mfor_scale[3] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
						$mfor_scale[3] = $this -> _sharedMatrix[$selector][$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($this -> _sharedMatrix[$selector][$suffix]);
					} else if(isset($data[$this -> _initPrefix.$suffix])) {
						$mfor_scale[3] = $data[$this -> _initPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$this -> _initPrefix.$suffix]);
					}
				}


				$suffix = "SkewX";
				if(isset($data[$pPrefix.$suffix])){
					$mfor_skew[2] = tan(floatval($data[$pPrefix.$suffix]) * $deg2radians);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_skew[2] = tan(floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_skew[2] = tan(floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians);
				}


				$suffix = "SkewY";
				if(isset($data[$pPrefix.$suffix])){
					$mfor_skew[1] = tan(floatval($data[$pPrefix.$suffix]) * $deg2radians);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_skew[1] = tan(floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians);
				}  else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_skew[1] = tan(floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians);
				}

				$suffix = "Rotation";
				if(isset($data[$pPrefix.$suffix])){
					$nValue = floatval($data[$pPrefix.$suffix]);
					$mfor_rotation[0] = cos($nValue * $deg2radians);
					$mfor_rotation[1] = sin($nValue * $deg2radians);
					$mfor_rotation[2] = -sin($nValue * $deg2radians);
					$mfor_rotation[3] = cos($nValue * $deg2radians);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$nValue = floatval($this -> _sharedMatrix[$selector][$suffix]);
					$mfor_rotation[0] = cos($nValue * $deg2radians);
					$mfor_rotation[1] = sin($nValue * $deg2radians);
					$mfor_rotation[2] = -sin($nValue * $deg2radians);
					$mfor_rotation[3] = cos($nValue * $deg2radians);
				} else if(isset($data[$this -> _initPrefix.$suffix])){
					$nValue = floatval($data[$this -> _initPrefix.$suffix]);
					$mfor_rotation[0] = cos($nValue * $deg2radians);
					$mfor_rotation[1] = sin($nValue * $deg2radians);
					$mfor_rotation[2] = -sin($nValue * $deg2radians);
					$mfor_rotation[3] = cos($nValue * $deg2radians);
				}

				$suffix = "TranslateX";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'X'])  ){
					if(isset($data[$pPrefix.$suffix]))
						$mfor_translate[4] = floatval($data[$pPrefix.$suffix]);
					elseif(isset($data[$pPrefix.'X']))
						$mfor_translate[4] = floatval($data[$pPrefix.'X']);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_translate[4] = floatval($this -> _sharedMatrix[$selector][$suffix]);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_translate[4] = floatval($data[$this -> _initPrefix.$suffix]);
				}

				$suffix = "TranslateY";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Y'])){
					if(isset($data[$pPrefix.$suffix]))
						$mfor_translate[5] = floatval($data[$pPrefix.$suffix]);
					elseif(isset($data[$pPrefix.'Y']))
						$mfor_translate[5] = floatval($data[$pPrefix.'Y']);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_translate[5] = floatval($this -> _sharedMatrix[$selector][$suffix]);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_translate[5] = floatval($data[$this -> _initPrefix.$suffix]);
				}

				$matrix = $this ->_mulMatrix($mfor_translate, $mfor_scale);
				$matrix = $this ->_mulMatrix($matrix, $mfor_rotation);
				$matrix = $this ->_mulMatrix($matrix, $mfor_skew);
				$matrix = 'matrix('.implode(',',$matrix).')';

				$params["transform"] = array();
				$params["transform"]["values"]  = array();
				$params["transform"]["values"][] = $matrix;


				if(($this -> hasCurrent($pObject -> getName(), 'Transform')
					&& $this -> getCurrent($pObject -> getName(), 'Transform') !==  $matrix)
					|| !$this -> hasCurrent($pObject -> getName(), 'Transform')){
					$this -> storeCurrent($pObject -> getName(), 'Transform',  $matrix);
				} else{
					unset($params["transform"]);
				}

			}
			if(in_array("matrix3d", $types)){
				$mfor_translate = 	array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1);
				$mfor_scale = 		array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1);
				$mfor_skew = 		array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1);
				$mfor_rotation_x =  array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1);
				$mfor_rotation_y =  array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1);
				$mfor_rotation_z =  array(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1);
				$deg2radians = floatval(floatval(pi()) * 2 / 360);

				$suffix = "Scale";
				if(isset($data[$pPrefix.$suffix])){
					$mfor_scale[0] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					$mfor_scale[5] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
				} else {
					$suffix = "ScaleX";
					if(isset($data[$pPrefix.$suffix])){
						$mfor_scale[0] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
						$mfor_scale[0] = $this -> _sharedMatrix[$selector][$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($this -> _sharedMatrix[$selector][$suffix]);
					} else if(isset($data[$this -> _initPrefix.$suffix])) {
						$mfor_scale[0] = $data[$this -> _initPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$this -> _initPrefix.$suffix]);
					}

					$suffix = "ScaleY";
					if(isset($data[$pPrefix.$suffix])){
						$mfor_scale[5] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
						$mfor_scale[5] = $this -> _sharedMatrix[$selector][$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($this -> _sharedMatrix[$selector][$suffix]);
					} else if(isset($data[$this -> _initPrefix.$suffix])) {
						$mfor_scale[5] = $data[$this -> _initPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$this -> _initPrefix.$suffix]);
					}


					$suffix = "ScaleZ";
					if(isset($data[$pPrefix.$suffix])){
						$mfor_scale[10] = $data[$pPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$pPrefix.$suffix]);
					} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
						$mfor_scale[10] = $this -> _sharedMatrix[$selector][$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($this -> _sharedMatrix[$selector][$suffix]);
					} else if(isset($data[$this -> _initPrefix.$suffix])) {
						$mfor_scale[10] = $data[$this -> _initPrefix.$suffix] == 0 ? $this -> _default_zero_scale_matrix : floatval($data[$this -> _initPrefix.$suffix]);
					}
				}

				$suffix = "SkewX";
				if(isset($data[$pPrefix.$suffix])){
					$mfor_skew[4] = tan(floatval($data[$pPrefix.$suffix]) * $deg2radians);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_skew[4] = tan(floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_skew[4] = tan(floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians);
				}


				$suffix = "SkewY";
				if(isset($data[$pPrefix.$suffix])){
					$mfor_skew[1] = tan(floatval($data[$pPrefix.$suffix]) * $deg2radians);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_skew[1] = tan(floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_skew[1] = tan(floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians);
				}

				$suffix = "RotationX";
				if(isset($data[$pPrefix.$suffix])){
					$nValue = floatval($data[$pPrefix.$suffix]) * $deg2radians;
					$mfor_rotation_x =  array(1,0,0,0,0,cos($nValue),sin($nValue),0,0,-sin($nValue),cos($nValue),0,0,0,0,1);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$nValue = floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians;
					$mfor_rotation_x =  array(1,0,0,0,0,cos($nValue),sin($nValue),0,0,-sin($nValue),cos($nValue),0,0,0,0,1);
				} else if(isset($data[$this -> _initPrefix.$suffix])){
					$nValue = floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians;
					$mfor_rotation_x =  array(1,0,0,0,0,cos($nValue),sin($nValue),0,0,-sin($nValue),cos($nValue),0,0,0,0,1);
				}

				$suffix = "RotationY";
				if(isset($data[$pPrefix.$suffix])){
					$nValue = floatval($data[$pPrefix.$suffix]) * $deg2radians;
					$mfor_rotation_y =  array(cos($nValue),0,-sin($nValue),0,0,1,0,0,sin($nValue),0,cos($nValue),0,0,0,0,1);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$nValue = floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians;
					$mfor_rotation_y =  array(cos($nValue),0,-sin($nValue),0,0,1,0,0,sin($nValue),0,cos($nValue),0,0,0,0,1);
				} else if(isset($data[$this -> _initPrefix.$suffix])){
					$nValue = floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians;
					$mfor_rotation_y =  array(cos($nValue),0,-sin($nValue),0,0,1,0,0,sin($nValue),0,cos($nValue),0,0,0,0,1);
				}

				$suffix = "RotationZ";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Rotation'])){
					if(isset($data[$pPrefix.$suffix])){
						$nValue = floatval($data[$pPrefix.$suffix]) * $deg2radians;
					}else if(isset($data[$pPrefix.'Rotation'])){
						$nValue = floatval($data[$pPrefix.'Rotation']) * $deg2radians;
					}
					$mfor_rotation_z =  array(cos($nValue),sin($nValue),0,0,-sin($nValue),cos($nValue),0,0,0,0,1,0,0,0,0,1);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$nValue = floatval($this -> _sharedMatrix[$selector][$suffix]) * $deg2radians;
					$mfor_rotation_z =  array(cos($nValue),sin($nValue),0,0,-sin($nValue),cos($nValue),0,0,0,0,1,0,0,0,0,1);
				} else if(isset($data[$this -> _initPrefix.$suffix])){
					$nValue = floatval($data[$this -> _initPrefix.$suffix]) * $deg2radians;
					$mfor_rotation_z =  array(cos($nValue),sin($nValue),0,0,-sin($nValue),cos($nValue),0,0,0,0,1,0,0,0,0,1);
				}



				$suffix = "TranslateX";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'X']) ){
					if(isset($data[$pPrefix.$suffix]))
						$mfor_translate[12] = floatval($data[$pPrefix.$suffix]);
					elseif(isset($data[$pPrefix.'X']))
						$mfor_translate[12] = floatval($data[$pPrefix.'X']);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_translate[12] = floatval($this -> _sharedMatrix[$selector][$suffix]);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_translate[12] = floatval($data[$this -> _initPrefix.$suffix]);
				}

				$suffix = "TranslateY";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Y'])){
					if(isset($data[$pPrefix.$suffix]))
						$mfor_translate[13] = floatval($data[$pPrefix.$suffix]);
					elseif(isset($data[$pPrefix.'Y']))
						$mfor_translate[13] = floatval($data[$pPrefix.'Y']);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_translate[13] = floatval($this -> _sharedMatrix[$selector][$suffix]);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_translate[13] = floatval($data[$this -> _initPrefix.$suffix]);
				}

				$suffix = "TranslateZ";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Z'])){
					if(isset($data[$pPrefix.$suffix]))
						$mfor_translate[14] = floatval($data[$pPrefix.$suffix]);
					elseif(isset($data[$pPrefix.'Z']))
						$mfor_translate[14] = floatval($data[$pPrefix.'Z']);
				} else if(isset($this -> _sharedMatrix[$selector][$suffix])) {
					$mfor_translate[14] = floatval($this -> _sharedMatrix[$selector][$suffix]);
				} else if(isset($data[$this -> _initPrefix.$suffix])) {
					$mfor_translate[14] = floatval($data[$this -> _initPrefix.$suffix]);
				}

				$matrix = $this ->_mulMatrix3D($mfor_translate, $mfor_scale);
				$matrix = $this ->_mulMatrix3D($matrix, $mfor_rotation_x);
				$matrix = $this ->_mulMatrix3D($matrix, $mfor_rotation_y);
				$matrix = $this ->_mulMatrix3D($matrix, $mfor_rotation_z);
				$matrix = $this ->_mulMatrix3D($matrix, $mfor_skew);
				$matrix = 'matrix3d('. implode(',', $matrix).')';


				$params["transform"] = array();
				$params["transform"]["values"]  = array();
				$params["transform"]["values"][] = $matrix;

				if(($this -> hasCurrent($pObject -> getName(), 'Transform')
					&& $this -> getCurrent($pObject -> getName(), 'Transform') !== $matrix)
					|| !$this -> hasCurrent($pObject -> getName(), 'Transform')){
					$this -> storeCurrent($pObject -> getName(), 'Transform', $matrix);
				} else{
					 unset($params["transform"]);
				}
			}

			if($bases)
				$params = $this -> _animsBaseValues($pObject, $params, $pPrefix, $transformStyle, $allowSuffix);

			foreach($types as $t){
					if(in_array($t, $transform3dTypes) && $transformStyle && !self::$avoidTransformStyle){
						if(!isset($params["transformStyle"] )){
							$params["transformStyle"] = array();
							$params["transformStyle"]["values"] = array("preserve-3d");
					}
				}

			}

			$params = $this -> _removeEmptyParams($params);

			if(!is_null($animation_name)){
					$this -> _data_storage[$animation_name] = $params;
			}

			return $params;
		}






		protected function _storeMatrix(AnimationObject $pObject, $pPrefix){
			$types = $pObject -> getAllowedTypes();
			$data = $pObject -> getAnimationData();
			$name = $pObject -> getName();
			$selector = $pObject -> getSelector();

			if(in_array("matrix", $types)){

				if(!isset($this -> _sharedMatrix[$selector]))
					$this -> _sharedMatrix[$selector] = array();

				$suffix = "Scale";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector]['ScaleX'] = $data[$pPrefix.$suffix];
					$this -> _sharedMatrix[$selector]['ScaleY'] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix])  && !(isset($this -> _sharedMatrix[$selector]['ScaleX']) || isset($this -> _sharedMatrix[$selector]['ScaleY']))) {
					$this -> _sharedMatrix[$selector]['ScaleX'] = $data[$this -> _initPrefix.$suffix];
					$this -> _sharedMatrix[$selector]['ScaleY'] = $data[$this -> _initPrefix.$suffix];
				} else {
					$suffix = "ScaleX";
					if(isset($data[$pPrefix.$suffix])){
						$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
					} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
					} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = 1;
					}

					$suffix = "ScaleY";
					if(isset($data[$pPrefix.$suffix])){
						$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
					} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
					} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = 1;
					}
				}


				$suffix = "SkewX";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}


				$suffix = "SkewY";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}


				$suffix = "Rotation";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}


				$suffix = "TranslateX";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'X'])){
					$nsuffix = isset($data[$pPrefix.$suffix]) ? $suffix : 'X';
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$nsuffix];
				} else if((isset($data[$this -> _initPrefix.$suffix]) || isset($data[$pPrefix.'X'])) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "TranslateY";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Y'])){
					$nsuffix = isset($data[$pPrefix.$suffix]) ? $suffix : 'Y';
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$nsuffix];
				} else if((isset($data[$this -> _initPrefix.$suffix]) || isset($data[$pPrefix.'Y'])) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}



			}
			if(in_array("matrix3d", $types)){

				if(!isset($this -> _sharedMatrix[$selector]))
					$this -> _sharedMatrix[$selector] = array();

				$suffix = "Scale";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector]['ScaleX'] = $data[$pPrefix.$suffix];
					$this -> _sharedMatrix[$selector]['ScaleY'] = $data[$pPrefix.$suffix];
					$this -> _sharedMatrix[$selector]['ScaleZ'] = 1;
				} else if(isset($data[$this -> _initPrefix.$suffix])  && !(isset($this -> _sharedMatrix[$selector]['ScaleX']) || isset($this -> _sharedMatrix[$selector]['ScaleY']) || isset($this -> _sharedMatrix[$selector]['ScaleZ']))) {
					$this -> _sharedMatrix[$selector]['ScaleX'] = $data[$this -> _initPrefix.$suffix];
					$this -> _sharedMatrix[$selector]['ScaleY'] = $data[$this -> _initPrefix.$suffix];
					$this -> _sharedMatrix[$selector]['ScaleZ'] = 1;

				} else {
					$suffix = "ScaleX";
					if(isset($data[$pPrefix.$suffix])){
						$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
					} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
					} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = 1;
					}

					$suffix = "ScaleY";
					if(isset($data[$pPrefix.$suffix])){
						$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
					} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
					} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = 1;
					}


					$suffix = "ScaleZ";
					if(isset($data[$pPrefix.$suffix])){
						$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
					} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
					} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
						$this -> _sharedMatrix[$selector][$suffix] = 1;
					}
				}

				$suffix = "SkewX";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}


				$suffix = "SkewY";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "RotationX";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "RotationY";
				if(isset($data[$pPrefix.$suffix])){
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$suffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "RotationZ";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Rotation'])){
					$nsuffix = isset($data[$pPrefix.$suffix]) ? $suffix : 'Rotation';
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$nsuffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "TranslateX";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'X'])){
					$nsuffix = isset($data[$pPrefix.$suffix]) ? $suffix : 'X';
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$nsuffix];
				} else if((isset($data[$this -> _initPrefix.$suffix]) || isset($data[$pPrefix.'X'])) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "TranslateY";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Y'])){
					$nsuffix = isset($data[$pPrefix.$suffix]) ? $suffix : 'Y';
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$nsuffix];
				} else if((isset($data[$this -> _initPrefix.$suffix]) || isset($data[$pPrefix.'Y'])) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}

				$suffix = "TranslateZ";
				if(isset($data[$pPrefix.$suffix]) || isset($data[$pPrefix.'Z'])){
					$nsuffix = isset($data[$pPrefix.$suffix]) ? $suffix : 'Z';
					$this -> _sharedMatrix[$selector][$suffix] = $data[$pPrefix.$nsuffix];
				} else if(isset($data[$this -> _initPrefix.$suffix]) && !isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = $data[$this -> _initPrefix.$suffix];
				} else if(!isset($this -> _sharedMatrix[$selector][$suffix])) {
					$this -> _sharedMatrix[$selector][$suffix] = 0;
				}


			}

		}



		protected function _animsBaseValues(AnimationObject $pObj, $pParams, $pPrefix, $transformStyle, $allowSuffix){

			$b = $pObj -> getBases() -> getObjects();
			$data = $pObj -> getAnimationData();
			$transform3dTypes = array("translate3d","translateZ","scale3d","scaleZ","rotation3d","rotationX","rotationY","rotationZ","global_rotation3d","matrix3d");


			foreach($b as $base){



				$props = $base -> getProperties();

				foreach($props as $prop){

					if(!$prop -> isAnimationProperty){
						if($pPrefix != $this -> _initPrefix){
							continue;
						}

					}

					$values = $prop -> getValues();
					$tag = $prop -> getPropertyName();

					if(!isset($pParams[$tag]))
						$pParams[$tag] = array();


					$type = $prop -> getType();


					if($type === PropertyType::SINGLE){
						if(!isset($pParams[$tag]["values"]))
							$pParams[$tag]["values"] = array();
					}
					$i = 0;
					foreach($values as $value){
						$name = $value -> getPropertyValue() -> getName();
						$unit = $value -> getPropertyValue() -> getUnit();
						if(isset($data[$pPrefix . $name])){

							if($this -> has_js_var($data[$pPrefix . $name]) && $unit !== ''){
								$pParams[$tag]["values"][($i++)] = !$allowSuffix ? $data[$pPrefix . $name] : strval($data[$pPrefix . $name]).'+\''.$unit.'\'';
							}
							else if(!$this -> is_bool($data[$pPrefix . $name])){
								$pParams[$tag]["values"][($i++)] = !$allowSuffix ? $data[$pPrefix . $name] : strval($data[$pPrefix . $name]).$unit;
							}
							else{
								$pParams[$tag]["values"][($i++)] = $data[$pPrefix . $name];
							}

						}
					}


					if(isset($pParams[$tag]) && !count($pParams[$tag]["values"])){
						unset($pParams[$tag]);
					}
					else if(in_array($tag, $transform3dTypes)){
						if(!isset($pParams["transformStyle"]) && $transformStyle && !self::$avoidTransformStyle){
							$pParams["transformStyle"] = array();
							$pParams["transformStyle"]["values"] = array("preserve-3d");
						}
					}

					if(isset($pParams[$tag])){
					if(count($pParams[$tag]["values"]) > 1){
					 if(($this -> hasCurrent($pObj -> getName(), ucfirst($tag))
					 && $this -> getCurrent($pObj -> getName(), ucfirst($tag)) !== implode(',',$pParams[$tag]["values"]))
					 || !$this -> hasCurrent($pObj -> getName(), ucfirst($tag))){

						 $store = true;
						 foreach($pParams[$tag]["values"] as $p){
						 	if($this -> _isRel($p)){
						 		$store = false;
						 		break;
						 	}
						 }
						 if($store){
						 	$this -> storeCurrent($pObj -> getName(), ucfirst($tag), implode(',',$pParams[$tag]["values"]));
						 }

				 } else{
					 unset($pParams[$tag]);
				 }} else {
					 if(($this -> hasCurrent($pObj -> getName(), ucfirst($tag))
					&& $this -> getCurrent($pObj -> getName(), ucfirst($tag)) !== $pParams[$tag]["values"][0])
					|| !$this -> hasCurrent($pObj -> getName(), ucfirst($tag))){
					if(!$this -> _isRel($pParams[$tag]["values"][0]))
						$this -> storeCurrent($pObj -> getName(), ucfirst($tag), $pParams[$tag]["values"][0]);
					else
						$this -> detachCurrent($pObj -> getName(), ucfirst($tag));
				} else{
					 unset($pParams[$tag]);
				 }
}
				}}

			}
			$pObj -> setAnimationData($data);
			return $pParams;
		}

		/**
		 * @method
		 *
		 * Multiplie 2 matrices 2D.
		 *
		 * @param 'array' Matrice 1.
		 * @param 'array' Matrice 2.
		 */
		protected function _mulMatrix($m1, $m2){

			$nM = array(0,0,0,0,0,0);
			$nM[0] = ($m1[0] * $m2[0]) + ($m1[2] * $m2[1]) + ($m1[4] * 0);
			$nM[1] = ($m1[1] * $m2[0]) + ($m1[3] * $m2[1]) + ($m1[5] * 0);
			$nM[2] = ($m1[0] * $m2[2]) + ($m1[2] * $m2[3]) + ($m1[4] * 0);
			$nM[3] = ($m1[1] * $m2[2]) + ($m1[3] * $m2[3]) + ($m1[5] * 0);
			$nM[4] = ($m1[0] * $m2[4]) + ($m1[2] * $m2[5]) + ($m1[4] * 1);
			$nM[5] = ($m1[1] * $m2[4]) + ($m1[3] * $m2[5]) + ($m1[5] * 1);

			for($i = 0; $i < count($nM) ; $i++){
				$nM[$i] = rtrim(rtrim(sprintf("%.10f",$nM[$i]),'0'),'.');
			}


			return $nM;
		}

		/**
		 * @method
		 *
		 * Multiplie 2 matrices 3D.
		 *
		 * @param 'array' Matrice 1.
		 * @param 'array' Matrice 2.
		 */
		protected function _mulMatrix3D($m1, $m2){

			$nM = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);


			$nM[0] = ($m1[0] * $m2[0]) + ($m1[4] * $m2[1]) + ($m1[8] * $m2[2]) + ($m1[12] * $m2[3]);
			$nM[1] = ($m1[1] * $m2[0]) + ($m1[5] * $m2[1]) + ($m1[9] * $m2[2]) + ($m1[13] * $m2[3]);
			$nM[2] = ($m1[2] * $m2[0]) + ($m1[6] * $m2[1]) + ($m1[10] * $m2[2]) + ($m1[14] * $m2[3]);
			$nM[3] = ($m1[3] * $m2[0]) + ($m1[7] * $m2[1]) + ($m1[11] * $m2[2]) + ($m1[15] * $m2[3]);

			$nM[4] = ($m1[0] * $m2[4]) + ($m1[4] * $m2[5]) + ($m1[8] * $m2[6]) + ($m1[12] * $m2[7]);
			$nM[5] = ($m1[1] * $m2[4]) + ($m1[5] * $m2[5]) + ($m1[9] * $m2[6]) + ($m1[13] * $m2[7]);
			$nM[6] = ($m1[2] * $m2[4]) + ($m1[6] * $m2[5]) + ($m1[10] * $m2[6]) + ($m1[14] * $m2[7]);
			$nM[7] = ($m1[3] * $m2[4]) + ($m1[7] * $m2[5]) + ($m1[11] * $m2[6]) + ($m1[15] * $m2[7]);

			$nM[8] = ($m1[0] * $m2[8]) + ($m1[4] * $m2[9]) + ($m1[8] * $m2[10]) + ($m1[12] * $m2[11]);
			$nM[9] = ($m1[1] * $m2[8]) + ($m1[5] * $m2[9]) + ($m1[9] * $m2[10]) + ($m1[13] * $m2[11]);
			$nM[10] = ($m1[2] * $m2[8]) + ($m1[6] * $m2[9]) + ($m1[10] * $m2[10]) + ($m1[14] * $m2[11]);
			$nM[11] = ($m1[3] * $m2[8]) + ($m1[7] * $m2[9]) + ($m1[11] * $m2[10]) + ($m1[15] * $m2[11]);

			$nM[12] = ($m1[0] * $m2[12]) + ($m1[4] * $m2[13]) + ($m1[8] * $m2[14]) + ($m1[12] * $m2[15]);
			$nM[13] = ($m1[1] * $m2[12]) + ($m1[5] * $m2[13]) + ($m1[9] * $m2[14]) + ($m1[13] * $m2[15]);
			$nM[14] = ($m1[2] * $m2[12]) + ($m1[6] * $m2[13]) + ($m1[10] * $m2[14]) + ($m1[14] * $m2[15]);
			$nM[15] = ($m1[3] * $m2[12]) + ($m1[7] * $m2[13]) + ($m1[11] * $m2[14]) + ($m1[15] * $m2[15]);

			for($i = 0; $i < count($nM) ; $i++){
				$nM[$i] = rtrim(rtrim(sprintf("%.10f",$nM[$i]),'0'),'.');
			}


			return $nM;
		}

		protected function strval_map($mixed){

			if(is_array($mixed)){
				$na = array();

				foreach($mixed as $k => $v) {
					if(is_numeric($v)){
						$na[$k] = $v;
					} else if(strpos($v, 'js:') === 0) {
						$na[$k] = substr($v, 3);
					} else if(is_string($v)) {
						$na[$k] = self::$quotes.$v.self::$quotes;
					}  else if(is_bool($v)){
						$na[$k] = $v ? 'true' : 'false';
					}
				}

				return $na;
			} else {
				if(is_numeric($mixed)){
					$mixed = $mixed;
				} else if(strpos($mixed, 'js:') === 0) {
					$mixed = substr($mixed, 3);
				} else if(is_string($mixed)){
					$mixed = self::$quotes.$mixed.self::$quotes;
				} else if(is_bool($mixed)){
					$mixed = $mixed ? 'true' : 'false';
				}

				return $mixed;
			}

		}


		protected function strval_sel($mixed){

			if(strpos($mixed, 'js:') === 0) {
				$mixed = substr($mixed, 3);
			} else if(is_string($mixed)){
				$mixed = self::$quotes.$mixed.self::$quotes;
			}

			return $mixed;


		}

		protected function _removeEmptyParams($pParams){
			$fParams = array();
			foreach($pParams as $k => $v){
				if(isset($v["values"]) || isset($v["attributs"]))
					$fParams[$k] = $v;
			}
			return $fParams;
		}

		protected function _isRel($val){
			if(strpos($val, '+=') === 0 || strpos($val, '-=') === 0)
				return true;
			else
				return false;

		}

		public static function forceTweenLite(){
			self::toTweenLite();
		}

		public static function transformStyle($bool){
			self::$avoidTransformStyle = (bool)$bool;
		}

		public static function defaultTransformPerspective($perspective){
			self::$defaultTransformPerspective = (int)$perspective;
		}

		public static function defaultSkewType($skew_type){
			self::$defaultSkewType = strval($skew_type);
		}

		public static function defaultSmoothOrigin($bool){
			self::$defaultSmoothOrigin = (bool)$bool;
		}

		public static function version($version){
			self::$version = strval($version);
		}


		public static function ExportAppendStyle(){
			self::$_append_style = true;
			self::$_add_style = false;
		}

		public static function ExportClassicStyle(){
			self::$_append_style = false;
			self::$_add_style = false;
		}

		public static function ExportAddStyle(){
			self::$_append_style = false;
			self::$_add_style = true;
		}


		public static function getVersion(){
			return self::$version;
		}

		public static function force3D($bool){
			self::$force3D = (bool)$bool;
		}

		protected function has_js_var($v){
			return (strpos($v, 'js:') === 0) ? true : false;
		}

		protected function has_js_sel($v){
			return (strpos($v, 'js:') === 0) ? true : false;
		}

		protected function is_bool($v){
			return (is_numeric($v)) ? false : ((is_string($v)) ? false : ((is_bool($v))? true : false ));
		}




	}

?>
