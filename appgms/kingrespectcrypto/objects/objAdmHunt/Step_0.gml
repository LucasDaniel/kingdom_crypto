/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "inicioJogo") global.estadoJogo = "jogando";
	
	if (global.estadoJogo = "jogando") {
	
		contCriaHunt -= 1;
		if (contCriaHunt < 1) {
			auxTempo = contCriaHuntMax-(global.multiplier/0.05);
			if (auxTempo < 46) contCriaHunt = 45;
			else contCriaHunt = contCriaHuntMax-(global.multiplier/0.05);
			scrCriaHunt();
		}
		
		contCriaEspinhos -= 1;
		if (contCriaEspinhos < 1) {
			auxTempo = contCriaEspinhosMax-(global.multiplier/0.05);
			if (auxTempo < 46) contCriaEspinhos = 45;
			else contCriaEspinhos = contCriaEspinhosMax-(global.multiplier/0.05);
			scrCriaEspinhos();
		}
	
	}	
}
