<?php 
	
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

	

?>