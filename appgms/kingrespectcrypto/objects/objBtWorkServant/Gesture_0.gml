/// @description Insert description here
// You can write your code in this editor

if (scrVerifyQuantServants()) {
	global.vidas = 2;
	global.multiplier = 1;
	global.gamecode = "";
} else {
	global.vidas = _lives;
	global.multiplier = _multiplier;
	global.gamecode = _app_code;
	/*
	Parei aqui - Quando finalizar o jogo, vai pegar o gamecode
				 buscar dentro do array global.servants
				 e modificar o lives e multiplier dele
				 para a quantidade que ficou no jogo
				 ao tocar para jogar, verifica se as vidas
				 são maiores que 0, se forem, então não vai
				 iniciar o jogo
				 
				 depois disso
				 
				 fazer um botão pra navegar entre o jogo
				 que vale ponto e o treino
				 
				 testar tambem caso tenha 100 trabalhadores
				 precisa deixar o aplicativo pra colocar todos
				 
				 o botão de navegação precisa ser dinamico
				 não importando a quantidade de trabalhadores
				 no jogo, sempre vai conseguir mostrar todos
	*/
}

if (sprite_index = sprFaseFloresta) {
	room_goto(room_wood);
} else if (sprite_index = sprFaseCaverna) {
	room_goto(room_cave);
} else if (sprite_index = sprFaseLava) {
	room_goto(room_hunt);
} else if (sprite_index = sprFasePescar) {
	room_goto(room_fish);
} else {
	show_message_async("CRITICAL ERROR");
	game_end();	
}
