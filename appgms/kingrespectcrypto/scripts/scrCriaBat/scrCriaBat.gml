// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrCriaBat(){

direcao = "";
sentido = "";
cimaBaixo = "";

iSentido = irandom_range(0,1);
iDirecao = irandom_range(0,1);
iCimaBaixo = irandom_range(0,1);

var meiox = room_width/2;
var meioy = room_height/2;

posX = 0;
posY = 0;

maisX = 20;
maixY = 30;

if (iSentido < 1) { // Sentido - horizontal
	sentido = "horizontal";
	if (iDirecao < 1) { // Direção - esquerda
		direcao = "esquerda";
		if (iCimaBaixo) {
			cimaBaixo = "cima";
			posX = room_width+maisX;
			posY = meioy+maixY;
		} else {
			cimaBaixo = "baixo";
			posX = room_width+maisX;
			posY = meioy-maixY;
		}
	} else { // Direção - direita
		direcao = "direita";
		if (iCimaBaixo) {
			cimaBaixo = "cima";
			posX = -maisX;
			posY = meioy+maixY;
		} else {
			cimaBaixo = "baixo";
			posX = -maisX;
			posY = meioy-maixY;
		}
	}
} else { // Sentido - vertical
	sentido = "vertical";
	if (iDirecao < 1) { // Direção - baixo
		direcao = "baixo";
		if (iCimaBaixo) {
			cimaBaixo = "dir";
			posX = meiox+maixY;
			posY = -maisX;
		} else {
			cimaBaixo = "esq";
			posX = meiox-maixY;
			posY = -maisX;
		}
	} else { // Direção - cima
		direcao = "cima";
		if (iCimaBaixo) {
			cimaBaixo = "dir";
			posX = meiox+maixY;
			posY = room_height+maisX;
		} else {
			cimaBaixo = "esq";
			posX = meiox-maixY;
			posY = room_height+maisX;
		}
	}
}

bat = instance_create_layer(posX,posY,"inst_cima",objBat);
bat.direcao = direcao;
bat.sentido = sentido;

}