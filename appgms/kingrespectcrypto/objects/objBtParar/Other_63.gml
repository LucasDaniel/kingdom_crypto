/// @description Insert description here
// You can write your code in this editor
	
var i_d = ds_map_find_value(async_load, "id");
if (i_d = pararJogar) {
	if ds_map_find_value(async_load, "status") {
		if (scrVerifyQuantServants()) {show_debug_message("0");
			room_goto(room_logado);
		} else {show_debug_message("1");
			scrSendMultiplierServer();	
		}
	} else {
		global.pause = false;
	}
} else if (i_d = continuarJogar) {
	if ds_map_find_value(async_load, "status") {show_debug_message("2");
        room_goto(room_logado);
    } else {show_debug_message("3");
		game_end();
	}
}
