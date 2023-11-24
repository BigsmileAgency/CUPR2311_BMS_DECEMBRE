#container{
  background-color: <?= $theme['color'] ?>;

  .txt,.text,.txt_mentions,#txt_legal{
    color: <?= $theme['txt_color'] ?>;
  }

  #logo__container{
    .logo__content{
      padding: <?= $theme['logo_padding']; ?>;
    }
    svg{
      path{
        fill: <?= $theme['logo_color']; ?> !important;
      }
    }
  }

  .legal{
    padding: <?= $theme['legal_padding']; ?>;
  }
}

<?php include('_am/boilerplates/'.$client.'/style/logo.scss') ?>
<?php include('_am/boilerplates/'.$client.'/style/theme.scss') ?>
