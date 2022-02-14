/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		
		contCriaBat -= 1;
		if (contCriaBat < 1) {
			auxTempo = contCriaBatMax-(global.multiplier/0.05);
			if (auxTempo < 46) contCriaBat = 45;
			else contCriaBat = contCriaBatMax-(global.multiplier/0.05);
			scrCriaBat();
		}
	}
}
