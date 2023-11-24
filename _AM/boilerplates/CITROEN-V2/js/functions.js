function onMouseEnterHandler(e){
  if(mouse_allow) {
    // TweenMax.to("#cta", 0.2, {backgroundColor: cta_hover_color, color: cta_hover_txt_color});
  }
}

function onMouseLeaveHandler(e){
  if(mouse_allow) {
    // TweenMax.to("#cta", 0.2, {backgroundColor: cta_main_color, color: cta_main_txt_color});
  }
}

//*Anim open conso
function onMouseConso(e){
  const legal = document.getElementById('legalnotions');
  const legalHeight = legal.offsetHeight;
  const legalHeightScroll = legal.scrollHeight ;
  const mentionHeight = legalHeight;
  const banner_height = document.getElementById('container').offsetHeight;

  if(mouse_allow) {

    if(legalHeightScroll > banner_height) {
      TweenMax.to("#legalnotions", 0, {overflowY: 'scroll'});

      TweenMax.to("#conso", 0, {height: banner_height});
      TweenMax.to("#legalnotions", 0, {height: banner_height - 20});
    }
    else {
      TweenMax.to("#conso", 0, {height: mentionHeight + 20});
    }
  }
}

function onMouseLeaveConso(e){
  if(mouse_allow) {
    const mention = document.getElementById('mention');
    const mentionHeight = mention.offsetHeight;

    TweenMax.to("#conso", 0, {height: mentionHeight});
  }
}

// Prevent DOM el creation
setTimeout(() => {
  document.getElementById('conso').addEventListener('mouseenter', onMouseConso, false);
  document.getElementById('conso').addEventListener('mouseleave', onMouseLeaveConso, false);
}, 1000);

function allowMouseEvent(){
  mouse_allow = true;
}

function stopTimeline(){
  main_timeline.stop();
}
