<!-- GetValueProcess:beginCustomStyle -->

$total-w: <?php echo $width ?>px;
$total-h: <?php echo $height ?>px;


@mixin position($l:0, $t:0) {
	left: $l;
	top: $t;
}

@mixin init($l:0, $t:0) {
	position: absolute;
	@include position($l, $t);
}

@mixin size($w:100%, $h:100%) {
	width: $w;
	height: $h;
}

@mixin text_fix {
  text-rendering: optimizeLegibility;
  font-smooth: always;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
}

#container {
  #video-container-1 {
    left: 1px;
    top: 1px;
    width: $total-w - 2;
    height: $total-h - 2;
  }

  #video-controls-1 {
    left: -1px;
    bottom: 1px;
    width: 100%;
  }
}

<!-- GetValueProcess:endCustomStyle -->


