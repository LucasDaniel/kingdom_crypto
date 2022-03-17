/// @description Insert description here
// You can write your code in this editor

pageAtual = 1;
maxPages = 1;

instance_create_layer(70,880,"instances",objBtLogout);

if (scrVerifyQuantServants()) {
	maxPages = 1;
	__obj = instance_create_layer(10,330,"inst_baixo",objBtWorkServant);
	__obj.sprite_index = sprFaseFloresta;
	__obj = instance_create_layer(280,330,"inst_baixo",objBtWorkServant);
	__obj.sprite_index = sprFaseCaverna;
	__obj = instance_create_layer(10,560,"inst_baixo",objBtWorkServant);
	__obj.sprite_index = sprFaseLava;
	__obj = instance_create_layer(280,560,"inst_baixo",objBtWorkServant);
	__obj.sprite_index = sprFasePescar;
} else {
	
	//instance_create_layer(220,880,"instances",objBtEsqMenu);
	//instance_create_layer(370,880,"instances",objBtDirMenu);
	
	maxPages = round(global.quantServants/6);
	
	var j = 0;
	var __y = 0;
	var auxWork = "";
	
	for (i = 0; i < 6; i++) {
		if (i < global.quantServants) {
				  if (global.servants[i,6] = "wood"        )   auxWork = sprFaseFloresta;
			else  if (global.servants[i,6] = "fish"		   )   auxWork = sprFasePescar;
			else  if (global.servants[i,6] = "stoneiron"   )   auxWork = sprFaseCaverna;
			else/*if (global.servants[i,6] = "huntmonsters")*/ auxWork = sprFaseLava;
		
			__obj = instance_create_layer(10+(280*j),100+(230*__y),"inst_baixo",objBtWorkServant);
			__obj.pos_i = i;
			__obj.__id = global.servants[i,0];
			__obj._id_user = global.servants[i,1];
			__obj._profissao = global.servants[i,2];
			__obj._app_code = global.servants[i,3];
			__obj._multiplier = global.servants[i,4];
			__obj._lives = global.servants[i,5];
			__obj._work_at = global.servants[i,6];
			__obj.sprite_index = auxWork;
		
			j++;
			if (j > 1) {
				j = 0;
				__y++;
			}
		}
	}
}
