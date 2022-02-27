/// @description Insert description here
// You can write your code in this editor
	
var i_d = ds_map_find_value(async_load, "id");
if (i_d = pararJogar) {
    if ds_map_find_value(async_load, "status") {
        scrSendMultiplierServer();
    } else {
		global.pause = false;
	}
} else if (i_d = continuarJogar) {
	if ds_map_find_value(async_load, "status") {
        room_goto(room_start);
    } else {
		game_end();
	}
}
