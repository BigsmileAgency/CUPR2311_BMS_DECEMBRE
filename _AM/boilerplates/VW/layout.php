<?php
  include('_am/boilerplates/'.$client.'/assets/logo_'.$theme['logo_style'].'.svg') ;
?>

<div id="cta" class="abs">
  <?= $cm['cta'] ?>
</div>

<div id="legal" class="abs legal <?= $theme['conso_inline_dieteren'] ? 'inline' : 'column'; ?> format__<?= str_replace("x","_", $format); ?>">
  <div class="legal__logo<?= $theme['show_legal'] ? ' is__legal' : '' ?>">
    <img class="logo_secu" src="<?= $assets -> path('logo_dieteren') ?>" alt="">
    <?php if (in_array($format, $theme['format_conso_inline_dieteren'])) { ?>
        <div class="txt legal__txt">
          <div class="txt legal__txt--conso">
            <?= $cm['conso'] ?>
          </div>
        </div>
    <?php } ?>
  </div>
  <div class="legal__txt<?= $theme['legal_conso_inline'] ? ' legal__txt--line' : '' ?>">
    <?php if (!in_array($format, $theme['format_conso_inline_dieteren']) && !$theme['legal_conso_inline']) { ?>
      <div class="txt legal__txt--conso">
        <?= $cm['conso'] ?>
      </div>
    <?php } ?>
    <?php if ($theme['show_legal']) { ?>
        <div class="txt">
          <?php
            if ($theme['legal_conso_inline']) {
              echo $cm['conso'];
              echo $cm['legal'];
            }else{
              echo $cm['legal'];
            }
          ?>
        </div>
    <?php } ?>
  </div>
</div>
