/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "inicioJogo") { 
		global.estadoJogo = "jogando";
	}

	if ((global.estadoJogo = "jogando") && (!touched)) {
		touchs++;
		if (instance_exists(objHeroi)) {
			objHeroi.x = x+48;
			objHeroi.y = y;
		} else {
			instance_create_layer(x+48,y,"Instances",objHeroi);
		}
		instance_create_layer(x,y,"inst_cima",objMachado);
		//Faz animação de que vai cortar madeira
	
		alarm[0] = 1;
	}
}

