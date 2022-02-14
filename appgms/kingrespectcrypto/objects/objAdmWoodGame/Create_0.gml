/// @description Insert description here
// You can write your code in this editor

//scrVariaveisGlobais();

game = "wood";

global.multiplier = 0;

//cria as arvores cheias

global.estadoJogo = "inicioJogo";

pontos = 0;

tempoCriaArvore = 60;
contCriaArvore = tempoCriaArvore;

tempoCriaAbelha = 165;
contCriaAbelha = tempoCriaAbelha;

//Cria as variaveis das arvores
for (i = 0; i < 3; i++) {
	for (j = 0; j < 5; j++) {
		arvores[i][j] = 0;
	}	
}

contArvores = 0; //Vai criar 5 arvores de inicio de jogo em pontos aleatorios

scrCriaArvores(5);

scrSetaArvores();
