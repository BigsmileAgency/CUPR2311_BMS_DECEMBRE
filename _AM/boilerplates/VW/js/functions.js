

function onMouseEnterHandler(e){
  if(mouse_allow) {
    TweenMax.to("#cta", 0.2, {backgroundColor: cta_hover_color, color: cta_hover_txt_color});
  }
}

function onMouseLeaveHandler(e){
  if(mouse_allow) {
    TweenMax.to("#cta", 0.2, {backgroundColor: cta_main_color, color: cta_main_txt_color});
  }
}

function allowMouseEvent(){
  mouse_allow = true;
}

function stopTimeline(){
  main_timeline.stop();
}
