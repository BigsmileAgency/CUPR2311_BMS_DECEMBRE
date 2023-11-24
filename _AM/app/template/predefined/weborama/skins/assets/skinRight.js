/**
 * Smart Right Skin
 * @author Weborama NL
 * @version 1.0.5
 * 2020-09-16
 */

// Width of visible area, max en original width, sticky scrolling vars
var visibleWidth, originalWidth, maxWidth, stickyScrolling, scroll_timeout;
// This object will hold the current website specifications (json).
var siteObject = {};
// Content holder.
var scalableContent;
// Resize every # milli-secs max (#SharedBG)
var resizeTimeout = 25, resizeTimer = 0;
// So onStart is only called once
var startUp = true
// The width of the available content.
var contentWidth;

// The total combined top and height of the scalableContent.
var scalableCombinedHeight;

// Listener to update the position of the skins.
screenad.shared.updateStickySkinsPosition = updatePosition;

/** Current HTML is loaded */
screenad.onPreloadComplete = function() {
  if (screenad.deviceType != screenad.DEVICE_DESKTOP) {
    screenad.hide();
  }
  if (document.getElementById('scalableContent') != undefined) {
    scalableContent = document.getElementById('scalableContent');
    originalWidth = maxWidth = scalableContent.getBoundingClientRect().width;
  }
  onInit();
};

/**
 * Setup Screenad Positioning. Check if Scalable Content and Shared BG are used.
 * Shared function handler
 */
screenad.shared.setPosition = function(siteObj) {
  siteObject = siteObj;
  // Main screenad settings
  screenad.setSize(640, 1500);
  screenad.setAlignment('center', siteObject.skins_valign);
  screenad.setOffset((Math.floor(parseInt(siteObject.width) / 2) + 320) + parseInt(siteObject.skins_offsetx), parseInt(siteObject.skins_offsety));
  if (siteObject.skins_sticky == 'scroll') {
    screenad.setSticky(false); // First false to capture original vertical position
  } else {
    screenad.setSticky(siteObject.skins_sticky);
  }
  if (siteObject.skins_zindex !== undefined && siteObject.skins_zindex.length > 0) {
    screenad.setZIndex(parseInt(siteObject.skins_zindex));
  }
  screenad.position();
  // Scalable content?
  if (scaleContent && scalableContent != undefined) {
    screenad.onResize = updateScalableContent;
    updateScalableContent();
  }
  screenad.addEventListener(screenad.RESIZE, updateContent);
  updateContent();
  // Scrolling content?
  if (scrollContent) {
    setTimeout(function() {
      screenad.addEventListener(screenad.SCROLL, updateScalableScrollContent);
      updateScalableScrollContent();
    }, 150);
  }
  // Add sticky on scroll?
  if (siteObject.skins_sticky == 'scroll') {
    setTimeout(addStickyOnScroll, 100);
  }
  // Let content/animation start
  if (startUp) {
    setTimeout(onStart, 200);
    startUp = false;
  }
};

/** Checks resolution and adapts scalable content */
function updateScalableContent() {
  var contentHeight;
  if (scaleContent && scalableContent != undefined) {
    contentWidth = (Math.ceil(screenad.browserwidth * screenad.zoom) - parseInt(siteObject.width)) / 2 + parseInt(siteObject.skins_offsetx);
    scaleAmount = contentWidth / originalWidth;
    if (contentWidth >= maxWidth) {
      scaleAmount = 1;
    } else if (contentWidth < minWidth) {
      scaleAmount = minWidth / originalWidth;
    }
    scalableContent.style.transform = 'scale(' + scaleAmount + ',' + scaleAmount + ')';
  }
}

/** Checks the resolution and adapts the content */
function updateContent() {
  contentWidth = (Math.ceil(screenad.browserwidth * screenad.zoom) - parseInt(siteObject.width)) / 2 + parseInt(siteObject.skins_offsetx);
  document.getElementById('content').style.width = contentWidth + 'px';
}

/** Makes sure the scalableContent can scroll down with the page. */
function updateScalableScrollContent() {
  if (scalableCombinedHeight == undefined) {
    scalableCombinedHeight = (scalableContent.getBoundingClientRect().height + scalableContent.getBoundingClientRect().top);
    scalableContent.style.transition = 'margin-top .1s ease-out';
  }
  var totalHeight = document.body.getBoundingClientRect().height;
  /*var totalVisibleHeight = (screenad.browserheight < totalHeight) ? screenad.browserheight : totalHeight;
  var scalableCHeight = scalableContent.getBoundingClientRect().height;*/
  // This calculates how far over the skin we've scrolled.
  var layerScrolled = ((totalHeight - screenad.pagey) >= totalHeight) ? (totalHeight - totalHeight) : (totalHeight - (totalHeight - screenad.pagey));
  // This calculates how much of the skin is still visible.
  /*var layerVisible = ((totalHeight - layerScrolled) > totalVisibleHeight)
  ? ((totalVisibleHeight + screenad.pagey) <= 0) ? 0 : ((totalVisibleHeight + screenad.pagey) > totalVisibleHeight) ? totalVisibleHeight : (totalVisibleHeight + screenad.pagey)
  : ((totalHeight - layerScrolled) <= 0) ? 0 : (totalHeight - layerScrolled);
  */
  /*if (layerVisible >= scalableCombinedHeight || layerScrolled == 0) {
    // There is enough room to push the scalableContent down.
    scalableContent.style.marginTop = layerScrolled + 'px';
  } else {
    // There is not enough room to push the scalableContent down.
    scalableContent.style.marginTop = (totalHeight - scalableCombinedHeight) + 'px';
  }*/

  if ((layerScrolled + scalableCombinedHeight + Number(siteObject.scrollednavheight)) >= totalHeight) {
    scalableContent.style.marginTop = (totalHeight - scalableCombinedHeight) + 'px';
  } else {
    if (layerScrolled > 0) {
      scalableContent.style.marginTop = (layerScrolled + Number(siteObject.scrollednavheight)) + 'px';
    } else {
      scalableContent.style.marginTop = layerScrolled + 'px';
    }
  }
}
/** Show Shared Background - Skins Version */
screenad.shared.setSharedBg = function(bgObj) {
  var xOffset=0, bgHolder=document.getElementById('sharedBackground');
  
  if (Number(siteObject.skins_offsetx) != 0) {
	xOffset += Number(siteObject.skins_offsetx);
  }
  if (!bgHolder) return;
  bgHolder.style.position = 'absolute';
  bgHolder.style.width = screenad.browserwidth+'px';
  bgHolder.style.height = '100%';
  bgHolder.style.left = '0px';
  bgHolder.style.top = '0px';
  if (bgHolder.style.backgroundImage == '')
    bgHolder.style.backgroundImage = 'url("'+bgObj.image+'")';
  if (bgObj.width != 'auto')
    xOffset = (screenad.browserwidth - bgObj.width)/2 + xOffset;
  bgHolder.style.backgroundSize = (bgObj.width=='auto'? screenad.browserwidth : bgObj.width)+'px auto';
  bgHolder.style.backgroundPositionX = Number(0 + screenad.pagex + xOffset)+'px';
  bgHolder.style.backgroundPositionY =  (Number(0 + screenad.pagey - bgObj.yOffset) > 0)? '0px' : Number(0 + screenad.pagey - bgObj.yOffset)+'px';
  bgHolder.style.backgroundRepeat = 'no-repeat';
  bgHolder.style.backgroundColor = bgObj.color;
}

function addStickyOnScroll() {
  // If not needed. Use regular Sticky
  if (siteObject.skins_valign == 'top' && siteObject.skins_offsety == '0') {
    screenad.setSticky(true);
    screenad.position();
    return;	
  }
}

// Update Skin Position
function updatePosition(e) {
  e.offsetX = e.offsetX || (Math.floor(parseInt(siteObject.width) / 2) + 320) + parseInt(siteObject.skins_offsetx);
  screenad.setAlignment(e.horizontal, e.vertical);
  screenad.setOffset(e.offsetX, e.offsetY);
  screenad.setSticky(e.sticky);
  screenad.position();
}