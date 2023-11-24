

  <!-- START CONTENT -->
  <?php include 'common/assets/NAME_TO_INCLUDE.EXT'; ?>
  <img src="<?= $assets -> path('KEY_NAME') ?>" alt="" class="">

  <!-- CopiesManager use -->
  <?= $cm['id']; // Returns from common/copy.php the string corresponding to the key 'id' corresponding to the actual format, if exists (see copy.php for more details ?>
  <?= $cm->Format('id', 'container_name'); // Same as above, but wrap the text into a dom contained <container_name></container_name>. The contained will have the id 'id' and a class 'txt' ?>
  <?= $cm->Format('id', 'container_name', 'prefix', 'sufix'); // Same as above, but add the given prefix and/or suffix to the retrieved text ?>
  <?php $cm->SetDOMWrapper('container_name'); // Specifies a default container to applay to all $cm['id'] calls without the need to call Format anymore ?>
  <? // For more details, check CopiesManager class in common/utils/helpers/copy.helper.php ?>
  <!-- END CONTENT -->
