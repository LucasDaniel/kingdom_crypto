/// @description Insert description here
// You can write your code in this editor

x = room_width/2;
y = room_height/2;

if (room == room_cave) sprite_index = sprTutorialCaverna;
else if (room == room_fish) sprite_index = sprTutorialPescar;
else if (room == room_hunt) sprite_index = sprTutorialLava;
else sprite_index = sprTutorialFloresta;
