/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		x += velox;
		
		if (velox > 0) {
			if (x > 540) instance_destroy();
		} else {
			if (x < -69) instance_destroy();
		}
		
	}
}
