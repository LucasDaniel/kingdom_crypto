/// @description Insert description here
// You can write your code in this editor

game = "wood";

global.multiplier = 1;

//cria as arvores cheias

estadoJogo = "inicioJogo";

contInimigos = 0;
contMaxInimigos = 0;

pauseGame = false;

pontos = 0;

tempoCriaArvore = 60;
contCriaArvore = tempoCriaArvore;

//Cria as variaveis das arvores
for (i = 0; i < 3; i++) {
	for (j = 0; j < 5; j++) {
		arvores[i][j] = 0;
	}	
}

contArvores = 0; //Vai criar 5 arvores de inicio de jogo em pontos aleatorios

scrCriaArvores(5);

scrSetaArvores();

//da o instance create nas arvores


/*

Criar as arvores dinamicamente
Ao tocar na arvore, dependendo do equipamento e profissão, corta mais rapido ou mais devagar
De tempos em tempos vem uma abelha pra atrapalhar
	elas vem na vertical e horizontal, avisando com uma seta antes
	pode ter uma abelha que fica perseguindo devagar ou rapido
ao destruir a arvore, demora um tempo pra construir de novo
ao ser tocado pela abelha, se perde 1 de hp, tem 3 de hp, chegou a 0, acabou o jogo
	perde-se todo o multiplicador. Quando se corta uma madeira, ganha-se 0,05 de multiplicador
ao chegar 10 de multiplicador, termina-se o jogo

*/
