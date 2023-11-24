<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <!-- GetValueProcess:beginImport -->
    <?php if (!empty($extAssets)) {
        include 'common/utils/config/settings/assets/include_assets.php';
    } ?>
    <!-- GetValueProcess:endImport -->
</head>

<body>
    <!-- GetValueProcess:beginScalable -->
    <!-- CONTENT SCALABLE WEBORAMA SKINS -->
    <!-- GetValueProcess:endScalable -->

    <!-- GetValueProcess:beginContent -->


    <!-- START CONTENT -->
    <!-- IF CLIENT IS MYWAY CHECK LAYOUT.PHP -->
    <img src="<?= $assets->path('bg') ?>" id="bg" alt="" class="abs">
    <img src="<?= $assets->path('car') ?>" id="car" alt="" class="abs">

    <div id="copy" class="copy txt abs">
        <?= $cm['copy']; ?>
    </div>

    <?php if ($format == "300x600" ) { ?>   <!--|| $format == "160x600" || $format == "120x600" -->
        <?php include 'common/assets/logo-long.svg'; ?>
    <?php } else { ?>
        <?php include 'common/assets/logo.svg'; ?>
        <?php if ($format == "970x250" || $format == "728x90" || $format == "320x100" || $format == "320x50") { ?>
            <?php include 'common/assets/brand.svg'; ?>
        <?php } ?>
    <?php } ?>
    <?php include 'common/assets/cta-2-' . $language . '.svg'; ?>
    <?php include 'common/assets/cta-' . $language . '.svg'; ?>

    <!-- END CONTENT -->


    <!-- NO TOUCH AFTER -->
    <?php if ($useBoilerplate) {
        include '_am/boilerplates/' . $client . '/layout.php';
    } ?>


    <?php if ($type != "weborama-skins") { ?><div class="border"></div><?php } ?>
    <!-- GetValueProcess:endContent -->
</body>

</html>