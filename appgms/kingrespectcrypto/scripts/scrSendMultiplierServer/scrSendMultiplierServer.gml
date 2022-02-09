// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrSendMultiplierServer(){
	
	objAdmWoodGame.estadoJogo = "enviando";
	
	var game = ds_map_create();
	ds_map_add(game,"gamecode",global.gamecode);
	ds_map_add(game,"hash",global.hash);
	ds_map_add(game,"multiplier",(global.multiplier+1));
	var jsonGame = json_encode(game);
	ds_map_destroy(game);
	
	var headerMap = ds_map_create();
	ds_map_add(headerMap,"Content-Type","application/json");
	
	global.post = http_request(global.url+"sendmultiplier.php","POST",headerMap,jsonGame);
	
	ds_map_destroy(headerMap);
	
}