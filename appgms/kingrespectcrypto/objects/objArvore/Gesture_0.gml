/// @description Insert description here
// You can write your code in this editor

if (objAdmWoodGame.estadoJogo = "inicioJogo") { 
	objAdmWoodGame.estadoJogo = "jogando";
}

if (objAdmWoodGame.estadoJogo = "jogando") {
	touchs++;
	//Faz animação de que vai cortar madeira
	if (nivel <= touchs) {
		objAdmWoodGame.arvores[i][j] = 0;
		objAdmWoodGame.contArvores--;
		instance_destroy();
	}
}
