<div class="white__border abs format__<?= str_replace("x","_", $format); ?>"></div>

<?php
include('_am/boilerplates/' . $client . '/assets/logo-' . $theme['logo_style'] . '.svg.php');
?>

  <div id="conso" class="conso abs format__<?= str_replace("x","_", $format); ?>">
    <span id="mention"><?= $cm['mention'] ?></span>
    <p id="legalnotions">
      <?= $cm['legal'] ?>
    </p>
  </div>
