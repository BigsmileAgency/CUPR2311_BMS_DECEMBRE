<?php 
	
	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/
	
	final class Campaign {
		
		private $_name;
		private $_format;
		private $_lang;
		private $_version;
		private $_full_name;
		private $_separator;
		
		/**
		 * @constructor
		 */
		public function __construct($pName, $pFormat, $pLang = NULL, $pVersion = NULL, $pSeparator = '-'){

			$this -> _name = $pName;
			$this -> setFormat($pFormat);
			$this -> _lang = $pLang;
			$this -> _version = $pVersion;
			$this -> _separator = $pSeparator;
		}
		
		public function getName(){
			return $this -> _name;
    }
    
    public function getNameNoLang(){
      $ret = $this -> _name;

      $from = ["-FR", "-NL"];
      $with   = ["", ""];

      $newstr = str_replace($from, $with, $ret);
			return $newstr;
    }
    
		public function setFormat($pValue){
			if($pValue instanceof Format){
				$this -> _format = $pValue;
			} else {
				if(preg_match('/^([0-9]+)[x|X]([0-9]+)$/', $pValue, $matches)){
					$format = new Format($matches[1], $matches[2]);
					$this -> _format = $format;
				} else {
					throw new Exception("Campaign : Wrong format parameter at setFormat().");
					die();
				}
			}
		}
		public function getFullName(){
			$ret = $this -> _name.$this -> _separator.$this -> _format -> getWidth().'x'.$this -> _format -> getHeight();
			$ret .=  $this -> _lang != NULL ? $this -> _separator.$this -> _lang : '';
			$ret .=  $this -> _version != NULL ? $this -> _separator.$this -> _version : '';
			return $ret;
			
		}
		public function getFormat(){
			return $this -> _format;
		}
		public function getLang(){
			return $this -> _lang;	
		}
		public function getVersion(){
			return $this -> _version;	
		}
		
		public function setSeparator($pValue){
			$this -> _separator = $pValue;
		}
		
		public function getSeparator(){
			return $this -> _separator;
		}
		
		
		
		
	}
	
?>