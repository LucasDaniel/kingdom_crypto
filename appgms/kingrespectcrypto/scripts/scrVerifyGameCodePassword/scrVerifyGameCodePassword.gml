// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrVerifyGameCodePassword(gameCode,passwordGameCode){

	var game = ds_map_create();
	ds_map_add(game,"gamecode",gameCode);
	ds_map_add(game,"hash",global.hash);
	ds_map_add(game,"passwordgamecode",passwordGameCode);
	var jsonGame = json_encode(game);
	ds_map_destroy(game);
	
	var headerMap = ds_map_create();
	ds_map_add(headerMap,"Content-Type","application/json");
	
	global.post = http_request(global.url+"gamecode.php","POST",headerMap,jsonGame);
	
	ds_map_destroy(headerMap);

}