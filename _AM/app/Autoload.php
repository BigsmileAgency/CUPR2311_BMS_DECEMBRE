<?php
	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */
	
	class Autoload {
	
    	private static $_dirs; 
    	private static $_dir; 
     
    	public static function loader($class) {

			if(is_null(self::$_dirs)){
				self::$_dirs = self::getDirs(self::$_dir);
				array_push(self::$_dirs, self::$_dir);
			}
			
     		foreach(self::$_dirs as $dir) {
     	   		$file = $dir.DIRECTORY_SEPARATOR.str_replace('\\', '/', $class.'.php');
     	   		if(file_exists($file)) {
     	   			require($file);
     	   			break;
     	   		}
     	   }
    	}
    	
    	private static function getDirs($pDirectory) {
        	if(substr($pDirectory, -1) == DIRECTORY_SEPARATOR) {
        		$pDirectory = substr($pDirectory, 0, -1);
        	}
        	if(!file_exists($pDirectory) || !is_dir($pDirectory) || !is_readable($pDirectory)) {
            	return array();
        	}

        	$dirH = opendir($pDirectory);
        	$scanRes = array();

        	while(($file = readdir($dirH)) !== FALSE) {
            	if( strcmp($file , '.') == 0 || strcmp($file , '..') == 0) {
                	continue;
            	}

            	$path = $pDirectory .DIRECTORY_SEPARATOR. $file;

            	if(!is_readable($path)) {
                	continue;
            	}

            	if(is_dir($path)) {
                	$scanRes = array_merge($scanRes, self::getDirs($path));
                	$dirName = $path;
                	array_push($scanRes, $dirName);

            	} 
        	}
        	return $scanRes;
    	}
       
        public static function register(){
           self::$_dir = AppPath::getPath();
           spl_autoload_register(array('Autoload', 'loader'));
        }
	}

    
 
?>