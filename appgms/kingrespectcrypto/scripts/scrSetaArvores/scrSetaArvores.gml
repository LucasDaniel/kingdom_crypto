// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrSetaArvores(){

for (i = 0; i < 3; i++) {
	for (j = 0; j < 5; j++) {
		if(arvores[i][j] == 1) {
			arvores[i][j] = instance_create_layer(120+(120*i),120+(120*j),"instances",objArvore);
			arvores[i][j].i = i;
			arvores[i][j].j = j;
		}
	}	
}

}