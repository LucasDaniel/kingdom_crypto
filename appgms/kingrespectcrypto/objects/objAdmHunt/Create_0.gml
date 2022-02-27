/// @description Insert description here
// You can write your code in this editor

instance_create_layer(room_width/2,100,"instances",objAdventure);

contCriaHunt = 200;
contCriaHuntMax = contCriaHunt;

global.estadoJogo = "inicioJogo";
global.pause = false;

contCriaEspinhos = 240;
contCriaEspinhosMax = contCriaEspinhos;

Obj_AdMob.alarm[0] = 2;