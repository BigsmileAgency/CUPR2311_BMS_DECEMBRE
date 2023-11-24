<?php 


	if(!function_exists('asset')){
		function asset($value){
			global $assets;
			return  $assets -> path($value);
		}
	}
	if(!function_exists('width')){
		function width($value){
			global $assets;
			return  $assets -> width($value);
		}
	}
	if(!function_exists('height')){
		function height($value){
			global $assets;
			return  $assets -> height($value);
		}
	}

?>