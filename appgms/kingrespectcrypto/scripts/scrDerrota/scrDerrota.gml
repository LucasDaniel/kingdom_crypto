// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrDerrota(){

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

}