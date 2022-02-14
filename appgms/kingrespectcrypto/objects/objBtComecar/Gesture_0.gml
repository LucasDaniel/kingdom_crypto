/// @description Insert description here
// You can write your code in this editor

if (global.estadoJogo = "inicioJogo") { 
	global.estadoJogo = "jogando";
	instance_create_layer(x,y-64,"inst_cima",objBtCima);
	instance_create_layer(x+64,y,"inst_cima",objBtDir);
	instance_create_layer(x,y+64,"inst_cima",objBtBaixo);
	instance_create_layer(x-64,y,"inst_cima",objBtEsq);
	instance_destroy();
}
