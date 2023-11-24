<?php
  // !!! for weborama-skins index.html must be named sinkLeft.html & skinRight.html
  // !!! if weborama-skins + billboard index.html must be named billboard_970x250.html
  // ??? TODO automatic rename
  if ($type == "weborama-skins") {
    $position = "right"; // Move to setting.php

    $project -> position = $position;
    $project -> scalableContent = true; // Activate scaling? This setting affects the "ScalableContent" div

    $project -> minWidth = 100; // If so, how narrow can the scalable content get?

    $project -> scalableContentWidth = 640;
    $project -> scalableContentHeight = 1500;

    if($position == "left"){
      $project -> BG_image = false; // Image file name. If non wanted, use: BG_image = false;
      $project -> BG_color = 'transparent'; // Color used in space not covered by image. Accepts any CSS color value.
      $project -> BG_width = 'auto'; // Width of the wallpaper. Use 'auto' for full viewport scalable size. Use a number for (non-scalabe) fixed size.

    }
  }else {
    $position = '';
  }
