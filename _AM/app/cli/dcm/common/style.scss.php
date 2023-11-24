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

  }

  #clickThroughBtn {
    @include init();
    @include total();
    display: block;
    border: 0 none;
    outline: 0 none;
    cursor: pointer;
    color: #000000;
  }
 
<!-- GetValueProcess:endStyle -->
