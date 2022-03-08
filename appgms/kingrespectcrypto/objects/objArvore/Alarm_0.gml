/// @description Insert description here
// You can write your code in this editor

if (nivel <= touchs) {
	touched = true;
	_objAnimPontos = instance_create_layer(x,y,"inst_cima",objAnimPontos);
	_objAnimPontos.pontos = "0.05";
	objAdmWoodGame.arvores[i][j] = 0;
	objAdmWoodGame.contArvores--;
	if (instance_exists(objHeroi)) objHeroi.image_index = 0;
	instance_destroy();
} else {
	if (instance_exists(objHeroi)) objHeroi.image_index = 1;
}