/// @description Insert description here
// You can write your code in this editor

global.multiplier = real(global.multiplier)+0.05;

if (global.multiplier > 9.95) {
	scrSendMultiplierServer();
}

instance_destroy();
