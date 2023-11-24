<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class AppPath {


		protected static $_path = "_am";

		public static function path($pPath){
			self::$_path = $pPath;
		}



		public static function getPath(){
			return self::$_path;
		}
		

	}

?>
