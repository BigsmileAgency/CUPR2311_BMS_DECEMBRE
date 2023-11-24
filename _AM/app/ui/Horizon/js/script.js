$(document).ready(function() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const preview = urlParams.has('preview')

  if (!preview) {
    localStorageGrid();
    showList();
    iframeSetup();
    clickToGrid();
    clickToLine();
    clearGrid();
    // menuOpen();
  }
});

// Playback variables
var overlay_hidden = false;
var overlay_pressed = false;
var timeline = new TimelineMax({id:campaing_name});
var tl1 = new TimelineMax();
var tl2 = new TimelineMax();

function iframeSetup() {

  var e = new AnimationContainer();

  e.load();
  e.on('onLoaded' , function() {
    e.center();

    // Open all button
    $("#open_all").click(function() {
      $(".file_link").each(function(){
        var url = $(this).attr("href");
        window.open(url);
      });
    });

    // Backup image mode
    $("#bkupimg").click(function() {
      $(".file_link").each(function(){
        var url = $(this).attr("href") + "&mod=bkupimg";
        window.open(url);
      });
    });

    if(window.location.href.indexOf("bkupimg") > -1) {

      $("body").addClass("bkupimg");
      $(".ui").css({"display":"none"});

      window.setInterval(function() {
        var iframe = document.getElementById("iframe").contentWindow;
        var iframeCloned = document.getElementById("iframe_clone").contentWindow;
        if(!(typeof iframe.main_timeline == 'undefined' || typeof iframeCloned.main_timeline == 'undefined')) {
          iframe.main_timeline.progress(1, false);
          iframeCloned.main_timeline.progress(1, false);
        }
      }, 100);

    }

    // Show All mode
    $("#previewBtn").click(function() {
      const location = window.location.search
      let param = null

      if (location.indexOf('format') == 1 || location.indexOf('language') == 1) {
        param = '&'
      }else{
        param = '?'
      }

      var url = window.location + param +"preview";
      window.open(url);
    });

    // Control settings
    // Mouse events
    $('#clonedlayer').mousedown( function(event) { event.preventDefault();
      event.stopPropagation(); overlay_down();   });

    window.addEventListener('mouseup', function(event) {
      event.preventDefault();
      event.stopPropagation();
      if(overlay_pressed)   { deactivate(2); overlay_up();  }
    });

    // Keyboard events

    if(typeof readAmOverlayerShow() == 'null' || readAmOverlayerShow() == 0) {

      hide_overlay();
      $("#clonedlayer").addClass("hidden");
      overlay_hidden = true;

    }
    else {
        show_overlay();
        $("#clonedlayer").removeClass("hidden");
        overlay_hidden = false;
    }
  });
}


// Playback functions
function overlay_down() {
  if (overlay_pressed == false) {
    overlay_pressed = true;
    if (overlay_hidden == false) {
      hide_overlay();
      disableAmOverlayerShow();
      $("#clonedlayer").addClass("hidden");
      overlay_hidden = true;
    }
    else {
      show_overlay();
      enableAmOverlayerShow();
      $("#clonedlayer").removeClass("hidden");
      overlay_hidden = false;
    }
  }
}

function overlay_up() {
  overlay_pressed = false;
}

// Display functions
function show_overlay() {
  $("#iframe_clone").show();
}

function hide_overlay() {
$("#iframe_clone").hide();
}

function activate(num) {
  $("#num"+num).addClass("active");
}

function deactivate(num) {
  $("#num"+num).removeClass("active");
}

var AnimationContainer = function() {
  this.iframe = $('#iframe');
  this.iframeCloned = $('#iframe_clone');
  this.content = null;
  this.contentCloned = null;
  this.loaded = false;
  this.loadedCloned = false;
}

AnimationContainer.prototype.on = function(event, callback) {
  $(this).on(event, callback);
}

AnimationContainer.prototype.load = function() {
  var self = this;
  var iframe = document.getElementById("iframe");
  var iframeCloned = document.getElementById("iframe_clone");
  var innerFrame = iframe.contentWindow;
  var innerFrameCloned = iframeCloned.contentWindow;

  this.iframe.load(function() {
    self.content = $('#iframe').contents();
    self.loaded = true;

    if(!(window.location.href.indexOf("bkupimg") > -1)) {
      if (['dcrm', 'dcrm-dynamic'].includes(type)) {
        var i = setInterval(function() {
          if (innerFrame.Enabler.isVisible()) {

            clearInterval(i);

            var tl = innerFrame.main_timeline;
            tl.pause(0);
            tl1.to(tl, tl.totalDuration(), {totalProgress:1, ease:Linear.easeNone});
          }
        }, 20);

      }else{
        var i = setInterval(function() {

          clearInterval(i);

          var tl = innerFrame.main_timeline;
          tl.pause(0);
          tl1.to(tl, tl.totalDuration(), {totalProgress:1, ease:Linear.easeNone});
        }, 20);
      }
    }
  });

  this.iframeCloned.load(function() {
    self.contentCloned = $('#iframe_clone').contents();
    self.loadedCloned = true;

    if(!(window.location.href.indexOf("bkupimg") > -1)) {
      if (['dcrm', 'dcrm-dynamic'].includes(type)) {
        var i = setInterval(function() {
          if (innerFrameCloned.Enabler.isVisible()) {

            clearInterval(i);

            var tl = innerFrameCloned.main_timeline;
            tl.pause(0);
            tl2.to(tl, tl.totalDuration(), {totalProgress:1, ease:Linear.easeNone});
          }
        }, 20);

      }else{
        var i = setInterval(function() {

          clearInterval(i);

          var tl = innerFrameCloned.main_timeline;
          tl.pause(0);
          tl2.to(tl, tl.totalDuration(), {totalProgress:1, ease:Linear.easeNone});
        }, 20);
      }
    }
  });

  var i = setInterval(function() {
    if(self.loaded && self.loadedCloned) {
      $(self).trigger("onLoaded");
      clearInterval(i);

      if(!(window.location.href.indexOf("bkupimg") > -1)) {
        timeline.add(tl1);
        timeline.add(tl2, 0);
        GSDevTools.create({animation:timeline, globalSync:false});
      }
    }
  }, 20);
}

AnimationContainer.prototype.center = function() {

  var iframeContent = this.content;
  var iframeClonedContent = this.contentCloned;

  var iframeContentHtml = iframeContent.find('html');
  var iframeContentBody = iframeContent.find('body');

  var iframeClonedContentHtml = iframeClonedContent.find('html');
  var iframeClonedContentBody = iframeClonedContent.find('body');

  var iframeContentContainer = iframeContentBody.find("#container");
  var iframeClonedContentContainer = iframeClonedContentBody.find("#container");

  if (type == "weborama-interscroller") {
    var iframeContentHolder = iframeContent.find('.content-holder');
    iframeContentHolder.css({display: 'block'});
  }

  iframeContentHtml.css({height: '100%'});
  iframeContentBody.css({height: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center'});

  iframeClonedContentHtml.css({height: '100%'});
  iframeClonedContentBody.css({height: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center'});

  iframeClonedContentContainer.css({overflow: 'visible', position: 'relative'});
}

function enableAmOverlayerShow(days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = "AmOverlayerShow=1"+expires+"; path=/";
}

function disableAmOverlayerShow(days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = "AmOverlayerShow=0"+expires+"; path=/";
}


function readAmOverlayerShow() {
  var nameEQ = "AmOverlayerShow=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function eraseAmOverlayerShow() {
  disableAmOverlayerShow(-1);
}

function showList() {
  let parent = document.querySelectorAll('[data-collapsible]');
  parent = [].slice.call(parent);

  parent.forEach(function(element) {
    let collapsible_element = element.nextElementSibling;
    let collapsible_element_children = collapsible_element.children;
    let tl = new TimelineMax({
      reversed: true,
      paused: true
    });

    tl.from(collapsible_element, .5, { className: "+=heightZero" }, 'open');
    tl.staggerFrom(collapsible_element_children, .5, {autoAlpha: 0, x: '-30%', ease: Back.easeOut}, .025, 'open+=.1');

    element.addEventListener('click', function () {

      // if (element.id == "toggle_list") {
      //   isOpen = tl.reversed() ? true : false;
      //   localStorage.setItem("isOpen", isOpen);
      // }

      tl.reversed() ? tl.play() : tl.reverse();
    })

  })
}

var gInnerVer;
var gInnerHor;

function clickToGrid() {
  const grid = $('#grid');

  grid.on('click', function(el) {

    localStorage.setItem('grid', true);

    if ($("#gridContainer").length == 0) {
      createGrid();
      clearGrid();
    }

  });

}

function createGrid() {
  g = document.createElement('div');
  g.setAttribute("id", "gridContainer");

  gInner = document.createElement('div');
  gInner.setAttribute("id", "gridSize");
  gInner.style.width = width + "px";
  gInner.style.height = height + "px";

  gInnerVer = document.createElement('div');
  gInnerVer.setAttribute("id", "gridVerti");

  gInnerHor = document.createElement('div');
  gInnerHor.setAttribute("id", "gridHori");

  gClose = document.createElement('div');
  gClose.setAttribute("id", "gClose");

  document.getElementById('iframe_container').appendChild(g).appendChild(gInner);
  document.getElementById('gridSize').appendChild(gClose);
  document.getElementById('gridSize').appendChild(gInnerVer);
  document.getElementById('gridSize').appendChild(gInnerHor);
}


vLine = localStorage.getItem('grid') ? localStorage.getItem('vLine') : 0;
hLine = localStorage.getItem('grid') ? localStorage.getItem('hLine') : 0;

function clickToLine() {
  const line = $('.line');

  line.on('click', function(el) {

    if ($(this).data("line") === "verti" ) {

      vLine++;
      localStorage.setItem('vLine', vLine);
      makeLine(gInnerVer, 1);
    }else{

      hLine++;
      localStorage.setItem('hLine', hLine);
      makeLine(gInnerHor, 1);
    }

  });

}

function localStorageGrid() {
  let grid = localStorage.getItem('grid');
  let vLine = localStorage.getItem('vLine');
  let hLine = localStorage.getItem('hLine');

  if (grid == 'true') {
    createGrid();
    makeLine(gInnerVer, vLine);
    makeLine(gInnerHor, hLine);
  }
}

function clearGrid() {

  const grid = $('#gridContainer');
  const close = $('#gClose');

  close.on('click', function() {
    vLine = 0;
    hLine = 0;
    grid.remove();

    let keysToRemove = ["grid", "hLine", "vLine"];

    keysToRemove.forEach(function(key) {
    // for (key of keysToRemove) {
      localStorage.removeItem(key);
    })

    // el = document.getElementById('grid');
    // let collapsible_element = el.nextElementSibling;
    // let collapsible_element_children = collapsible_element.children;

    // let tl = new TimelineMax();

    // tl.staggerTo(collapsible_element_children, .5, {autoAlpha: 0, x: '-30%', ease: Back.easeOut}, .025);
    // tl.to(collapsible_element, .5, { className: "+=heightZero" });

  });
}

function makeLine(el, line) {
  for (c = 0; c < line; c++) {
    let cell = document.createElement("div");
    el.appendChild(cell).className = "grid-item";
  };
};
