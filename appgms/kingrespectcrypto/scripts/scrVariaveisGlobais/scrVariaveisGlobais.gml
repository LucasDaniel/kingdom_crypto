// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
// Cria as variaveis globais do jogo
function scrVariaveisGlobais(){

global.jajogou = false;

global.hash = "";
global.url = "https://kingrespectcrypto.com/controllerapp/";
global.profissao = "";
global.equipamento = 0;
global.multiplier = 0.00;
global.vidas = 2;
global.livesUpgrade = 0;
global.multiplierUpgrade = 0;
global.pause = false; //Variavel para controlar o fluxo do jogo
global.post = noone;
global.estadoJogo = "";

global.BANNER_ID = "";
global.INTERSTITIAL_ID = "";
global.REWANTED_ID = "";

global.servants = [];
global.quantServants = 0;
	
global.login = "";
global.password = "";

global.CarregouInterstitial = false;

if(os_type == os_android)
{
	global.BANNER_ID = "ca-app-pub-9114414651457385/1981066436"; // o antigo que estava ca-app-pub-9114414651457385/1981066436
	global.INTERSTITIAL_ID = "ca-app-pub-9114414651457385/2436140234"; //"ca-app-pub-3940256099942544/1033173712";
	global.REWANTED_ID = "quando for usar adicionar aqui";//"ca-app-pub-3940256099942544/5224354917";
}

}