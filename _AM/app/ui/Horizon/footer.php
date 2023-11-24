<div id="app">
  <?php

  if (!isset($_GET['preview'])) {

    // ? DEFAULT MODE

    $project->apply();
    if ($type == "weborama-interscroller") {
      $width = '100%;';
      $height = '100%;';
    } else {
      $width = intval($campaign->getFormat()->getWidth()) . 'px;';
      $height = intval($campaign->getFormat()->getHeight()) . 'px;';
    }

    if (count(Module::all())) {
      $iframe = '<iframe id="iframe" style="visibility: hidden" onload="loading();" scrolling="no" frameborder="0" src="' . AppPath::getPath() . '/temporary/uiview/' . $campaign->getFullName() . '/index.html?i=' . uniqid() . '" width="100%" height="100%"></iframe>';
      $iframe_clone = '<iframe id="iframe_clone" style="visibility: hidden" onload="loading();" scrolling="no" frameborder="0" src="' . AppPath::getPath() . '/temporary/uiview/' . $campaign->getFullName() . '/index.html?i=' . uniqid() . '" width="100%" height="100%"></iframe>';
    } else {
      $iframe_clone = '<iframe id="iframe_clone" scrolling="no" frameborder="0" src="export/' . $type . '/' . $campaign->getFullName() . '/index.html?i=' . uniqid() . '" width="100%" height="100%"></iframe>';
      $iframe = '<iframe id="iframe" scrolling="no" frameborder="0" src="export/' . $type . '/' . $campaign->getFullName() . '/index.html?i=' . uniqid() . '" style="width:' . $width . ' height:' . $height . '"></iframe>';
    }

  ?>

    <div id="iframe_container">
      <div id="iframes">
      <?php
        echo $iframe_clone;
        echo $iframe;
      ?>
      <?php if (!isset($_GET['mod'])) { ?>
        <div id="iframe_info">
          <span><?= $project->obtainData()["format"] ?></span>
          <span><?= $project->obtainData()["language"] ?></span>
        </div>
      <?php } ?>
      </div>
    </div>

    <div id="buttons_container" class="ui">
      <div id="open_all" class="button"></div>
      <div id="bkupimg" class="button"></div>
      <div id="previewBtn" class="button"></div>
      <div id="grid" class="button" data-collapsible=""></div>
      <ul class="gridListSize">
        <li class="line horizontal" data-line="hori"></li>
        <li class="line vertical" data-line="verti"></li>
      </ul>
      <div id="clonedlayer" class="button"></div>
      <div id="information" class="button" data-collapsible=""></div>
      <ul class="informationList">
        <li><strong>SPACEBAR</strong>: play/pause</li>
        <li><strong>UP/DOWN ARROWS</strong>: increase/decrease timeScale</li>
        <li><strong>LEFT ARROW</strong>: rewind</li>
        <li><strong>RIGHT ARROW</strong>: jump to end</li>
        <li><strong>L</strong>: toggle loop</li>
        <li><strong>I</strong>: set the in point to current position of playhead</li>
        <li><strong>O</strong>: set the out point to current position of playhead</li>
        <li><strong>H</strong>: hide/show toggle</li>
      </ul>
      <div id="valid_box">
        <?php
        if ($type === 'dcm' || $type === 'dcm-hpto') {
          $link = "https://h5validator.appspot.com/dcm";
        } else if ($type === 'gdn') {
          $link = "https://h5validator.appspot.com/adwords";
        } else if ($type === 'sizmek' || $type === 'sizmek-interstitial' || $type === 'sizmek-expandable') {
          $link = "https://platform.mediamind.com/";
        } else if ($type === 'dcrm' || $type === 'dcrm-video' || $type === 'dcrm-overlayer' || $type === 'dcrm-lightbox' || $type === 'dcrm-dynamic') {
          $link = "https://www.google.com/doubleclick/studio/homepage/legacy?hl=fr";
        } else {
          $link = "https://clients.weborama.nl/login";
        }
        ?>

        <a id="google_valid" href="<?= $link; ?>" target="_blank"></a>

      </div>
    </div>

    <div id="banners_list" class="ui">
      <ul class="list">
        <li class="campagn_name"><?= $campaign->getNameNoLang() ?></li>
        <?= $files; ?>
      </ul>
    </div>

    <div id="phpdata" style="display: none"><?= $project->obtainData()["banner_name"] ?></div>
    <script type="text/javascript">
      <?php include('client.js'); ?>
    </script>

  <?php
  } else {

    // ? PREVIEW MODE

    $lists = glob('export/' . $type . '/*', GLOB_ONLYDIR);
    $cleanList = array();
    $i = 0;

    foreach ($lists as $folder) {


      if ($folder != 'export/' . $type . '/ziparchives') {

        preg_match('/([0-9]{1,4}x[0-9]{1,4})$/i', $folder, $matchFormat);
        preg_match('/[-|_](NL|FR|EN|LU|DE|UK)[-|_]/', $folder, $matchLang);

        $fsplit = explode('x', $matchFormat[0]);
        $banner_width = $fsplit[0];
        $banner_height = $fsplit[1];

        // print_r($match);
        $cleanList[$i]['url'] = $folder;
        $cleanList[$i]['width'] = $banner_width;
        $cleanList[$i]['height'] = $banner_height;
        $cleanList[$i]['lang'] =  $matchLang[1];

        $i++;
      }
    } ?>

    <div id="preview">
      <h2><?= $campaign->getNameNoLang() ?></h2>
      <div id="frame__container">
        <?php
        foreach ($cleanList as $frame) {

          echo '<div class="frame">
                <h3>' . $frame['width'] . 'x' . $frame['height'] . ' ' . $frame['lang'] . '</h3>
                <iframe scrolling="no" frameborder="0" src="' . $frame['url'] . '/index.html?i=' . uniqid() . '" width="' . $frame['width'] . '" height="' . $frame['height'] . '" "></iframe>
              </div>';
        }
        ?>
      </div>
    </div>

  <?php

  }
  ?>

</div>
</body>

</html>
