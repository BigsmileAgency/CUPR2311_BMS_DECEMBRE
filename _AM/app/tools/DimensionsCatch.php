<?php

	class DimensionsCatch {

		public static function dim($d, $pattern = null){

            if(is_null($pattern)){
                return self::dim2($d);
            }

			if(!is_dir($d)) {
            	return false;
        	}

            if(@preg_match($pattern, null) === false){
                $isRegExp = false;
            }else{
                $isRegExp = true;
            }

        	$array = array();
        	$dirH = opendir($d);

        	while(($file = readdir($dirH)) !== false) {

                $isTheFile = $isRegExp ? preg_match($pattern, $file) : $pattern == $file;
        		if((strcmp($file , '.') == 0 || strcmp($file , '..') == 0) || !$isTheFile || !is_readable($d.DIRECTORY_SEPARATOR. $file)) {
                	continue;
            	}

            	$path = str_replace('/', DIRECTORY_SEPARATOR, $d.DIRECTORY_SEPARATOR. $file);
                $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

                if(@is_array(getimagesize($path))){
                    $is = getimagesize($path);
                    array_push($array, array('file' => $file, 'path' => $path , 'width' => $is[0] , 'height' => $is[1]));
                } else {
                    $ext = strrchr($path, '.');

                    if(strtolower($ext) === '.svg'){
                        $cont = file_get_contents($path);

                        $pattern_tmp = '/<svg(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)>/i';
                        $pattern_tmp2 = '/<svg(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)>/i';

                        if(preg_match($pattern_tmp, $cont, $m)){
                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[1]) , 'height' => floatval($m[2])));
                        } else if(preg_match($pattern_tmp2, $cont, $m)) {
                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[2]) , 'height' => floatval($m[1])));
                        } else {
                             $pattern_tmp3 = '/<svg(?:[^>]*?)viewBox=\"(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                             $pattern_tmp4 = '/<svg(?:[^>]*?)enable-background=\"new\s(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                             $pattern_tmp5 = '/<svg(?:[^>]*?)style=\"enable-background\:new\s(.*?)\s(.*?)\s(.*?)\s(.*?);\"(?:[^>]*?)>/i';
                           if(preg_match($pattern_tmp3, $cont, $m)){
                                array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                            } else if(preg_match($pattern_tmp4, $cont, $m)) {
                                array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                            } else if(preg_match($pattern_tmp5, $cont, $m)) {
                                array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                            } else {
                                 continue;
                            }
                        }
                    } else {
                        if(strtolower($ext) === '.php'){
                            $n = explode('.', $path);
                            if(count($n) > 2){
                                if($n[count($n) - 2] === "svg"){
                                    $cont = file_get_contents($path);

                                    $pattern_tmp = '/<svg(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)>/i';
                                    $pattern_tmp2 = '/<svg(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)>/i';
                                    if(preg_match($pattern_tmp, $cont, $m)){
                                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[1]) , 'height' => floatval($m[2])));
                                    } else if(preg_match($pattern_tmp2, $cont, $m)) {
                                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[2]) , 'height' => floatval($m[1])));
                                    } else {
                                         $pattern_tmp3 = '/<svg(?:[^>]*?)viewBox=\"(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                                         $pattern_tmp4 = '/<svg(?:[^>]*?)enable-background=\"new\s(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                                         $pattern_tmp5 = '/<svg(?:[^>]*?)style=\"enable-background\:new\s(.*?)\s(.*?)\s(.*?)\s(.*?);\"(?:[^>]*?)>/i';
                                       if(preg_match($pattern_tmp3, $cont, $m)){
                                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                                        } else if(preg_match($pattern_tmp4, $cont, $m)) {
                                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                                        } else if(preg_match($pattern_tmp5, $cont, $m)) {
                                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                                        } else {
                                             continue;
                                        }
                                    }
                                } else{
                                   continue;
                                }
                            } else{
                               continue;
                            }
                        } else{
                           continue;
                        }
                    }
                }
        	}

        	return $array;


		}


        protected static function dim2($d){
            if(!is_readable($d)) {
                return false;
            }

            $array = array();

            $path = str_replace('/', DIRECTORY_SEPARATOR, $d);
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
            $file = substr($path, strrpos($path, DIRECTORY_SEPARATOR) + 1);

            if(@is_array(getimagesize($path))){
                $is = getimagesize($path);

                array_push($array, array('file' => $file, 'path' => $path , 'width' => $is[0] , 'height' => $is[1]));
            } else {
                $ext = strrchr($path, '.');

                if(strtolower($ext) === '.svg'){
                    $cont = file_get_contents($path);

                    $pattern_tmp = '/<svg(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)>/i';
                    $pattern_tmp2 = '/<svg(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)>/i';

                    if(preg_match($pattern_tmp, $cont, $m)){
                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[1]) , 'height' => floatval($m[2])));
                    } else if(preg_match($pattern_tmp2, $cont, $m)) {
                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[2]) , 'height' => floatval($m[1])));
                    } else {
                         $pattern_tmp3 = '/<svg(?:[^>]*?)viewBox=\"(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                         $pattern_tmp4 = '/<svg(?:[^>]*?)enable-background=\"new\s(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                         $pattern_tmp5 = '/<svg(?:[^>]*?)style=\"enable-background\:new\s(.*?)\s(.*?)\s(.*?)\s(.*?);\"(?:[^>]*?)>/i';
                       if(preg_match($pattern_tmp3, $cont, $m)){
                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                        } else if(preg_match($pattern_tmp4, $cont, $m)) {
                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                        } else if(preg_match($pattern_tmp5, $cont, $m)) {
                            array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                        }
                    }
                } else {
                    if(strtolower($ext) === '.php'){
                        $n = explode('.', $path);
                        if(count($n) > 2){
                            if($n[count($n) - 2] === "svg"){
                                $cont = file_get_contents($path);

                                $pattern_tmp = '/<svg(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)>/i';
                                $pattern_tmp2 = '/<svg(?:[^>]*?)height=\"([^>]*?)\"(?:[^>]*?)width=\"([^>]*?)\"(?:[^>]*?)>/i';
                                if(preg_match($pattern_tmp, $cont, $m)){
                                    array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[1]) , 'height' => floatval($m[2])));
                                } else if(preg_match($pattern_tmp2, $cont, $m)) {
                                    array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[2]) , 'height' => floatval($m[1])));
                                } else {
                                     $pattern_tmp3 = '/<svg(?:[^>]*?)viewBox=\"(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                                     $pattern_tmp4 = '/<svg(?:[^>]*?)enable-background=\"new\s(.*?)\s(.*?)\s(.*?)\s(.*?)\"(?:[^>]*?)>/i';
                                     $pattern_tmp5 = '/<svg(?:[^>]*?)style=\"enable-background\:new\s(.*?)\s(.*?)\s(.*?)\s(.*?);\"(?:[^>]*?)>/i';
                                   if(preg_match($pattern_tmp3, $cont, $m)){
                                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                                    } else if(preg_match($pattern_tmp4, $cont, $m)) {
                                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                                    } else if(preg_match($pattern_tmp5, $cont, $m)) {
                                        array_push($array, array('file' => $file, 'path' => $path , 'width' =>  floatval($m[3]) , 'height' => floatval($m[4])));
                                    }
                                }
                            }
                        }
                    }
                }
            }


            return $array;


        }

	}

?>