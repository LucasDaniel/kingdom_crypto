// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrGameCodeAndPassword(){

gameCode = get_string("Put game code you see in your character working in kingrespectcrypto.com","");
passwordGameCode = get_string("Put your password (for your security)","");

scrVerifyGameCodePassword(gameCode,passwordGameCode);

}