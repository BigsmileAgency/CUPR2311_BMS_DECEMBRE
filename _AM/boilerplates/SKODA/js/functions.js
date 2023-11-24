

function onMouseEnterHandler(e){
  if(mouse_allow) {
    TweenMax.to("#cta", 0.2, {backgroundColor: '#0E3A2F', color: '#78FAAE'});
  }
}

function onMouseLeaveHandler(e){
  if(mouse_allow) {
    TweenMax.to("#cta", 0.2, {backgroundColor: '#78FAAE', color: '#0E3A2F'});
  }
}

function allowMouseEvent(){
  mouse_allow = true;
}

function stopTimeline(){
  main_timeline.stop();
}
