<div id="logo__container" class="abs logo format__<?= str_replace("x","_", $format); ?> justify__<?= $theme['logo_position_justify']; ?>--logo align__<?= $theme['logo_position_align']; ?>--logo">
  <div class="logo__content">
    <?php include('_am/boilerplates/'.$client.'/assets/logo.svg'); ?>
  </div>
</div>

<?php if (!$theme['disable_legal']) { ?>
<div id="legal" class="abs legal format__<?= str_replace("x","_", $format); ?>">
  <div class="legal__txt<?= $theme['legal_conso_inline'] ? ' legal__txt--line' : '' ?>">
      <div class="txt legal__txt--conso-legal">
        <span id="conso__txt"><?= $cm['conso'] ?></span>

        <?php if ($theme['show_legal_line']) {
            if (!$theme['legal_conso_inline']) { echo '<div id="legal__txt" class="legal__column">'; } ?>
            <span id="legal__txt">
              <?= $cm['legal'] ?>
            </span>
            <?php if (!$theme['legal_conso_inline']) { echo '</div>'; }
          }
        ?>
      </div>
  </div>
</div>
<?php } ?>
