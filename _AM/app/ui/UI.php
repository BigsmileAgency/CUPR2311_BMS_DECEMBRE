<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class UI {

		protected static $_ui = "Lumines2.0";

		public static function select($pUi){
			self::$_ui = $pUi;
		}

		public static function load($passData){
			extract($passData);
			ob_start();
			require_once AppPath::getPath().'/ui/'.self::$_ui.'/header.php';
			require_once AppPath::getPath().'/ui/'.self::$_ui.'/footer.php';
			echo ob_get_clean();
		}
	}

?>
