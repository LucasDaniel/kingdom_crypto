// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrAsyncPostLogin() {
	
	var carregoucodegame = 0;
	global.profissao = "";
	global.equipamento = 0;
	global.multiplier = 0.00;
	global.vidas = 0;
	
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
						show_message_async(msg);
						if (page == "login") {
							carregoucodegame = 0;
							objAdm.alarm[1] = 10;
						} else if (page == "gamecode") {
							//Enconrei um jogo que dê pra jogar
							if (ds_map_exists(map,"profissao")) {
								global.profissao = map[?"profissao"];
								if (ds_map_exists(map,"equipamento")) {
									global.equipamento = map[?"equipamento"];
									if (ds_map_exists(map,"multiplier")) {
										global.multiplier = map[?"multiplier"];
										if (ds_map_exists(map,"lives")) {
											global.vidas = map[?"lives"];
											if (ds_map_exists(map,"work_at")) {
												var workat = map[?"work_at"];
												carregoucodegame = 1;
											} else {
												scrErrorClose("Error work_at");	
											}
										} else {
											scrErrorClose("Error lives");	
										}
									} else {
										scrErrorClose("Error multiplier");	
									}
								} else {
									scrErrorClose("Error equipamento");	
								}
							} else {
								scrErrorClose("Error profissao");	
							}
							show_debug_message(carregoucodegame);
							if (carregoucodegame == 1) {
								show_debug_message(workat);
								scrBeginGame(workat);
							} else {
								scrErrorClose("Error game MASTER!!!");
							}
						}
					} else {
						show_message_async(msg);
						if (page == "login") { 
							objAdm.alarm[0] = 10;
						} else if (page == "gamecode") {
							carregoucodegame = 0;
							objAdm.alarm[1] = 10;
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