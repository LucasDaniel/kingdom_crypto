/// @description Insert description here
// You can write your code in this editor
	
var i_d = ds_map_find_value(async_load, "id");
if (i_d = pararJogar) {
	if ds_map_find_value(async_load, "status") {
		if (scrVerifyQuantServants()) {
			room_goto(room_logado);
		} else {
			scrSendMultiplierServer();	
		}
	} else {
		global.pause = false;
	}
} else if (i_d = continuarJogar) {
	if ds_map_find_value(async_load, "status") {
		if (global.servantPosI != noone) {
			global.servants[global.servantPosI,4] = global.multiplier;
			global.servants[global.servantPosI,5] = 0;
		}
        room_goto(room_logado);
    } else {
		game_end();
	}
}
