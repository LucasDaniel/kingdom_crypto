/// @description Insert description here
// You can write your code in this editor
image_speed = 0.5;
if (!global.pause) {
	if (velo > 0) {
		if (direcao = "direita") {
			x += velo;
			sprite_index = sprAbelhaLado;
			image_xscale = -1;
		} else if (direcao = "esquerda") {
			x -= velo;
			sprite_index = sprAbelhaLado;
			image_xscale = 1;
		} else if (direcao = "baixo") {
			y += velo;
			sprite_index = sprAbelhaBaixo;
		} else { //cima
			y -= velo;
			sprite_index = sprAbelhaCima;
		}
	
		contDestroy--;
		if (contDestroy < 1) {
			instance_destroy();	
		}
	}
}
