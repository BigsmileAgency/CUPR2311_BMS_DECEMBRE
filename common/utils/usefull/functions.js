// Simple way to split use below then data/timeline like usual (Must be launch before init();)
function splitMyText() {
  new SplitText('.txt', {type: "lines", linesClass:"lineChild"});
  new SplitText('.txt', {type: "lines", linesClass:"lineParent"});
}

// Follow path Bezier Sample (check data.php)
var path = []; // In vars
for (let i = 0; i <= 1; i++) { // Must be launch before init();
  TweenMax.set("#dot"+i, {xPercent:-50, yPercent:-50}); // Set #el center
  path.push(MorphSVGPlugin.pathDataToBezier('#line'+i, {align:'#dot'+i})); // Set #el on the line to follow
}

// Then on common.js.php add the function like this : main_timeline.add(afterDemo, 0).call(allowMouseEvent); 0 is the second when start
function afterDemo(){
  var rule = CSSRulePlugin.getRule("#container .test:after"); // Must be the same as css target
  TweenMax.to(rule, 2, {
    cssRule: {
      backgroundColor: "#F43C09"
    },
    yoyo: true,
    repeat: -1,
    force3D: true
  });
}

// Then on common.js.php add the function like this : main_timeline.add(DemoLoopAddToMainTl, 0).call(allowMouseEvent); 0 is the second when start
function DemoLoopAddToMainTl() {
  
  var tl = new TimelineMax({
    repeat: 5
  });

  tl.to("#bg_road", 2, {
    backgroundPosition: "-1800px bottom",
    force3D:true,
    rotation:0.01,
    z:0.01,
    ease: Linear.easeNone
  });

  return tl;
}

// Parallax Demo
// IN function onMouseEnterHandler(e){
parallaxMouseMove(e, "#smiley_container", -30);
parallaxMouseMove(e, "#tfinal", 10);
function parallaxMouseMove(e, target, movement) {
  var $this = document.getElementById("container");
  var relX = e.pageX - $this.offsetLeft;
  var relY = e.pageY - $this.offsetTop;

  TweenMax.to(target, 2, {
    x: (relX - $this.offsetWidth / 2) / $this.offsetWidth * movement,
    y: (relY - $this.offsetHeight / 2) / $this.offsetHeight * movement, ease: Expo.easeOut
  });
}

// IN function onMouseLeaveHandler(e){
// parallaxMouseOut();
function parallaxMouseOut() {
  smiley_cont = document.getElementById("smiley_container");
  tfinal = document.getElementById("tfinal");

  TweenMax.to([smiley_cont,tfinal], 3, {x:0, y:0, ease: Expo.easeOut});
}