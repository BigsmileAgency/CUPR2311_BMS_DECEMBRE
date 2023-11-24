#container{
  background-color: <?= $theme['color'] ?>;

  .txt,.text,.txt_mentions,#txt_legal{
    color: <?= $theme['txt_color'] ?>;
  }

  #logo{
    path{
      fill: <?= $theme['logo_color']; ?> !important;
    }
  }

  #cta{
    color: <?= $theme['cta_main_txt_color']; ?>;
    border: 1px solid <?= $theme['cta_main_color']; ?>;
  }
}

<?php include('_am/boilerplates/'.$client.'/style/theme.scss') ?>
