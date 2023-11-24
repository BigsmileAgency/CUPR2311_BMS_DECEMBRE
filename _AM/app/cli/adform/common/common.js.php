[[noGFont]]<!-- GetValueProcess:beginVars -->[[splitText]][[exemple]]/*var splitText1, splitText2, splitText3, o1Lines, o1Words, o1Chars, o2Chars, o3Lines;*/[[!exemple]][[!splitText]]
var mouse_allow = false;
<!-- GetValueProcess:endVars -->
<!-- GetValueProcess:beginLoaded -->
	
	TweenMax.set('#container', { autoAlpha : 1});
	[[splitText]][[exemple]]
			
	/*splitText1 = new SplitText("#t1", {type:"lines,words,chars", charsClass:"char char++",  wordsClass:"word word++", linesClass:"line line++"}), 
	o1Chars = splitText1.chars;
	o1Words = splitText1.words;
	o1Lines = splitText1.lines;

	splitText2 = new SplitText("#t2", {type:"chars", charsClass:"char char++"}), 
	o2Chars = splitText2.chars;

	splitText3 = new SplitText("#t3", {type:"lines", linesClass:"line line++"}), 
	o3Lines = splitText3.lines;*/

	[[!exemple]][[!splitText]]init();

<!-- GetValueProcess:endLoaded -->
<!-- GetValueProcess:beginInit -->
	[[exemple]]/*main_timeline.call(function(){ mouse_allow = true});*/
	[[!exemple]]launch();
<!-- GetValueProcess:endInit -->
<!-- GetValueProcess:beginEvents -->[[exemple]]
		
	/*document.getElementsByClassName('cta')[0].addEventListener('mouseenter', onMouseEnterHandler, false);
	document.getElementsByClassName('cta')[0].addEventListener('mouseleave', onMouseLeaveHandler, false);*/

[[!exemple]]<!-- GetValueProcess:endEvents -->
<!-- GetValueProcess:beginFunctions -->[[exemple]]
		
	/*function onMouseEnterHandler(e){
		if(mouse_allow){
			TweenMax.fromTo('.cta', 1, {scale: 1}, {scale: 1.1, ease: Sine.easeIn});
		}
	}

	function onMouseLeaveHandler(e){
		if(mouse_allow){
			TweenMax.fromTo('.cta', 1, {}, {scale: 1.1}, {scale: 1, ease: Sine.easeOut});
		}
	}*/
	
[[!exemple]]<!-- GetValueProcess:endFunctions -->
[[!noGFont]][[GFont]]<!-- GetValueProcess:beginVars -->
	var interval[[splitText]][[exemple]]/*, splitText1, splitText2, splitText3, o1Lines, o1Words, o1Chars, o2Chars, o3Lines */[[!exemple]][[!splitText]];
	var mouse_allow = false;
<!-- GetValueProcess:endVars -->
<!-- GetValueProcess:beginLoaded -->
	
	interval = setInterval(function() {
		if(fonts_loaded){

			TweenMax.set('#container', { autoAlpha : 1});
			clearInterval(interval);
			[[splitText]][[exemple]]
			
			/*splitText1 = new SplitText("#t1", {type:"lines,words,chars", charsClass:"char char++",  wordsClass:"word word++", linesClass:"line line++"}), 
    		o1Chars = splitText1.chars;
    		o1Words = splitText1.words;
    		o1Lines = splitText1.lines;

    		splitText2 = new SplitText("#t2", {type:"chars", charsClass:"char char++"}), 
    		o2Chars = splitText2.chars;

    		splitText3 = new SplitText("#t3", {type:"lines", linesClass:"line line++"}), 
    		o3Lines = splitText3.lines;*/

			[[!exemple]][[!splitText]]init();
		}
	}, 200);

<!-- GetValueProcess:endLoaded -->
<!-- GetValueProcess:beginInit -->
	[[exemple]]/*main_timeline.call(function(){ mouse_allow = true});*/
	[[!exemple]]launch();
<!-- GetValueProcess:endInit -->
<!-- GetValueProcess:beginEvents -->[[exemple]]
		
	/*document.getElementById('clickThroughBtn').addEventListener('mouseenter', onMouseEnterHandler, false);
	document.getElementById('clickThroughBtn').addEventListener('mouseleave', onMouseLeaveHandler, false);*/
	
[[!exemple]]<!-- GetValueProcess:endEvents -->
<!-- GetValueProcess:beginFunctions -->[[exemple]]
				
	/*function onMouseEnterHandler(e){
		if(mouse_allow){
			TweenMax.fromTo('.cta', 1, {scale: 1}, {scale: 1.1, ease: Sine.easeIn});
		}
	}

	function onMouseLeaveHandler(e){
		if(mouse_allow){
			TweenMax.fromTo('.cta', 1, {scale: 1.1}, {scale: 1, ease: Sine.easeOut});
		}
	}*/
	
[[!exemple]]<!-- GetValueProcess:endFunctions -->[[!GFont]]