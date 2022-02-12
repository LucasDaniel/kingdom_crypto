/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		
		contCriaPeixe++;
		if (contCriaPeixe > contCriaPeixeMax) {
			contCriaPeixe = 0;
			valy = irandom_range(30,800);
			valx = irandom_range(0,1);
			instance_create_layer(-70+(680*valx),valy,"instances",objPeixe);
		}
		
		contCriaPirata -= 1;
		if (contCriaPirata < 1) {
			auxTempo = contCriaPirataMax-(global.multiplier/0.05);
			if (auxTempo < 46) contCriaPirata = 45;
			else contCriaPirata = contCriaPirataMax-(global.multiplier/0.05);
			scrCriaPirata();
		}
		
		contCriaPirataPai -= 1;
		if (contCriaPirataPai < 1) {
			auxTempo = contCriaPirataPaiMax-(global.multiplier/0.05);
			if (auxTempo < 46) contCriaPirataPai = 45;
			else contCriaPirataPai = contCriaPirataPaiMax-(global.multiplier/0.05);
			instance_create_layer(-100,-100,"instance_pirata",objPirataPai);
		}
		
	}		
}
