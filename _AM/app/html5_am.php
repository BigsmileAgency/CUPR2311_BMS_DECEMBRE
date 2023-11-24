#!/cli/php
<?php

	if(isset($_SERVER['argv'][1]) && trim($_SERVER['argv'][1]) === 'create-project'){
		include('cli/create-project.php');
	}

?>