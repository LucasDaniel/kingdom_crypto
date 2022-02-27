/// @description Insert description here
// You can write your code in this editor

if (global.estadoJogo = "jogando") {
	if (!global.pause) {
		global.pause = true;
		var str = "You want stop play? Multiplier: "+string(global.multiplier);
		pararJogar = show_question_async(str); //Parei aqui - colocar o show_question_async
	}
}
