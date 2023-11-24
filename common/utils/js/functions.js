function onMouseEnterHandler(e) {
  // Enabler.requestExpand(); // Only for DCRM-expandable
  if (mouse_allow) {
    TweenMax.to("#cta", 0, {opacity:"0", ease: Expo.out});
    TweenMax.to("#cta-2", 0, {opacity:"1", ease: Expo.out});
  }
}

function onMouseLeaveHandler(e) {
  // Enabler.requestCollapse(); // Only for DCRM-expandable
  if (mouse_allow) {
    TweenMax.to("#cta", 0, {opacity:"1", ease: Expo.out});
    TweenMax.to("#cta-2", 0, {opacity:"0", ease: Expo.out});
  }
}

function allowMouseEvent() {
  mouse_allow = true;
}

function stopTimeline() {
  main_timeline.stop();
}
