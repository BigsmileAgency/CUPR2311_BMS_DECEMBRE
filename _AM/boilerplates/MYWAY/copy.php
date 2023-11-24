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

  $copies["legal"]["FR"][] = "*Avantage maximum pour un CITROËN ë&#8209;SpaceTourer Feel Taille M 75 KWh. L’avantage global reprend la remise et la prime conditionnelle d’aide à la reprise** de 3.500€. **Prime de reprise supplémentaire jusqu’à 3.500€ TVAC valable à l’achat d’un nouveau CITROËN ë&#8209;Spacetourer. Offres valables dans le réseau participant du 01/09/2022 au 30/09/2022, soumises à conditions et réservées aux particuliers.<br>NEW C5 AIRCROSS PLUG-IN HYBRID&nbsp;:&nbsp;1,3 - 1,4&nbsp;L/100&nbsp;KM 28&nbsp;-&nbsp;30&nbsp;G&nbsp;CO2/KM / 16,5&nbsp;-&nbsp;16,7&nbsp;KWH/100KM& (WLTP), Ë&#8209;C4 : 15,3 - 15,6 KWH/100KM (WLTP), C3 : 4,5 - 6,0 L/100 KM 118 - 136 G CO2/KM (WLTP)<br>Plus d’informations dans votre point de vente Citroën ou sur citroen.be";
  $copies["mention"]["FR"][] = "MENTIONS LÉGALES";

  $copies["legal"]["NL"][] = "*Maximum voordeel tot 8.870€ incl BTW voor een Citroën ë-SpaceTourer Feel Maat M 75 KWh. Het globale voordeel is met de voorwaardelijke overnamepremie** van 3.500€ inbegrepen. **Extra overnamepremie tot 3.500€ geldig bij aankoop van een nieuwe CITROËN ë-Spacetourer. Aanbiedingen onder voorwaarden geldig van 01/09/2022 tot 30/09/2022 in de deelnemende CITROËN verkooppunten en voorbehouden aan particulieren. NEW C5 AIRCROSS PLUG-IN HYBRID : 1,3 - 1,4 L/100 KM 28 - 30 G CO2/KM / 16,5 - 16,7 KWH/100KM (WLTP), Ë-C4 : 15,3 - 15,6 KWH/100KM (WLTP), C3 : 4,5 - 6,0 L/100 KM 118 - 136 G CO2/KM (WLTP). Meer info in je Citroën verkooppunt of op citroen.be.";
  $copies["mention"]["NL"][] = "LEGALE VOORWAARDEN";

  $copies["legal"]["LU"][] = "*Avantage maximum pour un CITROËN ë-SpaceTourer Feel Taille M 75 KWh. L’avantage global reprend la remise et la prime conditionnelle d’aide à la reprise** de 3.380€. **Prime de reprise supplémentaire jusqu’à 3.380€ TVAC valable à l’achat d’un nouveau CITROËN ë-Spacetourer. Offres valables dans le réseau participant du 01/09/2022 au 30/09/2022, soumises à conditions et réservées aux particuliers.<br>NEW C5 AIRCROSS PLUG-IN HYBRID : 1,3 - 1,4 L/100 KM 28 - 30 G CO2/KM / 16,5 - 16,7 KWH/100KM (WLTP), Ë-C4 : 15,3 - 15,6 KWH/100KM (WLTP), C3 : 4,5 - 6,0 L/100 KM 118 - 136 G CO2/KM (WLTP)<br>Plus d’informations dans votre point de vente Citroën ou sur citroen.lu";
  $copies["mention"]["LU"][] = "MENTIONS LÉGALES";
