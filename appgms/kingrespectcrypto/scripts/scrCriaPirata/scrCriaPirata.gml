// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrCriaPirata(){
	
aux = irandom_range(0,3);
velox = 0;
veloy = 0;

if (aux = 0) {
	//Encima a esquerda
	posx = irandom_range(0,100)*-1;
	posy = irandom_range(0,600)*-1;
} else if (aux = 1) {
	//Encima a direita
	posx = irandom_range(640,740);
	posy = irandom_range(0,600)*-1;
} else if (aux = 2) {
	//Embaixo a esquerda
	posx = irandom_range(0,100)*-1;
	posy = irandom_range(200,1300);
} else { //aux = 3
	//Embaixo a direita
	posx = irandom_range(640,740);
	posy = irandom_range(200,1300);
}

if (posx > 0) velox = -1;
else velox = 1;

if (posy > 0) veloy = -1;
else veloy = 1;

pirata = instance_create_layer(posx,posy,"instance_pirata",objPirata);
pirata.velox *= velox;
pirata.veloy *= veloy;

}