<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	class GSAPFormatEngine extends FormatEngine {
		
		/**
		 * @constructor
		 */
		 
		protected $_name;
		
		protected $_beginTab1;
		protected $_endTab1;
		protected $_beginTab2;
		protected $_endTab2;
		protected $_beginNewLine;
		protected $_endNewLine;
		protected $_jumpLine;
		protected $_defaultSpace;
		
		protected $_beginFormatKeyword;
		protected $_endFormatKeyword;
		protected $_beginFormatInstance;
		protected $_endFormatInstance;
		protected $_beginFormatFunction;
		protected $_endFormatFunction;
		protected $_beginFormatClass;
		protected $_endFormatClass;
		protected $_beginFormatValue;
		protected $_endFormatValue;
		protected $_beginFormatObject;
		protected $_endFormatObject;
		protected $_beginFormatString;
		protected $_endFormatString;
		protected $_beginFormatNumeric;
		protected $_endFormatNumeric;
		protected $_beginFormatValueNoString;
		protected $_endFormatValueNoString;

		
		protected $_array_colors;
		protected $_simple_array_colors;
		protected $_true_array_colors;
		protected $_array_props;
		protected $_array_prop_values;
		
		public function __construct() {
			
			$this -> _name = "gsapengine";
			$this -> _beginTab1 = "<!-- ".$this -> _name.":beginTab1 -->";
			$this -> _endTab1 = "<!-- ".$this -> _name.":endTab1 -->";
			$this -> _beginTab2 = "<!-- ".$this -> _name.":beginTab2 -->";
			$this -> _endTab2 = "<!-- ".$this -> _name.":endTab2 -->";
			$this -> _beginNewLine = "<!-- ".$this -> _name.":beginNewLine -->";
			$this -> _endNewLine = "<!-- ".$this -> _name.":endNewLine -->";
			$this -> _jumpLine = "<!-- ".$this -> _name.":jumpLine -->";
			$this -> _defaultSpace = "<!-- ".$this -> _name.":defaultSpace -->";
			
			$this -> _beginFormatKeyword = "<!-- ".$this -> _name.":beginFormatKeyword -->";
			$this -> _endFormatKeyword = "<!-- ".$this -> _name.":endFormatKeyword -->";
			$this -> _beginFormatInstance = "<!-- ".$this -> _name.":beginFormatInstance -->";
			$this -> _endFormatInstance = "<!-- ".$this -> _name.":endFormatInstance -->";
			$this -> _beginFormatFunction = "<!-- ".$this -> _name.":beginFormatFunction -->";
			$this -> _endFormatFunction = "<!-- ".$this -> _name.":endFormatFunction -->";
			$this -> _beginFormatClass = "<!-- ".$this -> _name.":beginFormatClass -->";
			$this -> _endFormatClass = "<!-- ".$this -> _name.":endFormatClass -->";
			$this -> _beginFormatValue = "<!-- ".$this -> _name.":beginFormatValue -->";
			$this -> _endFormatValue = "<!-- ".$this -> _name.":endFormatValue -->";
			$this -> _beginFormatString = "<!-- ".$this -> _name.":beginFormatString -->";
			$this -> _endFormatString = "<!-- ".$this -> _name.":endFormatString -->";
			$this -> _beginFormatNumeric = "<!-- ".$this -> _name.":beginFormatNumeric -->";
			$this -> _endFormatNumeric = "<!-- ".$this -> _name.":endFormatNumeric -->";
			$this -> _beginFormatObject = "<!-- ".$this -> _name.":beginFormatObject -->";
			$this -> _endFormatObject = "<!-- ".$this -> _name.":endFormatObject -->";
			$this -> _beginFormatValueNoString = "<!-- ".$this -> _name.":beginFormatValueNoString -->";
			$this -> _endFormatValueNoString = "<!-- ".$this -> _name.":endFormatValueNoString -->";
			
			
			$this -> _array_props = array ("align-content", "align-items", "align-self", "animation", "animation-delay", "animation-direction", "animation-duration"/*, "animation-fill-mode"*/, "animation-iteration-count", "animation-name", "animation-play-state", "animation-timing-function", "backface-visibility", "background", "background-attachment", "background-clip", "background-color", "background-image", "background-origin", "background-position", "background-repeat", "background-size", "border", "border-bottom", "border-bottom-color", "border-bottom-left-radius", "border-bottom-right-radius", "border-bottom-style", "border-bottom-width", "border-collapse", "border-color", "border-image", "border-image-outset", "border-image-repeat", "border-image-slice", "border-image-source", "border-image-width", "border-left", "border-left-color", "border-left-style", "border-left-width", "border-radius", "border-right", "border-right-color", "border-right-style", "border-right-width", "border-spacing", "border-style", "border-top", "border-top-color", "border-top-left-radius", "border-top-right-radius", "border-top-style", "border-top-width", "border-width", "bottom", "box-shadow", "box-sizing", "caption-side", "clear", "clip", "color", "column-count", "column-fill", "column-gap", "column-rule", "column-rule-color", "column-rule-style", "column-rule-width", "column-span", "column-width", "columns", "content", "counter-increment", "counter-reset", "cursor", "direction", "display", "empty-cells", "flex", "flex-basis", "flex-direction", "flex-flow", "flex-grow", "flex-shrink", "flex-wrap", "float", "font", "font-family", "font-size", "font-size-adjust", "font-stretch", "font-style", "font-variant", "font-weight", "hanging-punctuation", "height", "justify-content", "left", "letter-spacing", "line-height", "list-style", "list-style-image", "list-style-position", "list-style-type", "margin", "margin-bottom", "margin-left", "margin-right", "margin-top", "max-height", "max-width", "min-height", "min-width", "nav-down", "nav-index", "nav-left", "nav-right", "nav-up", "opacity", "order", "outline", "outline-color", "outline-offset", "outline-style", "outline-width", "overflow", "overflow-x", "overflow-y", "padding", "padding-bottom", "padding-left", "padding-right", "padding-top", "page-break-after", "page-break-before", "page-break-inside", "perspective", "perspective-origin", "position", "quotes", "resize", "right", "tab-size", "table-layout", "text-align", "text-align-last", "text-decoration", "text-decoration-color", "text-decoration-line", "text-decoration-style", "text-indent", "text-justify", "text-overflow", "text-shadow", "text-transform", "top", "transform", "transform-origin", "transform-style", "transition", "transition-delay", "transition-duration", "transition-property", "transition-timing-function", "unicode-bidi", "vertical-align", "visibility", "white-space", "width", "word-break", "word-spacing", "word-wrap", "z-index");
			$this -> _array_prop_values = array("linear","preserve-3d","auto","hidden","scroll","repeat","no-repeat","repeat-x","repeat-y","inherit","static","relative","absolute","none","rgb","rgba","infinite","alternate","normal","bold","light","bolder","lighter","both","forwards","backwards","center","left","top","right","bottom","to","from","fixed","url","content","content-box","box","inline","block","inline-block","table","table-cell","table-row","padding-box","border-box","initial","solid","dotted","dashed","inset","outset","groove","padding","cover","contain","medium","thin","thick","unset", "ltr", "rtl", "reverse", "alternate-reverse","ease","paused","visible","collapse","local","transparent","space","round","separate","stretch","ridge","double", "avoid","always","inside", "outside", "start", "end","all","open-quote","no-open-quote","no-close-quote","icon","close-quote","pointer","wait","w-resize","vertical-text","text","sw-resize","se-resize","s-resize","row-resize","progress","nwse-resize","nw-resize","ns-resize","not-allowed","no-drop","nesw-resize","ne-resize","n-resize","move","help","ew-resize","e-resize","default","crosshair","copy","context-menu","col-resize","all-scroll","alias","middle","table-row-group","table-header-group","table-footer-group","table-column-group","table-column","table-caption","run-in","list-item","square","circle","inline-table","compact","show","hide","baseline","xx-small","x-small","x-large","smaller","small","larger","large","ultra-expanded","ultra-condensed","semi-expanded","semi-condensed","extra-expanded","extra-condensed","expanded","condensed","lowercase","uppercase","small-caps","oblique","italic","disc","upper-roman","upper-latin","upper-alpha","lower-roman","lower-alpha","lower-latin","lower-greek georgian","decimal-leading-zero","decimal","armenian","fill","invert","break-word","vertical","horizontal","justify","underline","overline","line-through","blink","below","clip","ellipsis","flat","capitalize","embed","bidi-override","text-top","text-bottom","super","sub","pre-wrap","pre-line","pre","nowrap","break-all","break-word");
			$this -> _array_colors = array("AntiqueWhite" => "#FAEBD7","Aqua" => "#00FFFF","Aquamarine" => "#7FFFD4","Azure" => "#F0FFFF","Beige" => "#F5F5DC","Bisque" => "#FFE4C4","Black" => "#000000","BlanchedAlmond" => "#FFEBCD","Blue" => "#0000FF","BlueViolet" => "#8A2BE2","Brown" => "#A52A2A","BurlyWood" => "#DEB887","CadetBlue" => "#5F9EA0","Chartreuse" => "#7FFF00","Chocolate" => "#D2691E","Coral" => "#FF7F50","CornflowerBlue" => "#6495ED","Cornsilk" => "#FFF8DC","Crimson" => "#DC143C","Cyan" => "#00FFFF","DarkBlue" => "#00008B","DarkCyan" => "#008B8B","DarkGoldenRod" => "#B8860B","DarkGray" => "#A9A9A9","DarkGreen" => "#006400","DarkKhaki" => "#BDB76B","DarkMagenta" => "#8B008B","DarkOliveGreen" => "#556B2F","DarkOrange" => "#FF8C00","DarkOrchid" => "#9932CC","DarkRed" => "#8B0000","DarkSalmon" => "#E9967A","DarkSeaGreen" => "#8FBC8F","DarkSlateBlue" => "#483D8B","DarkSlateGray" => "#2F4F4F","DarkTurquoise" => "#00CED1","DarkViolet" => "#9400D3","DeepPink" => "#FF1493","DeepSkyBlue" => "#00BFFF","DimGray" => "#696969","DodgerBlue" => "#1E90FF","FireBrick" => "#B22222","FloralWhite" => "#FFFAF0","ForestGreen" => "#228B22","Fuchsia" => "#FF00FF","Gainsboro" => "#DCDCDC","GhostWhite" => "#F8F8FF","Gold" => "#FFD700","GoldenRod" => "#DAA520","Gray" => "#808080","Green" => "#008000","GreenYellow" => "#ADFF2F","HoneyDew" => "#F0FFF0","HotPink" => "#FF69B4","IndianRed" => "#CD5C5C","Indigo" => "#4B0082","Ivory" => "#FFFFF0","Khaki" => "#F0E68C","Lavender" => "#E6E6FA","LavenderBlush" => "#FFF0F5","LawnGreen" => "#7CFC00","LemonChiffon" => "#FFFACD","LightBlue" => "#ADD8E6","LightCoral" => "#F08080","LightCyan" => "#E0FFFF","LightGoldenRodYellow" => "#FAFAD2","LightGray" => "#D3D3D3","LightGreen" => "#90EE90","LightPink" => "#FFB6C1","LightSalmon" => "#FFA07A","LightSeaGreen" => "#20B2AA","LightSkyBlue" => "#87CEFA","LightSlateGray" => "#778899","LightSteelBlue" => "#B0C4DE","LightYellow" => "#FFFFE0","Lime" => "#00FF00","LimeGreen" => "#32CD32","Linen" => "#FAF0E6","Magenta" => "#FF00FF","Maroon" => "#800000","MediumAquaMarine" => "#66CDAA","MediumBlue" => "#0000CD","MediumOrchid" => "#BA55D3","MediumPurple" => "#9370DB","MediumSeaGreen" => "#3CB371","MediumSlateBlue" => "#7B68EE","MediumSpringGreen" => "#00FA9A","MediumTurquoise" => "#48D1CC","MediumVioletRed" => "#C71585","MidnightBlue" => "#191970","MintCream" => "#F5FFFA","MistyRose" => "#FFE4E1","Moccasin" => "#FFE4B5","NavajoWhite" => "#FFDEAD","Navy" => "#000080","OldLace" => "#FDF5E6","Olive" => "#808000","OliveDrab" => "#6B8E23","Orange" => "#FFA500","OrangeRed" => "#FF4500","Orchid" => "#DA70D6","PaleGoldenRod" => "#EEE8AA","PaleGreen" => "#98FB98","PaleTurquoise" => "#AFEEEE","PaleVioletRed" => "#DB7093","PapayaWhip" => "#FFEFD5","PeachPuff" => "#FFDAB9","Peru" => "#CD853F","Pink" => "#FFC0CB","Plum" => "#DDA0DD","PowderBlue" => "#B0E0E6","Purple" => "#800080","RebeccaPurple" => "#663399","Red" => "#FF0000","RosyBrown" => "#BC8F8F","RoyalBlue" => "#4169E1","SaddleBrown" => "#8B4513","Salmon" => "#FA8072","SandyBrown" => "#F4A460","SeaGreen" => "#2E8B57","SeaShell" => "#FFF5EE","Sienna" => "#A0522D","Silver" => "#C0C0C0","SkyBlue" => "#87CEEB","SlateBlue" => "#6A5ACD","SlateGray" => "#708090","Snow" => "#FFFAFA","SpringGreen" => "#00FF7F","SteelBlue" => "#4682B4","Tan" => "#D2B48C","Teal" => "#008080","Thistle" => "#D8BFD8","Tomato" => "#FF6347","Turquoise" => "#40E0D0","Violet" => "#EE82EE","Wheat" => "#F5DEB3","White" => "#FFFFFF","WhiteSmoke" => "#F5F5F5","Yellow" => "#FFFF00","YellowGreen" => "#9ACD32");
			$this -> _true_array_colors = array();
			$this -> _simple_array_colors = array();
		}		
		
		public function format($value){
			$value = preg_replace('/<!--\s'.$this -> _name.':defaultSpace\s-->/isU', ' ', $value);

			$value = preg_replace_callback('/<!--\s'.$this -> _name.':beginFormatValue\s-->(.*)<!--\s'.$this -> _name.':endFormatValue\s-->/isU', array($this, '_formatValue'), $value);
			$value = preg_replace_callback('/<!--\s'.$this -> _name.':beginFormatValueNoString\s-->(.*)<!--\s'.$this -> _name.':endFormatValueNoString\s-->/isU', array($this, '_formatValue_no_String'), $value);
			
			$value = preg_replace('/<!--\s'.$this -> _name.':defaultSpace\s-->/isU', ' ', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginTab1\s-->(.*)<!--\s'.$this -> _name.':endTab1\s-->/isU', '  $1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginTab2\s-->(.*)<!--\s'.$this -> _name.':endTab2\s-->/isU', '  $1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginTab1\s-->(.*)<!--\s'.$this -> _name.':endTab1\s-->/isU', '  $1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginTab2\s-->(.*)<!--\s'.$this -> _name.':endTab2\s-->/isU', '  $1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginNewLine\s-->(.*)<!--\s'.$this -> _name.':endNewLine\s-->/isU', "$1\n", $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':jumpLine\s-->/isU', "\n", $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatKeyword\s-->(.*)<!--\s'.$this -> _name.':endFormatKeyword\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatInstance\s-->(.*)<!--\s'.$this -> _name.':endFormatInstance\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatFunction\s-->(.*)<!--\s'.$this -> _name.':endFormatFunction\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatClass\s-->(.*)<!--\s'.$this -> _name.':endFormatClass\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatObject\s-->(.*)<!--\s'.$this -> _name.':endFormatObject\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatString\s-->(.*)<!--\s'.$this -> _name.':endFormatString\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':beginFormatNumeric\s-->(.*)<!--\s'.$this -> _name.':endFormatNumeric\s-->/isU', '$1', $value);
			$value = preg_replace('/<!--\s'.$this -> _name.':defaultSpace\s-->/isU', ' ', $value);
	
			return $value;
		
		}
		
		

		
		
		protected function _convertRGB($hex){
			 $hex = str_replace("#", "", $hex);

   			if(strlen($hex) == 3) {
      			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
     			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
      			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
   			} else {
      			$r = hexdec(substr($hex,0,2));
      			$g = hexdec(substr($hex,2,2));
      			$b = hexdec(substr($hex,4,2));
   			}
  			 $rgb = array($r, $g, $b);
   
   			return "rgb(".$rgb[0].",".$this -> _defaultSpace."".$rgb[1].",".$this -> _defaultSpace."".$rgb[2].")";

		}
		
		protected function _formatValue($prop){
			$prop = $prop[1];
			$emphase = false;
			$entire = "";
			
			
			if(preg_match("#(.*)\((.*)\)#isU",$prop,$matches)){
				$emphase = true;
				$entire .= $matches[1]."(";
				$prop = $matches[2];
			}	
			$a_prop = explode(" ",$prop);
			$a_index = 0;
			
			if(count($a_prop) > 1){
				foreach($a_prop as $pr){
					$a_prop_2 =  explode(",",$pr);
					$a_index_2 = 0;
					if($a_index > 0)
						$entire .= "";
					if(count($a_prop_2)  > 1){
						foreach($a_prop_2 as $pr2){
							if($a_index_2 > 0)
								$entire .= ",".$this -> _defaultSpace;
							$entire .= is_numeric($pr2) ? $this -> _beginFormatNumeric.$pr2. $this -> _endFormatNumeric :$this -> _beginFormatString."'".$pr2."'".$this -> _endFormatString;
							$a_index_2++;
						}
					} else {
						if(preg_match("/^\#/i",$pr)){
							if(preg_match("/^\#[0-9A-F]{6}$/i",$pr)){
								$newProp = $this -> _convertRGB($pr);
							} else if(preg_match("/^\#[0-9A-F]{3}$/i",$pr)){
								$r = substr($prop,1,1).substr($pr,1,1);
								$g = substr($prop,2,1).substr($pr,2,1);
								$b = substr($prop,3,1).substr($pr,3,1);
								$newProp = $this -> _convertRGB("#".$r.$g.$b);
							}
							else
								$newProp = $pr;
							$pr = is_numeric($newProp) ? $this -> _beginFormatNumeric.$newProp. $this -> _endFormatNumeric :$this -> _beginFormatString."'".$newProp."'".$this -> _endFormatString;
						}
						$entire .= $pr;
					}
					$a_index++;
				}
			} else {
				$a_prop =  explode(",",$prop);
				$a_index = 0;
				if(count($a_prop)  > 1){
					foreach($a_prop as $pr){
						if($a_index > 0)
							$entire .= ",".$this -> _defaultSpace. $pr;
						else
							$entire .= is_numeric($pr) ? $this -> _beginFormatNumeric.$pr. $this -> _endFormatNumeric :$this -> _beginFormatString."'".$pr."'".$this -> _endFormatString;
						$a_index++;
					}
				} else {
					if(preg_match("/^\#/i",$prop)){
						if(preg_match("/^\#[0-9A-F]{6}$/i",$prop)){
							$newProp = $this -> _convertRGB($prop);
						} else if(preg_match("/^\#[0-9A-F]{3}$/i",$prop)){
							$r = substr($prop,1,1).substr($prop,1,1);
							$g = substr($prop,2,1).substr($prop,2,1);
							$b = substr($prop,3,1).substr($prop,3,1);
							$newProp = $this -> _convertRGB("#".$r.$g.$b);
						}
						else
							$newProp = $prop;
						$prop = is_numeric($newProp) ? $this -> _beginFormatNumeric.$newProp. $this -> _endFormatNumeric :$this -> _beginFormatString."'".$newProp."'".$this -> _endFormatString;
					}
			
					$entire .= is_numeric($prop) ? $this -> _beginFormatNumeric.$prop. $this -> _endFormatNumeric :$this -> _beginFormatString."'".$prop."'".$this -> _endFormatString;
				}
			}
			
			if($emphase)
				$entire .= ")";
			return $entire;
		}
		
		protected function _formatValue_no_String($prop){
			$prop = $prop[1];
			$emphase = false;
			$entire = "";
			
			
			if(preg_match("#(.*)\((.*)\)#isU",$prop,$matches)){
				$emphase = true;
				$entire .= $matches[1]."(";
				$prop = $matches[2];
			}	
			$a_prop = explode(" ",$prop);
			$a_index = 0;
			
			if(count($a_prop) > 1){
				foreach($a_prop as $pr){
					$a_prop_2 =  explode(",",$pr);
					$a_index_2 = 0;
					if($a_index > 0)
						$entire .= "";
					if(count($a_prop_2)  > 1){
						foreach($a_prop_2 as $pr2){
							if($a_index_2 > 0)
								$entire .= ",".$this -> _defaultSpace;
							$entire .= is_numeric($pr2) ? $pr2 : $pr2;
							$a_index_2++;
						}
					} else {
						if(preg_match("/^\#/i",$pr)){
							if(preg_match("/^\#[0-9A-F]{6}$/i",$pr)){
								$newProp = $this -> _convertRGB($pr);
							} else if(preg_match("/^\#[0-9A-F]{3}$/i",$pr)){
								$r = substr($prop,1,1).substr($pr,1,1);
								$g = substr($prop,2,1).substr($pr,2,1);
								$b = substr($prop,3,1).substr($pr,3,1);
								$newProp = $this -> _convertRGB("#".$r.$g.$b);
							}
							else
								$newProp = $pr;
							$pr = is_numeric($newProp) ? $newProp : $newProp;
						}
						$entire .= $pr;
					}
					$a_index++;
				}
			} else {
				$a_prop =  explode(",",$prop);
				$a_index = 0;
				if(count($a_prop)  > 1){
					foreach($a_prop as $pr){
						if($a_index > 0)
							$entire .= ",".$this -> _defaultSpace. $pr;
						else
							$entire .= is_numeric($pr) ? $pr : $pr;
						$a_index++;
					}
				} else {
					if(preg_match("/^\#/i",$prop)){
						if(preg_match("/^\#[0-9A-F]{6}$/i",$prop)){
							$newProp = $this -> _convertRGB($prop);
						} else if(preg_match("/^\#[0-9A-F]{3}$/i",$prop)){
							$r = substr($prop,1,1).substr($prop,1,1);
							$g = substr($prop,2,1).substr($prop,2,1);
							$b = substr($prop,3,1).substr($prop,3,1);
							$newProp = $this -> _convertRGB("#".$r.$g.$b);
						}
						else
							$newProp = $prop;
						$prop = is_numeric($newProp) ? $newProp : $newProp ;
					}
			
					$entire .= is_numeric($prop) ? $prop : $prop;
				}
			}
			
			if($emphase)
				$entire .= ")";
			return $entire;
		}

	}
	
?>