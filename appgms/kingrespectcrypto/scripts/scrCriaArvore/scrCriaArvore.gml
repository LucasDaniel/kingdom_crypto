// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrCriaArvore(){

//Variaveis de posição do objeto dentro de arvores
i = -1;
j = -1;

//Variavel de probabilidade do que vai fazer
prob = irandom_range(0,100);
nivel = 0;
touchs = 0; //Quantidade de vezes que o objeto foi tocado

if (global.multiplier < 2) {
	nivel = scrNivelArvore(prob,95,75);
} else if (global.multiplier < 3) {
	nivel = scrNivelArvore(prob,90,70);
} else if (global.multiplier < 4) {
	nivel = scrNivelArvore(prob,85,65);
} else if (global.multiplier < 5) {
	nivel = scrNivelArvore(prob,80,60);
} else if (global.multiplier < 6) {
	nivel = scrNivelArvore(prob,75,55);
} else if (global.multiplier < 7) {
	nivel = scrNivelArvore(prob,70,50);
} else if (global.multiplier < 8) {
	nivel = scrNivelArvore(prob,65,45);
} else if (global.multiplier < 9) {
	nivel = scrNivelArvore(prob,60,40);
} else { //multiplicador é maior que 9
	nivel = scrNivelArvore(prob,55,35);
}

if (nivel > 2) sprite_index = sprArvoreForte;
else if (nivel > 1) sprite_index = sprArvoreMedia;


}