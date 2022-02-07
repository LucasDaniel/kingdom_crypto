/// @description Insert description here
// You can write your code in this editor

if (estadoJogo = "jogando") {
	contCriaArvore -= 1;
	if (contCriaArvore < 1) {
		contCriaArvore = tempoCriaArvore;
		scrCriaArvores(1);
		scrSetaArvores();
	}
}
