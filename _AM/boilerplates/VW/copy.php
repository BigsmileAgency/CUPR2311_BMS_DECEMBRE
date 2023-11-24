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

  $copies["conso"]["FR"][] = "<span>ID. Range 15,4 - 20,8 KWH /100 km • 0 G /km CO<sub>2</sub> (WLTP)</span>";
  $copies["legal"]["FR"][] = "Contactez votre concessionnaire pour toute information relative à la fiscalité de votre véhicule. Informations environnementales (A.R. 19/03/2004) : volkswagen.be.";

  $copies["conso"]["NL"][] = "<span>ID. Range 15,4 - 20,8 KWU /100 km • 0 G /km CO<sub>2</sub> (WLTP)</span>";
  $copies["legal"]["NL"][] = "Contacteer uw concessiehouder voor alle informatie over de fiscaliteit van uw voertuig. Milieu-informatie (KB 19/03/2004): volkswagen.be.";
