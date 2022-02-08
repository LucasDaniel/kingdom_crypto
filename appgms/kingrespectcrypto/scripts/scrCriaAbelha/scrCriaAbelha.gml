// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrCriaAbelha(){

posY = 0;
posX = 0;

direcao = "";
sentido = "";

iSentido = irandom_range(0,1);
iDirecao = irandom_range(0,1);

if (iSentido < 1) { // Sentido - horizontal
	sentido = "horizontal";
	if (iDirecao < 1) { // Direção - esquerda
		posY = 120+(irandom_range(0,5)*120);
		posX = room_width+50;
		direcao = "esquerda";
	} else { // Direção - direita
		posY = 120+(irandom_range(0,5)*120);
		posX = -50;
		direcao = "direita";
	}
} else { // Sentido - vertical
	sentido = "vertical";
	if (iDirecao < 1) { // Direção - baixo
		posY = -50;
		posX = 180+(irandom_range(0,3)*120);
		direcao = "baixo";
	} else { // Direção - cima
		posY = room_height+50;
		posX = 180+(irandom_range(0,3)*120);
		direcao = "cima";
	}
}

abelha = instance_create_layer(posX,posY,"inst_cima",objAbelha);
abelha.direcao = direcao;
abelha.sentido = sentido;

}