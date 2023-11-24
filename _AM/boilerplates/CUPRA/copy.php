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

  $copies["conso"]["FR"][] = "26-35 g CO<sub>2</sub>/km - 1,2-1,6l/100km - 14,7-16,1kWh/100km";
  $copies["legal"]["FR"][] = "Situation au 01/04/2022 sur base des motorisations approuvées à cette date.";

  $copies["conso"]["NL"][] = "26-35 g CO<sub>2</sub>/km - 1,2-1,6l/100km - 14,7-16,1kWh/100km";
  $copies["legal"]["NL"][] = "Situatie op 01/04/2022 op basis van de goedgekeurde motorisatie op deze datum.";
