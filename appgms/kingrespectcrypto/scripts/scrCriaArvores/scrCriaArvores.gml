// Script assets have changed for v2.3.0 see
// https://help.yoyogames.com/hc/en-us/articles/360005277377 for more information
function scrCriaArvores(qarvore){

var vaiCriar = true;

if (contArvores < (3*5)) {
	while(vaiCriar) {
		for (i = 0; i < 3; i++) {
			for (j = 0; j < 5; j++) {
				if (arvores[i][j] == 0) {
					if (irandom_range(0,100) > 70) {
						arvores[i][j] = 1;
						contArvores++;
						if (contArvores > qarvore) {
							i = 3;
							j = 5;
							vaiCriar = false;
						}
					}
				}
			}	
		}
	}
}

}