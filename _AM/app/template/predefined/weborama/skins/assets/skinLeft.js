/**
 * Smart Left Skin
 * @author Weborama NL
 * @version 1.0.5
 * 2020-09-16
 */

// Width of visible area, max en original width, smart/ron, sticky scrolling vars, vertical align overrule
var visibleWidth, originalWidth, maxWidth, smart = true, stickyScrollLimit, stickyScrolling, scroll_timeout;
// This object will hold the current website specifications (json).
var siteObject = {};
// This object will hold the shared background properties.
var bgObject = {};
// Is the sync done.
var syncDone = false;
// Is the JSON loaded.
var jsonDone = false;
// Content holder.
var scalableContent;
// Checking the resolution interval variable.
var resolutionInterval;
// Resize every # milli-secs max (#SharedBG)
var resizeTimeout = 25, resizeTimer = 0;
// Default site-specs, used in case server is unavailable
var defaultJson = {'site':{'modified_date':'2016-05-10 11:10:00','website':'.','width':'1200','wrapperid':'NA','headerid':'NA','contentid':'NA','category':'Default','extrajs':'','halign':'center','valign':'banner','zindex':'','offsetx':'0','offsety':'0','closebutton':'1','skins_valign':'top','skins_zindex':'','skins_stickyskyscraperid':'','skins_offsetx':'0','skins_offsety':'0','skins_sticky':'false','vpaid':'','vpaid_expand':'','vpaid_playerid':'','vpaid_playerwidth':'640','vpaid_playerheight':'360','vpaid_playeroffsetx':'0','vpaid_playeroffsety':'0','inread_method':'','inread_target':'','inread_number':'0','inread_width':'550','inread_height':'390','inread_insertafter':'0','interscroller_zindex':'','interscroller_extrajs':'','framead_extrajs':'','topad_valign':'top','topad_offset_y':'0','topad_zindex':'','topad_extrajs':''}};
// Stick to the view port or scrollable? Using this property is only allowed if authorized by Publisher!
// Important! Leave empty in order to enable sitespecs (RON) determine sticky proerty.
var forceSticky; // false, true, 'scroll'
// Has the sticky been stopped because of the content in the site?
var contentScrollCancelled = false;
// So onStart is only called once
var startUp = true;
// The width of the available content.
var contentWidth, scaleAmount;

// The total combined top and height of the scalableContent.
var scalableCombinedHeight;

// Listener to update the position of the skins.
screenad.shared.updateStickySkinsPosition = updatePosition;


/** Current HTML is loaded */
screenad.onPreloadComplete = function() {
  if (screenad.deviceType != screenad.DEVICE_DESKTOP) {
    screenad.hide();
  }
  // Shared background? Preload background image to browser cached
  if (BG_image != false) {
    new Image().src = BG_image;
  }
  // Possible tag vars overwritting
  if (screenad.vars.scrsticky == 'true' || screenad.vars.scrsticky == '1') {
    forceSticky = true;
  } else if (screenad.vars.scrsticky == 'false' || screenad.vars.scrsticky == '0') {
    forceSticky = false;
  } else if (screenad.vars.scrsticky == 'scroll') {
    forceSticky = screenad.vars.scrsticky;
  }
  if (document.getElementById('scalableContent') != undefined) {
    scalableContent = document.getElementById('scalableContent');
    originalWidth = maxWidth = scalableContent.getBoundingClientRect().width;
  }
  if (smart) {
    var getDomain = function () {
      var d = '';
      if (typeof window.location.ancestorOrigins != 'undefined' && window.location.ancestorOrigins.length > 0) {
        var iframeParents = null;
        iframeParents = window.location.ancestorOrigins;
        if (iframeParents && iframeParents.length > 0) {
          url = iframeParents[iframeParents.length - 1];
        }
      } else if (window.location != window.parent.location && document.referrer) {
        url = document.referrer;
      } else {
        url = document.location.href;
      }
      try {
        if (!url || url.indexOf('http') !== 0) {
          url = '#';
        }
        var el = document.createElement('a');
        el.href = url;
        d = url/*el.hostname*/;
      } catch (e) {}
      return d;
    };


    var getDomainStr = "(" + getDomain.toString() + ")()";
	if (screenad.vars.page != undefined && (Boolean(screenad.vars.previewer2) == true)) {
		getSiteSpecs(screenad.vars.page);
	} else {
		screenad.executeScript(getDomainStr, getSiteSpecs);
	}
  } else {
    onSucces(defaultJson);
  }
  onInit();
};

/** Receives current location and loads site-specs data */
function getSiteSpecs(location) {
  var xobj = new XMLHttpRequest();
  if (typeof xobj.overrideMimeType == 'function') {
    xobj.overrideMimeType('application/json');
  }
  xobj.open('GET', ('//cntr.adrcntr.com/sitespecs/?site='+location), true);
  xobj.onreadystatechange = function() {
    if (xobj.readyState == 4 && xobj.status == '200') {
      var json = (xobj.responseText === '0' || xobj.responseText === 0)? defaultJson : JSON.parse(xobj.responseText);
      onSucces(json);
    }
  };
  xobj.onerror = function(e) { onSucces(defaultJson); };
  xobj.send(null);
}

/** Parses site-specs data */
function onSucces(json) {
  for (var key in json.site) {
    siteObject[key] = json.site[key];
  }
  if (siteObject.extrajs !== '') {
    if (siteObject.extrajs.indexOf('&lt;') != -1) {
      siteObject.extrajs = siteObject.extrajs.replace(/&lt;/g, '<');
      siteObject.extrajs = siteObject.extrajs.replace(/&gt;/g, '>');
    }
    screenad.executeScript(siteObject.extrajs);
  }
  // Overwrite if forced value coming from settings or tag-var
  if (forceSticky != undefined) {
    siteObject.skins_sticky = forceSticky;
  } else if (siteObject.skins_sticky == 'true'){
    siteObject.skins_sticky = true;
  } else if  (siteObject.skins_sticky != 'scroll'){
    siteObject.skins_sticky = false;
  }
  // Add sticky skyscraper script?
  
  if (siteObject.skins_stickyskyscraperid !== undefined && siteObject.skins_stickyskyscraperid.length > 0 && !screenad.isPreviewer) {
    stickySkyscraper();
  }
  // Forced Vertical Align coming from tag vars?
  if (screenad.vars.scrvalign) {
    siteObject.skins_valign = screenad.vars.scrvalign;
  }
  jsonDone = true;
  if (syncDone === true) {
    setTimeout(function(){ resolutionInterval = setInterval(checkBrowserwidth, 100); }, 150);
  }
}

/** Sync handler. All HTMLs are loaded */
screenad.onSync = function() {
  syncDone = true;
  if (jsonDone === true) {
    setTimeout(function() {
      resolutionInterval = setInterval(checkBrowserwidth, 100);
    }, 150);
  }
};

/**
 * Checks viewport-width and calls setPosition for both skins and (optional) header.
 * Called once Sync and SiteSpecs (JSON) are done.
 */
function checkBrowserwidth() {
  if (screenad.browserwidth > 100) {
    clearInterval(resolutionInterval);
    if (siteObject.width.indexOf('.') == 0) {
      siteObject.responsiveWidth = siteObject.width;
      screenad.executeScript('document.querySelectorAll(\'' + siteObject.responsiveWidth +'\')[0].id=\'webo_id\'; document.getElementById(\'webo_id\').clientWidth;', setResponsiveWidth);
      screenad.addEventListener(screenad.RESIZE, responsiveResizeHandler);
    } else if (siteObject.width.indexOf('#') == 0) {
      siteObject.responsiveWidth = siteObject.width;
      screenad.executeScript('document.getElementById(\''+ siteObject.responsiveWidth.replace('#', '') +'\').clientWidth;', setResponsiveWidth);
      screenad.addEventListener(screenad.RESIZE, responsiveResizeHandler);
    } else {
      screenad.shared.callMethod('setPosition', siteObject);
    }
  }
}

function setResponsiveWidth(e) {
	if (siteObject.responsiveWidthId == undefined) {
		siteObject.responsiveWidthId = (siteObject.width.indexOf('.') == 0) ? 'webo_id' : siteObject.responsiveWidth;
	}
	siteObject.width = Number(e.replace('px', ''));
	screenad.shared.callMethod('setPosition', siteObject);
}

function responsiveResizeHandler() {
	screenad.executeScript('document.getElementById(\''+ siteObject.responsiveWidthId +'\').clientWidth;', setResponsiveWidth);
}

/**
 * Setup Screenad Positioning. Check if Scalable Content and Shared BG are used.
 * Shared function handler
 */
screenad.shared.setPosition = function(siteObj) {
  siteObject = siteObj;
  // Main screenad settings
  screenad.setSize(640, 1500);
  screenad.setAlignment('center', siteObject.skins_valign);
  screenad.setOffset(0 - (Math.ceil(parseInt(siteObject.width) / 2) + 320) + parseInt(siteObject.skins_offsetx), parseInt(siteObject.skins_offsety));
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
    screenad.addEventListener(screenad.RESIZE, updateScalableContent);
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
  // Shared background?
  if (BG_image != false) {
    setTimeout(addSharedBg, 150);
  }
  // Let content/animation start
  if (startUp) {
    setTimeout(onStart, 200);
    startUp = false;
  }
};

/** Checks resolution and adapts scalable content */
function updateScalableContent() {
  var leftOffset, rightOffset = 'auto';
  if (scaleContent && scalableContent != undefined) {
    contentWidth = (Math.ceil(screenad.browserwidth * screenad.zoom) - parseInt(siteObject.width)) / 2 + parseInt(siteObject.skins_offsetx);
    scaleAmount = contentWidth / originalWidth;
    leftOffset = (640 - (maxWidth * scaleAmount)) + 'px';
    if (contentWidth > maxWidth) {
      scaleAmount = 1;
      leftOffset = 'auto';
      rightOffset = '0px';
    } else if (contentWidth < minWidth) {
      scaleAmount = minWidth / originalWidth;
      leftOffset = (640 - (maxWidth * scaleAmount)) + 'px';
    }
    scalableContent.style.transform = 'scale(' + scaleAmount + ',' + scaleAmount + ')';
    scalableContent.style.right = rightOffset;
    scalableContent.style.left = leftOffset;	
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
  : ((totalHeight - layerScrolled) <= 0) ? 0 : (totalHeight - layerScrolled);*/
  
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

/** Adds Shared Background (Cross-Elements) #SharedBG */
function addSharedBg() {
  // Shared background properties
  bgObject.yOffset = screenad.pagey;
  bgObject.image = BG_image;
  bgObject.width = BG_width;
  bgObject.color = BG_color;
  bgObject.skins_sticky = siteObject.skins_sticky;
  // Update BG on Resize
  screenad.addEventListener( screenad.RESIZE, updateSharedBg);
  // Update BG on Resize if skins are sticky
  // if (siteObject.skins_sticky == true || siteObject.skins_sticky == 'scroll') {
  if (siteObject.skins_sticky != false) {
    screenad.addEventListener( screenad.SCROLL, updateSharedBg);
  }
  // Set shared BG for all elements once image has been preloaded
  screenad.shared.callMethod('setSharedBg', bgObject);
}

/** Update vertical offset */
function updateSharedBg() {
  bgObject.yOffset = screenad.pagey;
  screenad.shared.callMethod('setSharedBg', bgObject);
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
  bgHolder.style.backgroundPositionY = (Number(0 + screenad.pagey - bgObj.yOffset) > 0)? '0px' : Number(0 + screenad.pagey - bgObj.yOffset)+'px';
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
  stickyScrollLimit = 0 - screenad.pagey + screenad.scrolly;
  if (typeof stickyScrollLimit == 'number') {
    screenad.addEventListener( screenad.SCROLL, scrollHandler);
    scrollHandler();
  }
}

/** Handles scroll event. Sets stickyness on scroll if needed */
function scrollHandler() {
  // Set 100 milliseconds repetition just in case
  if (scroll_timeout != null) {
    scroll_timeout = setTimeout(function(){
      scroll_timeout = null;
      scrollHandler();
    }, 150);
  }
  
  if (screenad.pagey > 0 && !stickyScrolling && !contentScrollCancelled) {
    stickyScrolling = true;
    screenad.shared.callMethod('updateStickySkinsPosition', {'horizontal': 'center', 'vertical': 'top', 'offsetX': null, 'offsetY': (0 + parseInt(siteObject.skins_offsety_scroll)), 'sticky': true});
    if (BG_image != false) {
      setTimeout(updateSharedBg, 50);
    }

  } else if (screenad.scrolly <= stickyScrollLimit && stickyScrolling && !contentScrollCancelled) {
    stickyScrolling = false;
    screenad.shared.callMethod('updateStickySkinsPosition', {'horizontal': 'center', 'vertical': siteObject.skins_valign, 'offsetX': null, 'offsetY': parseInt(siteObject.skins_offsety), 'sticky': false});
    if (BG_image != false) {
      setTimeout(updateSharedBg, 50);
    }

  } else if (stickyScrolling && siteObject.skins_scrolllimit != '') {
    // If sticky-scrolling and bottom limited exists
    screenad.executeScript('document.querySelectorAll(\''+siteObject.skins_scrolllimit +'\')[0].getBoundingClientRect().top;', function(e) {
      siteObject.contentStartTop = Number(e);
      if (siteObject.contentStartTop <= screenad.originalHeight && !contentScrollCancelled) {
        contentScrollCancelled = true;
		screenad.shared.callMethod('updateStickySkinsPosition', {'horizontal': 'center', 'vertical': 'top', 'offsetX': null, 'offsetY': (siteObject.contentStartTop + screenad.scrolly - 1500), 'sticky': false});

      } if (siteObject.contentStartTop >= screenad.originalHeight && contentScrollCancelled) {
        contentScrollCancelled = false;
		screenad.shared.callMethod('updateStickySkinsPosition', {'horizontal': 'center', 'vertical': 'top', 'offsetX': null, 'offsetY': (0 + parseInt(siteObject.skins_offsety_scroll)), 'sticky': true});
      }
    });
  }
}

// Update Skin Positions
function updatePosition(e) {
  e.offsetX = e.offsetX || 0 - (Math.ceil(parseInt(siteObject.width) / 2) + 320) + parseInt(siteObject.skins_offsetx);
  screenad.setAlignment(e.horizontal, e.vertical);
  screenad.setOffset(e.offsetX, e.offsetY);
  screenad.setSticky(e.sticky);
  screenad.position();
}

/** Makes skyscraper sticky so that skins does not cover it */
function stickySkyscraper() {
  var ssFunction = 'function stickySkyscraper(element, marginTop) {' +
  '  var targetElement = element,' +
  '  extraMargin = marginTop || 0,' +
  '  elementOffset = jQuery(targetElement).offset(),' +
  '  elementMargin = jQuery(targetElement).css(\'margin-top\');' +
  '  if (extraMargin > 0) {' +
  '    if (elementOffset.top > 0) {' +
  '      extraMargin = extraMargin - (elementOffset.top - elementMargin.replace(\'px\', \'\'));' +
  '    }' +
  '    jQuery(targetElement).css({\'margin-top\': extraMargin + \'px\'});' +
  '  }' +
  '  jQuery(window).scroll(function() {' +
  ' if (marginTop > 0) {' +
  '      if (jQuery(this).scrollTop() >= marginTop) {' +
  '        jQuery(targetElement).css({\'margin-top\': \'0px\'});' +
  '        jQuery(targetElement).addClass(\'fixed\');' +
  '      } else {' +
  '        jQuery(targetElement).css({\'margin-top\': extraMargin + \'px\'});' +
  '        jQuery(targetElement).removeClass(\'fixed\');' +
  '      }' +
  '    } else {' +
  '      if (jQuery(this).scrollTop() >= elementOffset.top) {' +
  '        jQuery(targetElement).addClass(\'fixed\');' +
  '      } else {' +
  '        jQuery(targetElement).removeClass(\'fixed\');' +
  '      }' +
  '    }' +
  '  });' +
  '}';
  var insertScript = 'if (jQuery(\'' + siteObject.skins_stickyskyscraperid + '\') != undefined) {' +
  '  if (!stickySkyscraper) {' +
    ssFunction +
  '     stickySkyscraper(\'' + siteObject.skins_stickyskyscraperid + '\');' +
  '  }' +
  '}' +
  'var skins_offsety = ' + ((siteObject.skins_valign != 'top' && (parseInt(siteObject.skins_offsety) < 0)) ? String('jQuery(\'' + siteObject.skins_stickyskyscraperid + '\').offset().top') + String(siteObject.skins_offsety) : String(siteObject.skins_offsety)) + ';' +
  'stickySkyscraper(\'' + siteObject.skins_stickyskyscraperid + '\', 1520 + skins_offsety);' +
  'var stickySkyscraperInterval = setInterval(function() {' +
  '  checkSkyscraper();' +
  '}, 500);' +
  'function checkSkyscraper() {' +
  '  if (jQuery(\'' + siteObject.skins_stickyskyscraperid + '\').offset().top <= 1500) {' +
  '    stickySkyscraper(\'' + siteObject.skins_stickyskyscraperid + '\', 1520 + skins_offsety);' +
  '    clearInterval(stickySkyscraperInterval);' +
  '  }' +
  '}';
  screenad.executeScript('setTimeout(function(){' + insertScript + '}, 500);');
}