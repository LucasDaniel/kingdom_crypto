// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrAsyncPostLogin() {
	
	var carregoucodegame = 0;
	var i = 0;
	var aux = "";
	global.profissao = "";
	global.equipamento = 0;
	global.multiplier = 0.00;
	global.vidas = 0;
	global.servants = [];
	global.quantServants = 0;
	
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
							show_debug_message("hash 1");
							show_debug_message(global.hash);
						} else {
							scrErrorClose("Error hash");	
						}
					} else {
						scrErrorClose("Error msg");
					}
					
					if (success) {
						show_message_async(msg);
						show_debug_message(map);
						if (page == "login") {
							if (ds_map_exists(map,"multiplier_upgrade")) {
								global.multiplierUpgrade = map[?"multiplier_upgrade"];
								show_debug_message("multiplierUpgrade = "+string(global.multiplierUpgrade));
								if (ds_map_exists(map,"lives_upgrade")) {
									global.livesUpgrade = map[?"lives_upgrade"];
									show_debug_message("livesUpgrade = "+string(global.livesUpgrade));
								}
							}
							if (ds_map_exists(map,"quant_servants")) {
								global.quantServants = map[?"quant_servants"];
								show_debug_message("quant_servants = "+string(global.quantServants));
								if (global.quantServants > 0) {
									for (i = 0; i < global.quantServants; i++) {
										aux = "servant"+string(i+1);
										if (ds_map_exists(map,aux+"_id")) {
											global.servants[i,0] = map[?""+aux+"_id"];
											global.servants[i,1] = map[?""+aux+"_id_user"];
											global.servants[i,2] = map[?""+aux+"_profissao"];
											global.servants[i,3] = map[?""+aux+"_app_code"];
											global.servants[i,4] = map[?""+aux+"_multiplier"];
											global.servants[i,5] = map[?""+aux+"_lives"];
											global.servants[i,6] = map[?""+aux+"_work_at"];
											show_debug_message("servant "+string(i));
											show_debug_message(global.servants);
										}
									}
								}
							}
							carregoucodegame = 0;
							
							/*
							gamecode = get_string_async("Put game code you see in your character working in kingrespectcrypto.com","");
							passwordGameCode = get_string_async("Put your password (for your security)","");
							*/
							//Vai mostrar os 
							objAdm.alarm[2] = 2;
							
							//objAdm.alarm[1] = 10;
						} else if (page == "gamecode") {
							//Encontrei um jogo que dê pra jogar
							if (ds_map_exists(map,"profissao")) {
								global.profissao = map[?"profissao"];
								if (ds_map_exists(map,"equipamento")) {
									global.equipamento = map[?"equipamento"];
									if (ds_map_exists(map,"multiplier")) {
										global.multiplier = map[?"multiplier"];
										if (ds_map_exists(map,"lives")) {
											global.vidas = map[?"lives"];
											show_debug_message("--------");
											show_debug_message("vidas = "+string(global.vidas));
											show_debug_message("livesUpgrade = "+string(global.livesUpgrade));
											show_debug_message("--------");
											if (global.livesUpgrade) global.vidas = 3;
											show_debug_message("vidas = "+string(global.vidas));
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