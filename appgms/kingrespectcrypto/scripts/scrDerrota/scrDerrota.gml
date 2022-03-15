// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrDerrota(){

if (!global.pause) {
	global.pause = true;
	global.vidas--;
	if (global.vidas > 0) {
		show_message_async("You lost one live. Lives left: "+string(global.vidas));
		if(!global.multiplierUpgrade) global.multiplier = 1.00;
		room_restart();
	} else {
		show_message_async("You lost all your lives!");
		global.multiplier = 1.00;
		if (scrVerifyQuantServants()) {
			room_goto(room_start);
		} else {
			scrSendMultiplierServer();	
		}
	}
}

}