<div id="cta" class="abs">
  <?= $cm['cta'] ?>
</div>

<div id="logo__container" class="abs logo format__<?= str_replace("x","_", $format); ?> position__<?= $theme['logo_position']; ?>--logo">
  <div class="logo__content">
  <?php include('_am/boilerplates/'.$client.'/assets/logo_'.$theme['logo_style'].'.svg'); ?>
  </div>
</div>

<div id="legal" class="abs legal format__<?= str_replace("x","_", $format); ?> position__<?= $theme['legal_position']; ?>--legal">
  <div class="legal__content">
    <img class="logo_secu" src="<?= $assets -> path('logo_dieteren') ?>" alt="">
  </div>
</div>

<div id="mask__container" class="abs format__<?= str_replace("x","_", $format); ?>">
  <?php include('_am/boilerplates/'.$client.'/assets/mask_'.$theme['mask_style'].'.svg'); ?>
</div>
