/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		
		contCriaBat -= 1;
		if (contCriaBat < 1) {
			auxTempo = contCriaBatMax-(global.multiplier/0.05);
			if (auxTempo < 61) contCriaBat = 60;
			else contCriaBat = contCriaBatMax-(global.multiplier/0.05);
			scrCriaBat();
		}
		
		if (objCaveman.posicao = "centro") {
			tempoMineirando -= 1;
			if (tempoMineirando < 1) {
				tempoMineirando = tempoMineirandoMax;
				_objAnimPontos = instance_create_layer(room_width/2,room_height/2,"inst_cima",objAnimPontos);
				_objAnimPontos.pontos = "0.05";
				global.multiplier += 0.05;
				if (global.multiplier > 9.95) {
					scrSendMultiplierServer();	
				}
			}
		}
		
	}
}
