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

			if (distance_to_point(posxfinal,posyfinal) > 1) image_angle = point_direction(x, y, posxfinal, posyfinal);
		
			if (difx > 0) {
				velx += accx;
				if (velx > velxmax) velx = velxmax;
			} else if (difx < 0) {
				velx -= accx;
				if (velx < -velxmax) velx = -velxmax;
			} else {
				velx = 0;
			}

			if (dify > 0) {
				vely += accy;
				if (vely > velymax) vely = velymax;
			} else if (dify < 0) {
				vely -= accy;
				if (vely < -velymax) vely = -velymax;
			} else {
				vely = 0;
			}
				
			/*
			if (difx > 0) {
				if (difx < 10) velx = -1;
			} else if (difx < 0) {
				if (difx > -10) velx = 1;
			}
			if (difx > 0) {
				if (dify < 10) vely = -1;
			} else if (difx < 0) {
				if (dify > -10) vely = 1;
			}
			*/
				
			if (difx < 2 && difx > -2) velx = 0;
			if (dify < 2 && dify > -2) vely = 0;
			//Quanto menor a diferença entre os numeros, menos vai se mover
	
			show_debug_message("--------");
			show_debug_message("velx = "+string(velx));
			show_debug_message("vely = "+string(vely));
	
			x += velx;
			y += vely;
			
		}
	
	}

}