@mixin position($l:0, $t:0) {
	left: $l;
	top: $t;
}

@mixin position_r($r:0, $b :0) {
  right: $r;
  bottom: $b;
}

@mixin size($w:100%, $h:100%) {
	width: $w;
	height: $h;
}

@mixin bs() {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

@mixin text_fix {
  text-rendering: optimizeLegibility;
  font-smooth: always;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  backface-visibility: hidden;
}

@mixin init(){
  position: absolute;
  top: 0;
  left: 0;
}

@mixin total(){
  width: 100%;
  height: 100%;
}

@mixin cnt(){
  width: <?= $width ?>px;
  height: <?= $height ?>px;
}

@mixin center_w(){
  left: 50%;
  transform: translate(-50%, 0);
}