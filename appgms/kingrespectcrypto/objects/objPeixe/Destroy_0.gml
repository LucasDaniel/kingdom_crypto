/// @description Insert description here
// You can write your code in this editor

global.multiplier = real(global.multiplier)+0.17;

if (global.multiplier > 9.95) {
	scrSendMultiplierServer();	
}
