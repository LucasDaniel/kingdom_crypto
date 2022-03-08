/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (velo > 0) {
		if (direcao = "direita") {
			x += velo;
			sprite_index = sprBatLado;
			image_xscale = -1;
		} else if (direcao = "esquerda") {
			x -= velo;
			sprite_index = sprBatLado;
			image_xscale = 1;
		} else if (direcao = "baixo") {
			y += velo;
			sprite_index = sprBatBaixo;
		} else { //cima
			y -= velo;
			sprite_index = sprBatCima;
		}
	
		contDestroy--;
		if (contDestroy < 1) {
			instance_destroy();	
		}
	}
}
