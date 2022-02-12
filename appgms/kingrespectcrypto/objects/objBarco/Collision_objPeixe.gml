/// @description Insert description here
// You can write your code in this editor

tempoPesca--;

if (tempoPesca < 1) {

tempoPesca = tempoPescaMax;
_objAnimPontos = instance_create_layer(x,y,"instance_pirata",objAnimPontos);
_objAnimPontos.pontos = "0.05";
instance_destroy(other);

}
