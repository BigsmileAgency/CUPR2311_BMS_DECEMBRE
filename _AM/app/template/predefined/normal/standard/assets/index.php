<!doctype html>
<html lang="<!-- ReplaceValueProcess:lang -->">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge<?php /*,chrome=1*/ ?>">
  <meta name="generator" content="Powered by Big Smile Agency">
	<?php if($meta) { ?>
	<meta name="author" content="<!-- ReplaceValueProcess:author -->">
	<meta name="description" content="<!-- ReplaceValueProcess:description -->">
	<meta name="keywords" content="<!-- ReplaceValueProcess:keywords -->">
	<?php } ?>
	<title><!-- ReplaceValueProcess:title --></title>
  	<!-- ReplaceValueProcess:import -->

    <link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- ReplaceValueProcess:content -->
	<script src="animation.js"></script>
	<script>
		<?php if($testComputedStyleForFirefox) { ?>
		var _interval;
		<?php }  ?>

		<?php if($testComputedStyleForFirefox) { ?>
		_interval = setInterval(function(){
		    if(window.getComputedStyle(document.body) || document.defaultView.getComputedStyle(document.body)){
		       clearInterval(_interval);
		<?php } ?>
		       loaded();
		<?php if($testComputedStyleForFirefox) { ?>
		    }
		}, 20);
		<?php } ?>
  	</script>
</body>
</html>
