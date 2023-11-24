#container{
  background-color: <?= $theme['main_color'] ?>;

  .txt,.text,.txt_mentions,#txt_legal{
    color: <?= $theme['txt_color'] ?>;
  }

  #mask{
    path{
      fill: <?= $theme['mask_color']; ?> !important;
    }
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

  #cta{
    color: <?= $theme['cta_main_txt_color']; ?>;
    border: 1px solid <?= $theme['cta_main_color']; ?>;
  }

  .legal{
    padding: <?= $theme['legal_padding']; ?>;
  }
}

<?php include('_am/boilerplates/'.$client.'/style/theme.scss') ?>
<?php include('_am/boilerplates/'.$client.'/style/logo.scss') ?>
<?php include('_am/boilerplates/'.$client.'/style/mask.scss') ?>
<?php include('_am/boilerplates/'.$client.'/style/logo_dieteren.scss') ?>
