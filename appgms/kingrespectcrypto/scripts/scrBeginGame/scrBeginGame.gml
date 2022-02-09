// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrBeginGame(game){

	if (game == "wood") {
		room_goto(room_wood);
	} else if (game == "fish") {
		show_debug_message("Jogo de fish");	//Parei aqui - Fazer o jogo do peixe
	} else if (game == "stoneiron") {
		show_debug_message("Jogo de stone iron");	
	} else if (game == "huntmonsters") {
		show_debug_message("Jogo de hunt monsters");	
	} else {
		scrErrorClose("Error game play work at");
	}

}