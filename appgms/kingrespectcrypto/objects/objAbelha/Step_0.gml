/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	if (velo > 0) {
		if (direcao = "direita") {
			x += velo;
		} else if (direcao = "esquerda") {
			x -= velo;
		} else if (direcao = "baixo") {
			y += velo;
		} else { //cima
			y -= velo;
		}
	
		contDestroy--;
		if (contDestroy < 1) {
			instance_destroy();	
		}
	}
}
