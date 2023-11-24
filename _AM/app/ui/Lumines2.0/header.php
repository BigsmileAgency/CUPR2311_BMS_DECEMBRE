<?php $ms = Module::all();  $template_name = "Lumines2.0" ?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>AM</title>
	<link rel="stylesheet" href="<?php echo AppPath::getPath(); ?>/ui/<?php echo $template_name ?>/style.css" media="screen" charset="utf-8">
	<?php foreach($ms as $mod) {
		echo $mod -> uiImports();

	} ?>

	<?php foreach($ms as $mod) {
		echo '<script>'.$mod -> script($project).'</script>';

	} ?>
	<script type="text/javascript" src="<?php echo AppPath::getPath(); ?>/ui/<?php echo $template_name ?>/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="<?php echo AppPath::getPath(); ?>/ui/<?php echo $template_name ?>/script.js"></script>
</head>
<body>
