<?php
  $format_split = explode("x", $format);
?>

#container{
  background-color: <?= $theme['color'] ?>;

  // padding: <?= $theme['padding']; ?>px;

  .txt,.text{
    color: <?= $theme['txt_color'] ?>;
  }

  #logo{
    <?= $theme['logo_style'] != 'default' ? 'overflow: visible;' : ''; ?>
    path{
      fill: <?= $theme['logo_color']; ?> !important;
    }
  }

  .white__border{
    border: <?= $theme['white_border_size'] ?>px solid white;
  }
}

<?php include('_am/boilerplates/'.$client.'/style/font.css') ?>
<?php include('_am/boilerplates/'.$client.'/style/theme.scss') ?>
<?php include('_am/boilerplates/'.$client.'/style/logo.scss.php') ?>
