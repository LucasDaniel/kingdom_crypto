/// @description Insert description here
// You can write your code in this editor

aux = irandom_range(0,1);

if (aux > 0) aux = 1;
else aux = -1;

x = objBarco.x+(600*aux);
y = objBarco.y;

velo = 3.5*(-aux);

cont = 300;
