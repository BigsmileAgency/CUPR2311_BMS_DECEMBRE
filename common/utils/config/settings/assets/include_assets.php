<?php

if (!empty($extAssets)) {
  foreach ($extAssets as $asset) { ?>
    <script src="<?= $assets->path($asset) ?>"></script>
  <?php }
}