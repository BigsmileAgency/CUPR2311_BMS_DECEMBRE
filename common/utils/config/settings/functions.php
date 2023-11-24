<?php

	if(!function_exists('print_encoded')){
		function print_encoded($str){
			echo str_replace("&lt;br&gt;",'<br>',htmlentities($str, ENT_QUOTES, 'UTF-8'));
		}
	}

	if(!function_exists('br')){
		function br($mx){
			global $format;
			if(is_array($mx)) {
				echo in_array($format, $mx) ? '<br>' : '&nbsp;';
			} else {
				echo $mx === $format ? '<br>' : '&nbsp;';
			}
		}
	}

	if(!function_exists('nbsp')){
		function nbsp($mx){
				return str_replace(' ', '&nbsp;', $mx);

		}
	}

	if(!function_exists('getftype')){
		function getftype(){
			global $width, $height, $banner_width, $banner_height;

			if(isset($width) && isset($height)){
				$bw = $width;
				$bh = $height;
			} else {
				$bw = $banner_width;
				$bh = $banner_height;
			}

			if($bw < ($bh / 2)){
				return 'vertical';
			} else if($bh < ($bw / 2)){
				return 'horizontal';
			} else {
				return 'square';
			}
		}
	}


?>
