// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrLogin(usuario,password){
	
	var login = ds_map_create();
	ds_map_add(login,"usuario",usuario);
	ds_map_add(login,"password",password);
	var json = json_encode(login);
	ds_map_destroy(login);
	
	var headerMap = ds_map_create();
	ds_map_add(headerMap,"Content-Type","application/json");
	
	global.post = http_request(global.url+"login.php","POST",headerMap,json);
	
	ds_map_destroy(headerMap);
	
}