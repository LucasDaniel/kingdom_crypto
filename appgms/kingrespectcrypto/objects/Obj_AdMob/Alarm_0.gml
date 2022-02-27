/// @description Insert description here
// You can write your code in this editor

//Inicia o interstitial
//AdMob_Initialize();
show_debug_message("-------------------");
show_debug_message("Alarm0 ADMOB");
show_debug_message(string(global.CarregouInterstitial));
if (global.CarregouInterstitial) {
	show_debug_message("vai iniciar o interstittial");
	//AdMob_Interstitial_Init(global.INTERSTITIAL_ID);
	AdMob_Interstitial_Load();
} else {
	show_debug_message("ERRO AO INICIAR O interstittial");
}
show_debug_message("-------------------");
