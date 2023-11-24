#container{
  background-color: <?= $theme['color'] ?>;

  .txt,.text,.txt_mentions,#txt_legal{
    color: <?= $theme['txt_color'] ?>;
  }

  #logo{
    <?= $theme['logo_style'] != 'default' ? 'overflow: visible;' : ''; ?>
    path{
      fill: <?= $theme['logo_color']; ?> !important;
    }
  }

  #cta{
    color: <?= $theme['cta_main_txt_color']; ?>;
    background: <?= $theme['cta_main_color']; ?>;
  }

  .legal{
    padding: <?= $theme['legal_padding']; ?>;
  }
}

<?php include('_am/boilerplates/'.$client.'/style/theme.scss') ?>
<?php include('_am/boilerplates/'.$client.'/style/dieteren_logo.scss') ?>
