<!-- GetValueProcess:beginStyle -->

  @import 'reset';

  @mixin init($l:0, $t:0){
    position: absolute;
    top: $t;
    left: $l;
  }

  @mixin cnt(){
    width: <?php echo $width ?>px;
    height: <?php echo $height ?>px;
  }

  @mixin total(){
    width: 100%;
    height: 100%;
  }

  @mixin text_fix {
    text-rendering: optimizeLegibility;
    font-smooth: always;
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
  }

  #container {
    @include init();
    @include cnt();
    background-color: #ffffff;
    color: #000000;
    font-family: Arial, sans-serif;
    font-weight: 400;
    overflow: hidden;
    visibility: hidden;
    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;

    .border {
      @include init();
      @include total();
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      border: 1px #666666 solid;
      z-index: 9999;
    }

    svg, img {
      display: block;
    }

    img {
      -webkit-filter: blur(0);
    }

    .abs {
      position: absolute;
    }
    .relative {
      position: relative;
    }

    .text {
      @include text_fix();
    }

    #video-container-1 {
      position: absolute;
      background-color: #000000;
      border: none;
      z-index: 99;
      overflow: hidden;
    }

    #video-controls-1 {
      position: absolute;
      z-index: 102;
    }

    #vplayer {
      width: 100%;
      position:absolute;
    }

    .video-controls {
      background: url(<?php echo $assets -> path('controls') ?>);
      border: none;
      position: absolute;
      width: 18px;
      height: 18px;
      bottom: 0;
      cursor: pointer;
      display: block;
      padding: 0;
    }

    #btnPlay {
      right : 36px + 4;
      background-position: 0 0;
    }

    #btnPause {
      right : 36px + 4;
      background-position: 0 -36px;
      visibility : hidden;
    }

    #btnStop {
      right : 18px + 2;
      background-position: 0 -18px;
    }

    #btnMute {
      right : 0;
      background-position: 0 -54px;
    }
    #btnUnmute {
      right : 0;
      background-position: 0 -72px;
    }
    #btnReplay{
      display: none;
    }
    #btnPlay:hover {
      background-position: 18.3px 0;
    }
    #btnPause:hover {
      background-position: 18.3px -36px;
    }

    #btnStop:hover {
      background-position: 18.3px -18px;
    }

    #btnMute:hover {
      background-position: 18.3px -54px;
    }
    #btnUnmute:hover {
      background-position: 18.3px -72px;
    }

  }

  #clickThroughBtn {
    @include init();
    @include total();
    display: block;
    border: 0 none;
    outline: 0 none;
    cursor: pointer;
    color: #000000;
    z-index: 101;
  }
 
<!-- GetValueProcess:endStyle -->
