/// @description Insert description here
// You can write your code in this editor

game = "wood";

//cria as arvores cheias

contInimigos = 0;
contMaxInimigos = 0;

pauseGame = false;

pontos = 0;

//Parei aqui - Fazer criar o jogo



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
