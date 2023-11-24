
// Can be called before INIT event.
Enabler.setExpandingPixelOffsets(
  0, // left offset of expanded ad
  0, // top offset of expanded ad
  300, // expanded width of ad
  400); // expanded height of ad
Enabler.setStartExpanded(false);
  // whether to start in expanded state (defaults to false)
Enabler.setIsMultiDirectional(false);
  // multidirectional ads expand in the "best available" direction
  // (default false)
// Listen for INIT/VISIBLE of Enabler here.


var isExpanded = false;
function expandStartHandler() {
  // Perform expand animation.
  // Optionally, should you want the direction to expand in call:
  // Enabler.getExpandDirection(); //
  TweenMax.to("#container", 0.2, {height:400});
  // When animation finished must call
  Enabler.finishExpand();
}

function expandFinishHandler() {
  // Convenience callback for setting
  // final state when expanded.
  isExpanded = true;
}

function collapseStartHandler() {
  // Perform collapse animation.
  TweenMax.to("#container", 0.2, {height:250});
  // When animation finished must call
  Enabler.finishCollapse();
}

function collapseFinishHandler() {
  // Convenience callback for setting
  // final state when collapsed.
  isExpanded = false;
}

function actionClickHandler() {
  isExpanded ? Enabler.requestCollapse() : Enabler.requestExpand();
}

Enabler.addEventListener( studio.events.StudioEvent.EXPAND_START, expandStartHandler);
Enabler.addEventListener( studio.events.StudioEvent.EXPAND_FINISH, expandFinishHandler);
Enabler.addEventListener( studio.events.StudioEvent.COLLAPSE_START, collapseStartHandler);
Enabler.addEventListener( studio.events.StudioEvent.COLLAPSE_FINISH, collapseFinishHandler);


  // ***** EXPANDABLE ENDS ***** //