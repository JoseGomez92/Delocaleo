//Script para igualar el margen vertical entre los articulos

function eliminaEspaciosVerticalesArticulos(){
	if(window.innerWidth > 1080){
		var articulos = document.getElementsByTagName('article');
		//Variables para calcular los margenes superiores para cada elemento
		var posSup, posInf, altSup, diferenciaPos;
		var margen = 40; //Margen que queremos dejar (en px)
		var margenSup;
		for(var i = 0; i < (articulos.length - 2); i++){
			//Altura Superior                                                    
			altSup = articulos[i].offsetHeight;
			//Posicion borde inferior del contenedor superior
			posSup = altSup + articulos[i].offsetTop;
			//Posicion Inferior
			posInf = articulos[i+2].offsetTop;

			diferenciaPos = posInf - posSup;

			if(diferenciaPos >= 40){
				margenSup = diferenciaPos - margen;
				articulos[i+2].style.marginTop = '-' + margenSup + 'px';
			}
		}
	}
}
window.addEventListener('load', eliminaEspaciosVerticalesArticulos);