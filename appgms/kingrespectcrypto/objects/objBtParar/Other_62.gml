/// @description Insert description here
// You can write your code in this editor

if (scrVerifyQuantServants()) {show_debug_message("4");
	room_goto(room_logado);
} else {show_debug_message("5");
	scrAsyncPostMultiplier();	
}
