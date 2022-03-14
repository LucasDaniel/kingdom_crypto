/// @description Insert description here
// You can write your code in this editor

draw_sprite(sprServantWork,1,room_width/2,50);

if (scrVerifyQuantServants()) {
	draw_text_color(50,100,"You don't have any servant working",c_white,c_white,c_white,c_white,1);
	draw_text_color(50,150,"Go to http://kingrespectcrypto.com",c_white,c_white,c_white,c_white,1);
	draw_text_color(50,200,"put some servants to work and back here.",c_white,c_white,c_white,c_white,1);
	draw_sprite(sprTraining,-1,room_width/2,275);
}
