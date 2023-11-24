$(document).ready(function() {

  

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


  // Control settings

  var speed_increase = 3; // Speed factor for rewind/forward
  var jump_duration = 0.1;  // In seconds

  // Keys array

  var keys = {0 : 96, 1 : 97, 2 : 98, 3 : 99, 4 : 100, 5  : 101, 6  : 102, 7  : 103, 8  : 104, 9  : 105, "space" : 32};

  // Mouse events

  $(".numkey").each(function() {
    var id = $(this).attr("id");
    var num = parseInt(id.substring(3));
    $(this).mousedown(function(event) { event.preventDefault();
    event.stopPropagation(); activate(num);});
  });

  $('#num5').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); pause_down();    });
  $('#num4').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); rewind_down();   });
  $('#num6').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); forward_down();  });
  $('#num7').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); start_down();    });
  $('#num9').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); end_down();      });
  $('#num1').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); previous_down(); });
  $('#num3').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); next_down();     });
  $('#num8').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); repeat_down();   });
  $('#num2').mousedown( function(event) { event.preventDefault();
    event.stopPropagation(); overlay_down();   });

  window.addEventListener('mouseup', function(event) {
    event.preventDefault();
    event.stopPropagation();
    if(play_pressed)      { deactivate(5); pause_up();    }
    if(rewind_pressed)    { deactivate(4); rewind_up();   }
    if(forward_pressed)   { deactivate(6); forward_up();  }
    if(start_pressed)     { deactivate(7); start_up();    }
    if(end_pressed)       { deactivate(9); end_up();      }
    if(previous_pressed)  { deactivate(1); previous_up(); }
    if(next_pressed)      { deactivate(3); next_up();     }
    if(repeat_pressed)    { deactivate(8); repeat_up();   }
    if(overlay_pressed)   { deactivate(2); overlay_up();  }
  });

  // Keyboard events

  window.addEventListener('keydown', function(event) {
    event.preventDefault();
    event.stopPropagation();
    switch(event.keyCode) {
      case keys[5]:
          activate(5);
          pause_down();
          break;
      case keys["space"]:
          activate(5);
          pause_down();
          break;
      case keys[4]:
          activate(4);
          rewind_down();
          break;
      case keys[6]:
          activate(6);
          forward_down();
          break;
      case keys[7]:
          activate(7);
          start_down();
          break;
      case keys[9]:
          activate(9);
          end_down();
          break;
      case keys[1]:
          activate(1);
          previous_down();
          break;
      case keys[3]:
          activate(3);
          next_down();
          break;
      case keys[8]:
          activate(8);
          repeat_down();
          break;
      case keys[2]:
          activate(2);
          overlay_down();
          break;
    }
    /*
        if(has_find) {
          activate(parseInt(event.keyCode));
        }
    */
  });

  window.addEventListener('keyup', function(event) {
    event.preventDefault();
    event.stopPropagation();
    switch(event.keyCode) {
      case keys[5]:
          deactivate(5);
          pause_up();
          break;
      case keys["space"]:
          deactivate(5);
          pause_up();
          break;
      case keys[4]:
          deactivate(4);
          rewind_up();
          break;
      case keys[6]:
          deactivate(6);
          forward_up();
          break;
      case keys[7]:
          deactivate(7);
          start_up();
          break;
      case keys[9]:
          deactivate(9);
          end_up();
          break;
      case keys[1]:
          deactivate(1);
          previous_up();
          break;
      case keys[3]:
          deactivate(3);
          next_up();
          break;
      case keys[8]:
          deactivate(8);
          repeat_up();
          break;
      case keys[2]:
          deactivate(2);
          overlay_up();
          break;
    }
  });

  // Playback variables

  var iframe = document.getElementById("iframe");
  var iframeCloned = document.getElementById("iframe_clone");
  var innerFrame = iframe.contentWindow;
  var innerFrameCloned = iframeCloned.contentWindow;
 
  var paused = false;
  var repeat = false;
  var overlay_hidden = false;
  var play_pressed = false;
  var rewind_pressed = false;
  var forward_pressed = false;
  var start_pressed = false;
  var end_pressed = false;
  var previous_pressed = false;
  var next_pressed = false;
  var repeat_pressed = false;
  var overlay_pressed = false;


  if(typeof readAmOverlayerShow() == 'null' || readAmOverlayerShow() == 0) {

    hide_overlay();
    $("#num2").addClass("hidden");
    overlay_hidden = true;

  }
   else {
      show_overlay();
      $("#num2").removeClass("hidden");
      overlay_hidden = false;
  }


  // Playback functions

  function pause_down() {
    if (play_pressed == false) {
      play_pressed = true;
      if (paused == false) {
        console.log("PAUSE");
        show_pause();
        innerFrame.main_timeline.pause();
        innerFrameCloned.main_timeline.pause();
        paused = true;
      }
      else {
        console.log("PLAY");
        show_play();
        innerFrame.main_timeline.play();
        innerFrameCloned.main_timeline.play();
        paused = false;
      }
    }
  }

  function pause_up() {
    play_pressed = false;
  }

  function rewind_down() {
    if(rewind_pressed == false) {
      rewind_pressed = true;
      console.log("REWIND");
      innerFrame.main_timeline.timeScale(speed_increase);
      innerFrame.main_timeline.reverse();
      innerFrameCloned.main_timeline.timeScale(speed_increase);
      innerFrameCloned.main_timeline.reverse();
    }
  }

  function rewind_up() {
    rewind_pressed = false;
    innerFrame.main_timeline.timeScale(1);
    innerFrameCloned.main_timeline.timeScale(1);

    if (paused == true) {
      console.log("STAY PAUSED");
      innerFrame.main_timeline.pause();
      innerFrameCloned.main_timeline.pause();
    }
    else {
      console.log("RESUME");
      innerFrame.main_timeline.play();
      innerFrameCloned.main_timeline.play();
    }
  }

  function forward_down() {
    if (forward_pressed == false) {
      forward_pressed = true;
      console.log("FORWARD");
      innerFrame.main_timeline.timeScale(speed_increase);
      innerFrame.main_timeline.play();

       innerFrameCloned.main_timeline.timeScale(speed_increase);
      innerFrameCloned.main_timeline.play();
    }
  }

  function forward_up() {
    forward_pressed = false;
    innerFrame.main_timeline.timeScale(1);
    innerFrameCloned.main_timeline.timeScale(1);
    if (paused == true) {
      console.log("STAY PAUSED");
      innerFrame.main_timeline.pause();
            innerFrameCloned.main_timeline.pause();

    }
    else {
      console.log("RESUME");
      innerFrame.main_timeline.play();
      innerFrameCloned.main_timeline.play();
    }
  }

  function start_down() {
    if (start_pressed == false) {
      start_pressed = true;
      console.log("RESTART");
      innerFrame.main_timeline.restart();
      innerFrameCloned.main_timeline.restart();
      if (paused == true) {
        innerFrame.main_timeline.pause();
        innerFrameCloned.main_timeline.pause();
      }
      else {
        innerFrame.main_timeline.play();
        innerFrameCloned.main_timeline.play();

      } 

    }
  }

  function start_up() {
    start_pressed = false;
  }

  function end_down() {
    if(end_pressed == false) {
      end_pressed = true;
      console.log("END");
      innerFrame.main_timeline.progress(1, false);
      innerFrameCloned.main_timeline.progress(1, false);
    }
  }

  function end_up() {
    end_pressed = false;
  }

  function get_time() {
  if(!(innerFrame.main_timeline))
    return 0;
  var current_progress = innerFrame.main_timeline.progress();
    var total_duration = innerFrame.main_timeline.duration();
    var current_time = current_progress * total_duration;
    return current_time;
  }
 function get_total_time() {
  if(!(innerFrame.main_timeline))
    return 0;

  return parseFloat(innerFrame.main_timeline.totalDuration()).toFixed(2);;
  }
  function previous_down() {
   if(previous_pressed == false) {
      previous_pressed = true;
   }

  }

  function previous_up() {
    previous_pressed = false;
  }

  function next_down() {
   if(previous_pressed == false) {
      next_pressed = true;
   }

  }

  function next_up() {
    next_pressed = false;
  }

  function repeat_down() {
    if (repeat_pressed == false) {
      repeat_pressed = true;
      if (repeat == false) {
        console.log("REPEAT ON");
        show_repeat();
        repeat = true;
      }
      else {
        console.log("REPEAT OFF");
        show_no_repeat();
        repeat = false;
      }
    }
  }

  function repeat_up() {
    repeat_pressed = false;
  }

  function overlay_down() {
    if (overlay_pressed == false) {
      overlay_pressed = true;
      if (overlay_hidden == false) {
        console.log("HIDE OVERLAYS");
        hide_overlay();
        disableAmOverlayerShow();
        $("#num2").addClass("hidden");
        overlay_hidden = true;

      }
      else {
        console.log("SHOW OVERLAYS");
        show_overlay();
        enableAmOverlayerShow();
        $("#num2").removeClass("hidden");
        overlay_hidden = false;
      }
    }
  }

  function overlay_up() {
    overlay_pressed = false;
  }

  function go_to_label(label) {
    console.log("GO TO LABEL: "+label);
    innerFrame.main_timeline.seek(label);
        innerFrameCloned.main_timeline.seek(label);

  }

  // Display functions

  function show_pause() {
    document.getElementById("num5").className += " paused";
  }

  function show_play() {
    document.getElementById("num5").className = document.getElementById("num5").className.replace( /(?:^|\s)paused(?!\S)/g , '' )
  }

  function show_repeat() {
    document.getElementById("num8").className += " repeat";
  }

  function show_no_repeat() {
    document.getElementById("num8").className = document.getElementById("num8").className.replace( /(?:^|\s)repeat(?!\S)/g , '' )
  }

  function outerHTML(s) {
  return (s)
  ? this.before(s).remove()
  : jQuery("&lt;p&gt;").append(this.eq(0).clone()).html();
  }

  jQuery.fn.reverse = [].reverse;

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


  // Timer (jQuery)

  function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
  }


    var ttime;
    window.setInterval(function() {
    if(!(innerFrame.main_timeline))
        return;

    if(ttime === undefined){
      ttime = get_total_time();
       $("#duration").text(ttime);
       $(".t_end").text(ttime+' s');

    }
    var current_time = get_time();
      current_time = String(parseFloat(Math.round(current_time*100)/100).toFixed(2));
      if(current_time.length == 4) current_time = "0" + current_time;
      $("#time").text(current_time);
      $("#time_2").text(current_time + " s");
      var total = innerFrame.main_timeline.totalDuration();
      var pct = current_time/total*100;
      $("#time_passed").css({"width":pct+"%"});
      if(repeat && current_time >= total.toFixed(2)) { innerFrame.main_timeline.restart(); innerFrameCloned.main_timeline.restart(); } 
    }, 10);



  var timeline_updatable = false;
  function update_timeline(event) {
    var mouse_x = event.pageX;
    var total_width = $(document).width();
    var pct = mouse_x / total_width;
    pct = Math.round(pct*1000)/1000;
    var total_duration = innerFrame.main_timeline.totalDuration();
    var target_time = pct * total_duration;
    innerFrame.main_timeline.seek(target_time);
     innerFrameCloned.main_timeline.seek(target_time);
    console.log("GO TO TIME: "+target_time);
  }

  var paused_before_mousedown = false;

  $("#timeline_container").mousedown(function(event){
  if(paused) paused_before_mousedown = true;
    else paused_before_mousedown = false;
    innerFrame.main_timeline.pause();
     innerFrameCloned.main_timeline.pause();
    timeline_updatable = true;
    update_timeline(event);

  });

  $(window).mousemove(function(event){
    event.preventDefault();
    event.stopPropagation();
    if (timeline_updatable) update_timeline(event);
  });

  $(window).mouseup(function(event){
    event.preventDefault();
    event.stopPropagation();
    if(!paused_before_mousedown && timeline_updatable) {innerFrame.main_timeline.resume(); innerFrameCloned.main_timeline.resume(); }
    timeline_updatable = false;
  });

  });
  
});



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
  this.iframe.load(function() {
      self.content = $('#iframe').contents();
      self.loaded = true
  });
  this.iframeCloned.load(function() {
      self.contentCloned = $('#iframe_clone').contents();
      self.loadedCloned = true
  });

  var i = setInterval(function() {
    if(self.loaded && self.loadedCloned) {
      $(self).trigger("onLoaded");
      clearInterval(i);
    }
  }, 20);
}

AnimationContainer.prototype.center = function() {

    var o = this.content.find('body').children().first();
    var ocloned = this.contentCloned.find('body').children().first();

    /*this.iframe.css({position: 'absolute', top : 0, left: 0});
    this.iframeCloned.css({position: 'absolute', top : 0, left: 0});*/

    this.iframe.css({
        'position' : 'absolute',
        'left' : '50%',
        'top' : '50%',
    });
    this.iframeCloned.css({
      'position' : 'absolute',
        'left' : '50%',
        'top' : '50%',
    });

    ocloned.css({overflow: 'visible'});
    this.contentCloned.find('body').css({opacity: 0.45});
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
