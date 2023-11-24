<?php if ($theme['is_white_border']) { ?>
  <div class="white__border" class="abs format__<?= str_replace("x","_", $format); ?>"></div>
<?php } ?>

<?php if ($theme['is_legal_outside_border']) { ?>
  <div class="legal__txt--column abs<?= !$theme['is_legal_extra_inline'] ? ' plus__column' : '' ?><?= $theme['is_legal_inline'] ? ' line' : '' ?>">
    <span class="legal__txt--inner"><?= $cm['legal'] ?></span>
    <?php if ($theme['is_legal_extra']) { ?>
      <span class="legal__txt--plus"><?= $cm['legal_extra'] ?></span>
    <?php } ?>
  </div>
<?php } ?>

<div class="legal abs format__<?= str_replace("x","_", $format); ?><?= $theme['is_legal_inline'] ? ' line' : '' ?><?= $theme['is_legal_outside_border'] ? ' column' : '' ?>">
<?php if (!$theme['is_legal_outside_border']) { ?>
  <div class="legal__txt<?= !$theme['is_legal_extra_inline'] ? ' plus__column' : '' ?>">
    <span><?= $cm['legal'] ?></span>
    <?php if ($theme['is_legal_extra']) { ?>
      <span class="legal__txt--plus"><?= $cm['legal_extra'] ?></span>
    <?php } ?>
  </div>
<?php } ?>
  <img class="legal__logo" src="<?= $assets -> path('logo_full') ?>" alt="Carrefour">
</div>

<?php if ($theme['is_simple_logo']) { ?>
  <div class="simple_logo--container abs">
    <?php include("_am/boilerplates/".$client."/assets/simple_logo.svg.php") ?>
  </div>
<?php } ?>
