//Script para igualar el margen vertical entre los articulos de la pagina para mostrar los resultados de busqueda

function eliminaEspaciosVerticalesArticulos(){
	if(window.innerWidth >= 1450){
		//Padres de los articulos los cuales nos sirven de referencia para el bucle
		var divsPadre = document.querySelectorAll('div[class^="resultados-por"]');
		var articulos = document.getElementsByClassName('articulo');
		//Variables para calcular y añadir el margen superior necesario
		var posSup, posInf, altSup, diferenciaPos;
		var margen = 40; //Margen que queremos dejar (en px)
		var margenSup;
		//Variable para tener la referencia dentro del bucle para aplicar los maragenes alos articulos correspondientes
		var ultimoHijo = 0;


		for(var z = 0; z < divsPadre.length; z++){

			cantidadArticulosHijo = divsPadre[z].children.length;

			for(var i = ultimoHijo; i < cantidadArticulosHijo; i++){
				if(i + 2 < cantidadArticulosHijo){
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
				ultimoHijo = i;
			}	
		}
	}	
}
window.addEventListener('load', eliminaEspaciosVerticalesArticulos);