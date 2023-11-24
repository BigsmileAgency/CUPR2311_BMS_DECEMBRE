<?php
  /**
   * Exemple:
   * $copies["copy_1"]["FR"][] = "red fr";  // [version][LANG][] - Default FR value | ! Must have last empty array
   * $copies["copy_1"]["FR"]["970x250 300x600"] = "red<br>fr"; // [version][LANG][formats] - Version for specific formats;
   *
   * $copies["copy_1"]["NL"][] = "red nl"; - Default NL value | ! Must have last empty array
   * $copies["copy_1"]["NL"]["970x250"] = "red<br>nl";
   *
   * Use like this in common/index.php
   * // <?= $cm['copy_1'] ?>
   *
   * Note: copies may contain HTML
   */

  $copies["legal"]["FR"][] = "*Voir conditions en&nbsp;magasin.";
  $copies["legal_extra"]["FR"][] = "<span>© Disney</span><span>© 2022 Marvel</span>";

  $copies["legal"]["NL"][] = "*Zie voorwaarden in je&nbsp;winkel.";
  $copies["legal_extra"]["NL"][] = "<span>© Disney</span><span>© 2022 Marvel</span>";
