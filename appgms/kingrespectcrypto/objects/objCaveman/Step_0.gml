/// @description Insert description here
// You can write your code in this editor

if (posicao = "direita") {
	if (x < (xini+48)) x += 48;
	image_index = 2;
	posicao = "parou";
} else if (posicao = "esquerda") {
	if (x > (xini-48)) x -= 48;
	image_index = 3;
	posicao = "parou";
} else if (posicao = "cima") {
	if (y > (yini-48)) y -= 48;
	image_index = 1;
	posicao = "parou";
} else if (posicao = "baixo") {
	if (y < (yini+48)) y += 48;
	image_index = 0;
	posicao = "parou";
}

if (x = xini && y = yini) {
	image_index = 1;
	posicao = "centro";
}
