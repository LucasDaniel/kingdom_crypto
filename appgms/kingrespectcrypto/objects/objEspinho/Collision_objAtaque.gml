/// @description Insert description here
// You can write your code in this editor
vida -= 1;
instance_create_layer(x,y,"inst_cima",objSangue);
if (vida < 1) instance_destroy();