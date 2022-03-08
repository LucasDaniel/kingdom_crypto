/// @description Insert description here
// You can write your code in this editor

instance_create_layer(room_width/2,room_height/2,"instances",objBarco);
global.jajogou = true;
contCriaPeixe = 90;
contCriaPeixeMax = contCriaPeixe;

contCriaPirata = 120;
contCriaPirataMax = contCriaPirata;

contCriaPirataPai = 360
contCriaPirataPaiMax = contCriaPirataPai;

global.estadoJogo = "inicioJogo";
global.pause = false;

Obj_AdMob.alarm[0] = 2;
