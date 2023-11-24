<?php


  class AutoSettings {
    public static function get_settings($banner_name, $has_language = true){
        $formats = array();
        $languages = array();
        $files = '';
        
        if($has_language){
          $sd = scandir('.');
          foreach($sd as $s){
            if(!($s == '.' || $s == '..')){
              if(is_numeric(strpos($s, '-DATA'))){
                $nsplit = explode('-', $s);
                if(count($nsplit) > 1){
                  array_push($languages, $nsplit[count($nsplit) - 2]);
                  $formats[$nsplit[count($nsplit) - 2]] = array();
                }
              }
            }
          }

          if((isset($_GET['language']) && !in_array($_GET['language'], $languages)) || !isset($_GET['language'])){
            $language = $languages[0];
            $current_lg = $language;
          } else{
            $language = $_GET['language'];
            $current_lg = $language;
          }

        } 
        
        $project_name =  $banner_name.(($has_language === true) ? "-".$language : "");

        if($has_language){
          foreach($languages as $lg){
            $sd = scandir($banner_name.'-'.$lg."-DATA");

            foreach($sd as $s){
              if(!($s == '.' || $s == '..')){
                if(is_dir($banner_name.'-'.$lg."-DATA/".$s)){
                  if(preg_match('/([0-9]{1,4}x[0-9]{1,4})$/i', $s, $m)){
                    array_push($formats[$lg], $m[1]);
                  }
                }
              }
            }
          }
        } else {
          $sd = scandir($project_name."-DATA");
          foreach($sd as $s){
            if(!($s == '.' || $s == '..')){
              if(is_dir($project_name."-DATA/".$s)){
                if(preg_match('/([0-9]{1,4}x[0-9]{1,4})$/i', $s, $m)){
                  array_push($formats, $m[1]);

                }
              }
            }
          }
        }

        if($has_language){
          if((isset($_GET['format']) && !in_array($_GET['format'], $formats[$current_lg])) || !isset($_GET['format'])){
            if(!count($formats[$current_lg])){
              throw new Exception('Aucun formats dans la campagne '.$current_lg.'. Veuillez rajouter au moins un format à cette langue.');
              die();
            }

            $fsplit = explode('x', $formats[$current_lg][0]);
            $banner_width = $fsplit[0];
            $banner_height = $fsplit[1];
            $current_format = $formats[$current_lg][0];

          } else{
            $fsplit = explode('x', $_GET['format']);
            $banner_width = $fsplit[0];
            $banner_height = $fsplit[1];
            $current_format = $_GET['format'];
          }
        } else {
          if((isset($_GET['format']) && !in_array($_GET['format'], $formats)) || !isset($_GET['format'])){
            if(!count($formats)){
              throw new Exception('Aucun formats. Veuillez rajouter au moins un format.');
              die();
            }

            $fsplit = explode('x', $formats[0]);
            $banner_width = $fsplit[0];
            $banner_height = $fsplit[1];
            $current_format = $formats[0];

          } else{

            $fsplit = explode('x', $_GET['format']);
            $banner_width = $fsplit[0];
            $banner_height = $fsplit[1];
            $current_format = $_GET['format'];
          }
        }
        

        if($has_language){
           foreach($formats as $lg => $v){
            foreach($v as $frmt){
              if($frmt === $current_format && $lg === $current_lg){
                 $files .= '<a class="file_link current" href="?format='.$frmt.'&language='.$lg.'">'.$banner_name.'-'.$lg.'-'.$frmt.'</a>';
              } else {
                 $files .= '<a class="file_link" href="?format='.$frmt.'&language='.$lg.'">'.$banner_name.'-'.$lg.'-'.$frmt.'</a>';
              }
            }
          }
        } else {
          foreach($formats as $frmt){
            if($frmt === $current_format){
               $files .= '<a class="file_link current" href="?format='.$frmt.'">'.$project_name.'-'.$frmt.'</a>';
            } else {
               $files .= '<a class="file_link" href="?format='.$frmt.'">'.$project_name.'-'.$frmt.'</a>';
            }
          }
        }
        
        $r_array = array('files' => $files, 'banner_width' =>  $banner_width, 'banner_height' =>  $banner_height,  'format' => $banner_width."x".$banner_height, 'project_name' =>  $project_name,'full_name' => $project_name."-DATA/".$banner_name.(($has_language === true) ? "-".$language : "")."-".$banner_width."x".$banner_height);
        
        if($has_language) {
          $r_array['language'] = $language;
        }

        return $r_array;
    }
  }
 


?>