<?php 
		require '../../Autoload.php';
		  require_once '../../AppPath.php';
		   AppPath::path('../..');
 Autoload::register();

	if(isset($_POST['export'])){
		$f = file_get_contents($_POST['export']);
		$replace = str_replace('.am.aligner-modules.std{left:0}', $_POST['by'], $f);
		file_put_contents($_POST['export'], $replace);

		$zip = new ZipArchiveProcess(null, $_POST['exportDir'],$_POST['zipDir']);
		$zip -> apply();
	}

?>