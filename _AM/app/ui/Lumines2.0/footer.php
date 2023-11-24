<?php

	if((isset($files) && $files === '') || !isset($files)){
		$dirs = scandir(".");
		$files = "";

		$anchor = 0;
		foreach($dirs as $d){
			$n = preg_replace("/([0-9]+x[0-9]+)/isU",'$1',$d);
			if(preg_match("/([0-9]+x[0-9]+)/isU",$n)){
				if($d == $current)
					$files .= '<a name="anchor'.strval($anchor).'" class="file_link current" href="'.$d.'">'.$n.'</a>';
				else
					$files .= '<a name="anchor'.strval($anchor).'" class="file_link" href="'.$d.'">'.$n.'</a>';
				$anchor++;
			}

		}
	}
	$project -> apply();
	if(count(Module::all()))
	{
		$iframe = '<iframe id="iframe" style="visibility: hidden" onload="loading();" scrolling="no" frameborder="0" src="'.AppPath::getPath().'/temporary/uiview/'.$campaign -> getFullName().'/index.html?i='.uniqid().'" width="'.intval($campaign -> getFormat() -> getWidth()) .'" height="'.
    intval($campaign -> getFormat() -> getHeight()).'"></iframe>';
		$iframe_clone = '<iframe id="iframe_clone" style="visibility: hidden" onload="loading();" scrolling="no" frameborder="0" src="'.AppPath::getPath().'/temporary/uiview/'.$campaign -> getFullName().'/index.html?i='.uniqid().'" width="'.intval($campaign -> getFormat() -> getWidth()) .'" height="'.
    intval($campaign -> getFormat() -> getHeight()).'"></iframe>';

	} else {
		$iframe = '<iframe id="iframe" scrolling="no" frameborder="0" src="export/'.$type.'/'.$campaign -> getFullName().'/index.html?i='.uniqid().'" width="'.intval($campaign -> getFormat() -> getWidth()) .'" height="'.
    intval($campaign -> getFormat() -> getHeight()).'"></iframe>';
		$iframe_clone = '<iframe id="iframe_clone" scrolling="no" frameborder="0" src="export/'.$type.'/'.$campaign -> getFullName().'/index.html?i='.uniqid().'" width="'.intval($campaign -> getFormat() -> getWidth()) .'" height="'.
    intval($campaign -> getFormat() -> getHeight()).'"></iframe>';

	}
	
	echo $iframe_clone;

	echo $iframe;

	echo	'<div id="right_column" class="ui"><div id="open_all"></div><div id="bkupimg"></div><div class="right_column_header '. str_replace('-', '_', $type).'">File list</div><div id="file_list">'.$files.'</div></div>';
	echo  '<div id="time_container" class="ui '. str_replace('-', '_', $type).'"><span id="time" class="'. str_replace('-', '_', $type).'">00.00</span>&nbsp;/&nbsp;<span id="duration" class="'. str_replace('-', '_', $type).'">00.00</span></div>';
?>
<div id="numpad" class="ui">
	<div id="num7" class="numkey"></div>
	<div id="num8" class="numkey"></div>
	<div id="num9" class="numkey"></div>
	<div id="num4" class="numkey"></div>
	<div id="num5" class="numkey"></div>
	<div id="num6" class="numkey"></div>
	<div id="num1" class="numkey"></div>
	<div id="num2" class="numkey"></div>
	<div id="num3" class="numkey"></div>
</div>
<div id="infos_box" <?php echo 'class="'. str_replace('-', '_', $type).' ui"'?>><strong><?php echo $am -> version ?></strong><br><?php echo $am -> copyright ?><br>
	<a style="font-family: Verdana,Helvetica,sans-serif; font-size: 10px" href="<?php echo AppPath::getPath(); ?>/ui/Lumines/news.php" target="_blank">
		<strong>à propos de la version <?php echo $am -> version ?></strong>
	</a>
</div>
<div id="valid_box" <?php echo 'class="'. str_replace('-', '_', $type).' ui"'?>>
	<strong>Utils for <?php echo strtoupper(htmlentities($type, ENT_QUOTES, 'UTF-8')); ?></strong><br>
	<?php if($type === 'dcm' || $type === 'dcm-hpto') { ?>
		<a style="text-decoration: none; font-family: Verdana,Helvetica,sans-serif; font-size: 13px " href="https://h5validator.appspot.com/dcm" target="_blank">
			h5validator dcm
		</a><br>
	<?php } else if($type === 'gdn') {?>
		<a style="text-decoration: none; font-family: Verdana,Helvetica,sans-serif; font-size: 13px " href="https://h5validator.appspot.com/adwords" target="_blank">
			h5validator adwords
		</a><br>
	<?php } else if($type === 'sizmek' || $type === 'sizmek-interstitial' || $type === 'sizmek-expandable') {?>
		<a style="text-decoration: none; font-family: Verdana,Helvetica,sans-serif; font-size: 13px " href="https://platform.mediamind.com/" target="_blank">
			Sizmek MDX Platform
		</a><br>
	<?php } else if($type === 'dcrm' || $type === 'dcrm-video' || $type === 'dcrm-overlayer' || $type === 'dcrm-lightbox') {?>
		<a style="text-decoration: none; font-family: Verdana,Helvetica,sans-serif; font-size: 13px " href="	https://www.google.com/doubleclick/studio/homepage/legacy?hl=fr
" target="_blank">
			DoubleClick Studio
		</a><br>
	<?php }  ?>

		<a style="text-decoration: none; font-family: Verdana,Helvetica,sans-serif; font-size: 13px " href="https://validator.w3.org/nu/" target="_blank">
			Validator W3 nu
		</a><br>
		<a style="text-decoration: none; font-family: Verdana,Helvetica,sans-serif; font-size: 13px " href="https://validator.w3.org/" target="_blank">
			Validator W3
		</a>

</div>
<div id="timeline_container" class="<?php echo str_replace('-', '_', $type); ?> ui"><div id="time_passed" class="<?php echo str_replace('-', '_', $type); ?>"></div></div>

</body>
</html>
