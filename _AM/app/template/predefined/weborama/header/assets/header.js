/**
 * Smart Header
 * @author Weborama NL
 * @version 1.0.3
 * 2017-04-25
 */

// Alignment
var vertical = 'banner', horizontal = 'center', sticky = false;
// Dimensions
var adWidth, adHeight = 160;
// This object will hold the current website specifications (json).
var siteObject = {};
// Resize every # milli-secs max (#SharedBG)
var resizeTimeout = 25, resizeTimer = 0;

/** Current HTML is loaded */
screenad.onPreloadComplete = function(){
  setTimeout(onInit, 0);
};

/**
 * Setup Screenad Positioning. Shared function handler
 */
screenad.shared.setPosition = function(siteObj) {
  siteObject = siteObj;
  adWidth = parseInt( siteObject.width ) + 2; // +2 pixels avoids gap (for some retina monitors)
  horizontal = siteObject.halign;
  vertical = siteObject.valign;
  if (siteObject.skins_zindex !== undefined && siteObject.skins_zindex.length > 0) {
    screenad.setZIndex(parseInt(siteObject.skins_zindex));
  }
  if (vertical != 'banner') {
    // Insert "weborama_pushdown_div" (not in-page, no billoard ad-slot available)
    var insertScript;
    var insertLine;
    switch (vertical) {
      case 'top':
        insertLine = 'document.getElementsByTagName(\'body\')[0].insertBefore(' +
          'scr_tmpID, document.getElementsByTagName(\'body\')[0].childNodes[0]);';
        break;
      case 'content':
        insertLine = 'var _wrap = document.getElementById(\'' + siteObject.contentId + '\').parentNode;' +
          ' _wrap.insertBefore(scr_tmpID, document.getElementById(\'' + siteObject.contentId + '\'));';
        break;
      case 'header':
        insertLine = 'var _wrap = document.getElementById(\'' + siteObject.headerId + '\').parentNode;' +
        ' _wrap.insertBefore(scr_tmpID, document.getElementById(\'' + siteObject.headerId + '\'));';
        break;
      case 'wrapper':
        insertLine = 'var _wrap = document.getElementById(\'' + siteObject.wrapperId + '\').parentNode;' +
        ' _wrap.insertBefore(scr_tmpID, document.getElementById(\'' + siteObject.wrapperId + '\'));';
        break;
      default:
        if (vertical.indexOf('#') != -1) {
          //Align to specified ID (if not using wrapper, header or content id)
          var cleanID = vertical.replace('#', '');
          insertLine = 'var _wrap = document.getElementById(\'' + cleanID + '\').parentNode;' +
            ' _wrap.insertBefore(scr_tmpID, document.getElementById(\'' + cleanID + '\'));';
        } else {
          //On top of website as fallback plan
          insertLine = 'document.getElementsByTagName(\'body\')[0].insertBefore(' +
            'scr_tmpID, document.getElementsByTagName(\'body\')[0].childNodes[0]);';
        }
        break;
    }
    // Correct possible entities
    if (siteObject.extrajs !== '' && siteObject.extrajs !== undefined) {
      if (siteObject.extrajs.indexOf('&lt;') != -1) {
        siteObject.extrajs = siteObject.extrajs.replace(/&lt;/g, '<');
        siteObject.extrajs = siteObject.extrajs.replace(/&gt;/g, '>');
      }
      insertLine += 'try{ ' + siteObject.extrajs + ' }catch(e){}';
    }
    //Insert 'weborama_pushdown_div' script
    insertScript = 'var divID = \'weborama_pushdown_div\';' +
      'scr_tmpID = document.createElement(\'div\');' +
      'scr_tmpID.style.margin       = \'4px\';' +
      'scr_tmpID.style.padding      = \'0px\';' +
      'scr_tmpID.style.clear        = \'both\';' +
      'scr_tmpID.id                 = divID ;' +
      insertLine;
    screenad.executeScript(insertScript);
    //We use horizontal align (an ID) to insert 'weborama_pushdown_div', horizontal align: "#weborama_pushdown_div"
    vertical = '#weborama_pushdown_div';

  } else {
    // Correct possible entities
    if (siteObject.extrajs !== '' && siteObject.extrajs !== undefined) {
      if (siteObject.extrajs.indexOf('&lt;') != -1) {
        siteObject.extrajs = siteObject.extrajs.replace(/&lt;/g, '<');
        siteObject.extrajs = siteObject.extrajs.replace(/&gt;/g, '>');
      }
      // Note: Template specific variations apply.
      // You may want to run this "executeScript" line later on in another context.
      screenad.executeScript(siteObject.extrajs);
    }
  }
  // Possible Banner Pushing
  setPushdownHeight();
  // Timeout to run extrajs code on the parent site.
  setTimeout(alignAd, 100);
}

/** ----------- Resize Banner Po ----------- 
 *  Set the height of banner or the pushdown div.
 *  If cookies are enabled and the tergetHeight equals the collapsedHeight
 *  (the ad should open in collapsed view),
 *  We won't resize the banner or pushdown div larger then necessary
 */
function setPushdownHeight() {
  if (vertical != 'banner') {
    screenad.executeScript('document.getElementById(\'weborama_pushdown_div\').style.height = \'' + adHeight + 'px\'');
  } else {
    screenad.resize(screenad.bannerwidth, adHeight, 'banner');
  }
  screenad.position();
}

/** Align the ad depending on the sitespecs */
function alignAd() {
  screenad.setSticky(sticky);
  if (siteObject.zindex !== undefined && siteObject.zindex.length > 0) {
    screenad.setZIndex(siteObject.zindex);
  }
  screenad.setSize(adWidth, adHeight);
  screenad.resize(adWidth, adHeight);
  screenad.setAlignment(horizontal, vertical);
  screenad.setOffset(siteObject.offsetx, siteObject.offsety);
  screenad.position();
  screenad.show();
  onStart();
}

/** Show Shared Background - Header Version */
screenad.shared.setSharedBg = function(bgObj) {
  var xOffset=0, bgHolder=document.getElementById('sharedBackground');
 
  if (Number(siteObject.offsetx) != 0) {
	xOffset += Number(siteObject.offsetx);
  }
  
	if (!bgHolder) return;
  bgHolder.style.position = 'absolute';
  bgHolder.style.width = (screenad.browserwidth < adWidth? adWidth : screenad.browserwidth)+'px';
  bgHolder.style.height = '100%';
  bgHolder.style.left = '0px';
  bgHolder.style.top = '0px';
  if (bgHolder.style.backgroundImage == '')
		bgHolder.style.backgroundImage = 'url("'+bgObj.image+'")';
	if (bgObj.width != 'auto')
		xOffset = (screenad.browserwidth - bgObj.width)/2 + xOffset;
	bgHolder.style.backgroundSize = (bgObj.width == 'auto'? (screenad.browserwidth < adWidth? adWidth : screenad.browserwidth) : bgObj.width)+'px auto';
	bgHolder.style.backgroundPositionX = Number(0 + screenad.pagex + xOffset)+'px';
  bgHolder.style.backgroundPositionY = (bgObj.yOffset < 0 && Number(0 + screenad.pagey - bgObj.yOffset) > 0)? '0px' : Number(0 + screenad.pagey - bgObj.yOffset)+'px';
	bgHolder.style.backgroundRepeat = 'no-repeat';
	bgHolder.style.backgroundColor = bgObj.color;
}
