/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		if (objAdventure.qtdAtaques > 0) {
			objAdventure.qtdAtaques -= 1;
			instance_create_layer(objAdventure.x,objAdventure.y,"instances",objAtaque);
		}
	}	
}
