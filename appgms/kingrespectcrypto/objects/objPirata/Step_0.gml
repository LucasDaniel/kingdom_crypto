/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		
		x += velox;
		y += veloy;
		
		if (velox > 0) image_xscale = -1;
		else image_xscale = 1;
	
		cont--;
		if (cont < 1) instance_destroy();
		
	}
}
