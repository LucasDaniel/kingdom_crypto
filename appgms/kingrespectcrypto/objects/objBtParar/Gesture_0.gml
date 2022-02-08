/// @description Insert description here
// You can write your code in this editor

if (objAdmWoodGame.estadoJogo = "jogando") {
	if (!global.pause) {
		global.pause = true;
		var str = "You want stop play? Multiplier: "+string(1+global.multiplier);
		if (show_question(str)){
			scrSendMultiplierServer();
		} else {
			global.pause = false;
		}
	}
}
