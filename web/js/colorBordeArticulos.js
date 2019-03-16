//Script para darle color al borde de los articulos y a la letra de de la tematica en funcion de la tematica del post(articulo)

function colorBordeArticulos(){
	
	var articulos = document.getElementsByTagName('article');
	var tematicaArticulos = document.getElementsByClassName('tematica');
	var tematicas = ['Curiosidades', 'Humor', 'Reflexion', 'Actualidad'];
	var colorBorde = ['bordeazul', 'bordeamarillo', 'bordemorado', 'borderojo']; //azul, amarillo, morado
	var colorTematica = ['colorazul', 'coloramarillo', 'colormorado', 'colorrojo']; //azul, amarillo, morado
	
	for(var i = 0; i < articulos.length; i++){
		if(tematicaArticulos[i].innerHTML === tematicas[0]){ 
			articulos[i].className = 'articulo ' + colorBorde[0]; 
			tematicaArticulos[i].className = 'tematica ' + colorTematica[0];
		}
		else if(tematicaArticulos[i].innerHTML === tematicas[1]){ 
			articulos[i].className = 'articulo ' + colorBorde[1]; 
			tematicaArticulos[i].className = 'tematica ' + colorTematica[1];
		}
		else if(tematicaArticulos[i].innerHTML === tematicas[2]){ 
			articulos[i].className = 'articulo ' + colorBorde[2]; 
			tematicaArticulos[i].className = 'tematica ' + colorTematica[2];
		}
		else if(tematicaArticulos[i].innerHTML === tematicas[3]){
			articulos[i].className = 'articulo ' + colorBorde[3];
			tematicaArticulos[i].className = 'tematica ' + colorTematica[3];
		}
	}
	
}
window.addEventListener('load', colorBordeArticulos);