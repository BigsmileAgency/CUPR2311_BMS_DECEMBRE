<?php require '_am/boilerplates/'.$client.'/vars.php'; ?>

#container{
  background-color: <?= $theme['color'] ?>;

  .txt,.text,.txt_mentions,#txt_legal{
    color: <?= $theme['txt_color'] ?>;
  }

  .cta {
    position: absolute;
    border-radius: 2rem;
    padding: 9px 19px 10px 18px;
    font-family: 'SKODANext-Black';
    <?php if ($theme['cta_style'] == "dark") { ?>
      color: <?= $electric ?>;
      background-color: <?= $emerald ?>;
    <?php } else if ($theme['cta_style'] == "light") { ?>
      color: <?= $emerald ?>;
      background-color: <?= $electric ?>;
    <?php } else { ?>
      color: <?= $white ?>;
      background-color: <?= $emerald ?>;
    <?php } ?>
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
}

<?php include('_am/boilerplates/'.$client.'/style/theme.scss.php') ?>
<?php include('_am/boilerplates/'.$client.'/style/logo.scss') ?>
