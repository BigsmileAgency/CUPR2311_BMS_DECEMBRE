<?php require_once 'common/utils/config/settings/functions.php';

	$timeScale = 1;

	set('delay', 0 * $timeScale);
	[[exemple]]
	//inc(0.5 * $timeScale);
	//dec(0.5 * $timeScale);

	//PLAY ANIMATIONS
		//play('#obj', 0.5 * $timeScale, 1, 'sine-ease-out');
		//stagger('.obj', 0.5 * $timeScale, 1, 'quad-ease-in', 0.2 * $timeScale);
		//chain(array('#obj', '.obj'), 0.5 * $timeScale, 1, 'quad-ease-in', 0.2 * $timeScale);

	//PLAY ANIMATIONS WITH A CUSTOM DELAY
		//play('#obj', 0.5 * $timeScale, 1, 'sine-ease-out', delay() + (0.2 * $timeScale));
		//play('#obj', 0.5 * $timeScale, 1, 'sine-ease-out', 8 * $timeScale);

	//ITERATION
		//ic('#obj', 5)

		//ITERATION DIRECTION
			//dr('#obj', 'normal' | 'reverse' | 'alternate' | 'alternate-reverse')

	[[splitText]]

	//SPLITTEXT
		//stagger('js:o1Lines', 0.5 * $timeScale, 1, 'linear', 0.2 * $timeScale);
		//stagger('js:o1words', 0.2 * $timeScale, 1, 'back-out:1.2', 0.2 * $timeScale);
		//stagger('js:o1Chars', 0.5 * $timeScale, 1, 'sine-ease-out', 0.1 * $timeScale);
		//stagger('js:o2Chars', 0.2 * $timeScale, 1, 'back-out:1.2', 0.2 * $timeScale);
		//stagger('js:o3Lines', 0.5 * $timeScale, 1, 'sine-ease-out', 0.1 * $timeScale);
	[[!splitText]]

	//EASING
		//	ease-none					linear
		//	ease 						linear-ease
		//	ease-in 					linear-ease-in
		//	ease-in-out 				linear-ease-in-out
		//	quad-in 					quad-ease-in
		//	quad-out 					quad-ease-out
		//	quad-in-out					quad-ease-in-out
		//	cubic-in 					cubic-ease-in
		//	cubic-out 					cubic-ease-out
		//	cubic-in-out				cubic-ease-in-out
		//	quart-in 					quart-ease-in
		//	quart-out 					quart-ease-out
		//	quart-in-out				quart-ease-in-out
		//	quint-in 					quint-ease-in
		//	quint-out 					quint-ease-out
		//	quint-in-out				quint-ease-in-out
		//	strong-in 					strong-ease-in
		//	strong-out 					strong-ease-out
		//	strong-in-out				strong-ease-in-out
		//	sine-in 					sine-ease-in
		//	sine-out 					sine-ease-out
		//	sine-in-out					sine-ease-in-out
		//	expo-in 					expo-ease-in
		//	expo-out 					expo-ease-out
		//	expo-in-out					expo-ease-in-out
		//	circ-in 					circ-ease-in
		//	circ-out 					circ-ease-out
		//	circ-in-out					circ-ease-in-out
		//	back-in 					back-ease-in
		//	back-out 					back-ease-out
		//	back-in-out					back-ease-in-out
		//	back-in:1 					back-ease-in:1
		//	back-out:1					back-ease-out:1
		//	back-in-out:1				back-ease-in-out:1
		//	elastic-in 					elastic-ease-in
		//	elastic-out 				elastic-ease-out
		//	elastic-in-out				elastic-ease-in-out
		//	elastic-in:1:1 				elastic-ease-in:1:1
		//	elastic-out:1:1 			elastic-ease-out:1:1
		//	elastic-in-out:1:1 			elastic-ease-in-out:1:1
		//	bounce-in 					bounce-ease-in
		//	bounce-out 					bounce-ease-out
		//	bounce-in-out				bounce-ease-in-out
		//	power0
		//	power1-in 					power1-ease-in
		//	power1-out 					power1-ease-out
		//	power1-in-out				power1-ease-in-out
		//	power2-in 					power2-ease-in
		//	power2-out 					power2-ease-out
		//	power2-in-out				power2-ease-in-out
		//	power3-in 					power3-ease-in
		//	power3-out 					power3-ease-out
		//	power3-in-out				power3-ease-in-out
		//	power4-in 					power4-ease-in
		//	power4-out 					power4-ease-out
		//	power4-in-out				power4-ease-in-out
		//	slow-mo:1:1					slow-motion:1:1
		//	slow-mo:1:1:false|true		slow-motion:1:1:false|true

	[[!exemple]]

?>


