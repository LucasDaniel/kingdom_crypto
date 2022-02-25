/// @description Insert description here
// You can write your code in this editor

var i_d = ds_map_find_value (async_load,"id");
if (i_d = msg1) {
    if ds_map_find_value (async_load,"status") {
        //alarm[0] = 10;
    }
} else if (i_d = msg2) {
    if ds_map_find_value (async_load,"status") {
        alarm[0] = 10;
    }
} else if (i_d = msgLogin) {
    if ds_map_find_value(async_load, "status") {
        if (ds_map_find_value(async_load, "result") != "") {
            usuario = ds_map_find_value(async_load, "result");
        } else usuario = "";
    } else usuario = "";
} else if (i_d = msgPassword) {
	if ds_map_find_value(async_load, "status") {
        if (ds_map_find_value(async_load, "result") != "") {
            password = ds_map_find_value(async_load, "result");
			scrLogin(usuario,password);
        } else alarm[0] = 1;
    } else alarm[0] = 1;
} else if (i_d = gamecode) {
	if ds_map_find_value(async_load, "status") {
        if (ds_map_find_value(async_load, "result") != "") {
            global.gamecode = ds_map_find_value(async_load, "result");
        } else global.gamecode = "0";
    } else global.gamecode = "0";
} else if (i_d = passwordGameCode) {
	if ds_map_find_value(async_load, "status") {
        if (ds_map_find_value(async_load, "result") != "") {
            passwordGameCode = ds_map_find_value(async_load, "result");
			scrVerifyGameCodePassword(passwordGameCode);
        } else alarm[1] = 1;
    } else alarm[1] = 1;
}


