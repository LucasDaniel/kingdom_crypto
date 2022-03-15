/// @description Insert description here
// You can write your code in this editor

draw_self();

if (!scrVerifyQuantServants()) {
	if (_profissao = "lenhador") {
		draw_sprite(sprHeroi,-1,x+108,y+121);
	} else if (_profissao = "minerador") {
		draw_sprite(sprCaveman,-1,x+145,y+160);
	} else if (_profissao = "pescador") {
		draw_sprite(sprPescador,-1,x+118,y+65);
	} else { //aventureiro
		draw_sprite(sprAdventure,-1,x+150,y+163);
	}

	draw_text_color(x+5,y+5,"Multiplier: "+string(_multiplier),c_white,c_white,c_white,c_white,1);
	draw_text_color(x+5,y+25,"Lives: "+string(_lives),c_white,c_white,c_white,c_white,1);
}
//draw_text_color(x,y,);

/*
__id = 0;
_id_user = 0;
_profissao = "";
_app_code = "";
_multiplier = 1;
_lives = 2;
_work_at = "";
*/