<?php 

	if(!function_exists('modules')) {
		function modules($f){
			include AppPath::getPath().'/modules/'.$f.'/'.$f.'.js';
		}
	}
	?>