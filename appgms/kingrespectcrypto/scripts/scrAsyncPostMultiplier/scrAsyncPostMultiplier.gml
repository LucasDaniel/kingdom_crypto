// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrAsyncPostMultiplier() {

if (ds_map_find_value(async_load, "id") == global.post) {
		
	if (ds_map_find_value(async_load, "status") == 0) {
			
	    r_str = ds_map_find_value(async_load, "result");
		var json = async_load[? "result"];
		show_debug_message(json);
		var map = json_decode(json);
			
		if (map == -1) {
			scrErrorClose("Error 1");
		}
			
		if (ds_map_exists(map,"page")) {
			var page = map[?"page"];			
			if (ds_map_exists(map,"success")) {
				var success = map[?"success"];
				if (ds_map_exists(map,"msg")) {
					var msg = map[?"msg"];
					if (ds_map_exists(map,"hash")) {
						global.hash = map[?"hash"];
						show_debug_message(global.hash);
					} else {
						scrErrorClose("Error hash");	
					}
				} else {
					scrErrorClose("Error msg");
				}
					
				if (success) {
					if (page == "multiplier") {
						var str = "Continuos playing?";
						if (show_question(str)) {
							global.jajogou = 1;
							room_goto(room_start);
						} else {
							game_end();
						}
					} else if (page == "gamecode") {
						
					}
				} else {
					if (page == "multiplier") { 
						scrErrorClose(msg);
					} else {
							
					}
				}
			} else {
				scrErrorClose("Error success");
			}
				
		} else {
			scrErrorClose("Error page");
		}
			
	} else {
			
	    r_str = "null";
		show_debug_message(r_str);
			
	}
}

}