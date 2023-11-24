<?php
inc(2); // Increment
dec(2); // Decrement

play('#', 0.5, 1, "LINEAR", delay() + 0.5); // Element, duration, animation, ease, animationDelay

play('#', 0, 1, "EXPO_IN");
play('#', 0, 1, "EXPO_OUT");
play('#', 0, 1, "EXPO_INOUT");

play('#', 0, 1, "SINE_IN");
play('#', 0, 1, "SINE_OUT");
play('#', 0, 1, "SINE_INOUT");

play('#', 0, 1, "QUAD_IN");
play('#', 0, 1, "QUAD_OUT");
play('#', 0, 1, "QUAD_INOUT");

play('#', 0, 1, "BACK_IN:5");
play('#', 0, 1, "BACK_OUT:5");
play('#', 0, 1, "BACK_INOUT:5");

stagger('#', 0.5, 2, 'LINEAR', 0.1, 0.5); // Element, duration, animation, ease, staggerDelay, animationDelay


function sample(){
  for($i = 1; $i <= 4; $i++){
    play('#', 0.3, 1, 'SINE_OUT');
    inc(0.15);
  }
}