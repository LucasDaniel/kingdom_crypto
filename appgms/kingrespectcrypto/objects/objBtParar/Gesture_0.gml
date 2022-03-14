/// @description Insert description here
// You can write your code in this editor

if (global.estadoJogo = "jogando") {
	if (!global.pause) {
		global.pause = true;
		var str = "You want stop play? Multiplier: "+string(global.multiplier);
		if (scrVerifyQuantServants()) str = "You want stop play? Training...";
		pararJogar = show_question_async(str);
	}
}
