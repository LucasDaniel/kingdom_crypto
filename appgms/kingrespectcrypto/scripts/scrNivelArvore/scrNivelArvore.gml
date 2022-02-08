// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
//Pega a probabilidade e verifica qual tipo de arvore vai criar
function scrNivelArvore(p,n3,n2){

var _nivel = 1;
n3 -= 10;
n2 -= 10;

if (scrProb(p,n3)) {
	_nivel = 3;
} else if (scrProb(p,n2)) {
	_nivel = 2;
}

return _nivel;

}