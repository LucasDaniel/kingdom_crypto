/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (estadoJogo = "jogando") {
		contCriaArvore -= 1;
	
		if (contCriaArvore < 1) {
			contCriaArvore = tempoCriaArvore;
			scrCriaArvores(1);
			scrSetaArvores();
		}
	
		contCriaAbelha -= 1;
		if (contCriaAbelha < 1) {
			auxTempo = tempoCriaAbelha-(global.multiplier/0.05);
			if (auxTempo < 46) contCriaAbelha = 45;
			else contCriaAbelha = tempoCriaAbelha-(global.multiplier/0.05);
			scrCriaAbelha();
		}
	
	}
}
