#container{
  background-color: <?= $theme['main_color'] ?>;

  .txt,.text{
    color: <?= $theme['txt_color'] ?>;
  }

  .legal{
    height: <?= $theme['white_border_size_bottom'] ?>px;
    padding: 0 <?= $theme['white_border_size_corner'] ?>px;
    &__txt{
      color: <?= $theme['txt_color'] ?>;
    }
    &__logo{
      height: <?php
        if ($theme['white_border_size_bottom'] - 20 < 0) {
          echo 10;
        }else{
          echo $theme['white_border_size_bottom'] - 20;
        }
      ?>px;
    }
  }

  .legal__txt--column{
    bottom: <?= $theme['white_border_size_bottom'] + 8 ?>px;
    padding: 0 <?= $theme['white_border_size_corner'] + 8 ?>px;
  }

  .white__border{
    border-top: <?= $theme['white_border_size_corner'] ?>px solid white;
    border-left: <?= $theme['white_border_size_corner'] ?>px solid white;
    border-bottom: <?= $theme['white_border_size_bottom'] ?>px solid white;
    border-right: <?= $theme['white_border_size_corner'] ?>px solid white;
  }
}

<?php include('_am/boilerplates/'.$client.'/style/theme.scss') ?>
