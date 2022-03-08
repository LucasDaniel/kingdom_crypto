/// @description Insert description here
// You can write your code in this editor

/// @description Insert description here
// You can write your code in this editor
global.jajogou = true;
instance_create_layer(room_width/2,room_height/2,"instances",objCaveman);
instance_create_layer(room_width/2,(room_height/2)-25,"inst_baixo",objPedregulho);

contCriaBat = 180;
contCriaBatMax = contCriaBat;

global.estadoJogo = "inicioJogo";
global.pause = false;

tempoMineirando = 45;
tempoMineirandoMax = tempoMineirando;

Obj_AdMob.alarm[0] = 2;
