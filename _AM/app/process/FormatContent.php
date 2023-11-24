<?php

	class FormatContent {

		public static function formattedContent($p, $data, $assets = null, $context = null) {
			$ext = substr($p , strrpos($p , '.') + 1);

			if($ext == 'php' || $ext == 'php5'){
				ob_start();
				unset($ext);
				extract($data);
				require($p);

        $context = new stdClass();

				if($assets) $context -> _data_passed['assets'] = $assets;

				//include(AppPath::getPath().'/helpers/helpers-view.php');
				unset($p);
				$html = ob_get_clean();

			} else {
				$html = file_get_contents($p);
			}
			return $html;
		}
	}

?>
