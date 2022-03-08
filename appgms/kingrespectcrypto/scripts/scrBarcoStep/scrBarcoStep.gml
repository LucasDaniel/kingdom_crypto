// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrBarcoStep(){

	if (!global.pause) {
		
		if (global.estadoJogo = "inicioJogo") { 
			global.estadoJogo = "jogando";
		}
		
		if (global.estadoJogo = "jogando") {
		
			difx = posxfinal - x;
			dify = posyfinal - y;

			if (difx > 0) {
				velx += accx;
				image_index = 2;
				if (velx > velxmax) velx = velxmax;
			} else if (difx < 0) {
				velx -= accx;
				image_index = 3;
				if (velx < -velxmax) velx = -velxmax;
			} else {
				velx = 0;
			}

			if (dify > 0) {
				vely += accy;
				image_index = 0;
				if (vely > velymax) vely = velymax;
			} else if (dify < 0) {
				vely -= accy;
				image_index = 1;
				if (vely < -velymax) vely = -velymax;
			} else {
				vely = 0;
			}
				
			if (difx < 2 && difx > -2) velx = 0;
			if (dify < 2 && dify > -2) vely = 0;
			//Quanto menor a diferença entre os numeros, menos vai se mover
			
			x += velx;
			y += vely;
			
		}
	
	}

}