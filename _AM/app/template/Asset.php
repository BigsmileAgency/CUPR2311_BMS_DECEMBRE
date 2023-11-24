<?php

	/*
 	 * @author: Big Smile Agency, info@bigsmile.be
 	*/

	class Asset {

		protected $_name;
		protected $_type;
		protected $_file;
		protected $_download_state = false;

		public function __construct($pName, $pFile, $pType = NULL, $pForce = true){
			$this -> _name = $pName;
			$this -> _file = $pFile;
			$this -> _type = $pType;
			$this -> _download_state = (bool)$pForce;
		}


		public function getName(){
			return $this -> _name;
		}

		public function getFile(){
			return $this -> _file;
		}

		public function getType(){
			return $this -> _type;
		}

		public function download(){
		 	$this -> _download_state = true;
		}

		public function ready(){
		 	return $this -> _download_state;
		}

	}


?>