/// @description Insert description here
// You can write your code in this editor

if (!global.pause) {
	global.pause = true;
	global.vidas--;
	if (global.vidas > 0) {
		show_message("The bee touchs you. Lives left: "+string(global.vidas));
		room_restart();
	} else {
		show_message("You lost all your lives!");
		game_end();
	}
}
