<?php
  /**
   * Exemple:
   * $copies["copy_1"]["FR"][] = "red";  // [version][LANG][] - Default FR value | ! Must have last empty array
   * $copies["copy_1"]["FR"]["970x250 300x600"] = "blue"; // [version][LANG][formats] - Version for specific formats;
   *
   * Note: copies may contain HTML
   */

  // $copies["copy_1"]["FR"][] = "red";
  // $copies["copy_1"]["FR"]["970x250"] = "<div>green<br>blue</div>";
  // $copies["cta"]["FR"][] = "Découvrez-la ici";

  // $copies["copy_1"]["NL"][] = "red nl";
  // $copies["copy_1"]["NL"]["970x250"] = "<div>green<br>blue nl</div>";
  // $copies["cta"]["NL"][] = "Ontdek hem hier";


  // OR

  // $copies = [
  //   "copy_1" => [
  //     "FR" => [
  //       "default" => "red",
  //       "970x250 300x600" => "<div>green<br>blue</div>"
  //     ],
  //     "NL" => [
  //       "default" => "blue",
  //       "970x250 300x600" => "<div>green<br>blue</div>"
  //     ]
  //   ],
  //   "cta" => [
  //     "FR" => ["default" => "Découvrez-la ici"],
  //     "NL" => ["default" => "Ontdek hem hier"]
  //   ]
  // ];

    ?>

  <!-- CopiesManager usage in index.php -->
  <!-- // Returns from common/copy.php the string corresponding to the key 'id' corresponding to the actual format, if exists (see copy.php for more details -->
  <?= $cm['id']; ?>
  <!-- // Same as above, but wrap the text into a dom contained <container_name></container_name>. The contained will have the id 'id' and a class 'txt' -->
  <?php //$cm->Format('id', 'container_name'); ?>
  <!-- // Same as above, but add the given prefix and/or suffix to the retrieved text -->
  <?php //$cm->Format('id', 'container_name', 'prefix', 'sufix'); ?>
  <!-- // Specifies a default container to applay to all $cm['id'] calls without the need to call Format anymore -->
  <?php //$cm->SetDOMWrapper('container_name'); ?>
  <? // For more details, check CopiesManager class in common/utils/helpers/copy.helper.php ?>
