/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		
		if (y < 170) x += 10;  
		else y -= 3;
		
		if (x > 600) instance_destroy();
	}
}
