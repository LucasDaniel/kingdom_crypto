/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (global.estadoJogo = "jogando") {
		
		if (qtdAtaques < qtdAtaquesMax) {
			contQtdAtaques -= 1;
			if (contQtdAtaques < 1) {
				contQtdAtaques = contQtdAtaquesMax;
				qtdAtaques += 1;
			}
		}
		
		
	}	
}
