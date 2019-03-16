//Script para darle color al borde de los articulos y a la letra de de la tematica en funcion de la tematica del post(articulo)

function colorBordePost(){
	
	var post = document.querySelector('.post');
	var tematicaPost = document.querySelector('.tematica');
	var tematicas = ['Curiosidades', 'Humor', 'Reflexion', 'Actualidad'];
	var colorBorde = ['bordeazul', 'bordeamarillo', 'bordemorado', 'borderojo']; //azul, amarillo, morado, rojo
	var colorTematica = ['colorazul', 'coloramarillo', 'colormorado', 'colorrojo']; //azul, amarillo, morado, rojo
	
	if(tematicaPost.innerHTML === tematicas[0]){
		post.className = 'post ' + colorBorde[0]; 
		tematicaPost.className = 'tematica ' + colorTematica[0]; 
	}
	else if(tematicaPost.innerHTML === tematicas[1]){
		post.className = 'post ' + colorBorde[1];
		tematicaPost.className = 'tematica ' + colorTematica[1];
	}
	else if(tematicaPost.innerHTML === tematicas[2]){
		post.className = 'post ' + colorBorde[2];
		tematicaPost.className = 'tematica ' + colorTematica[2];
	}
	else if(tematicaPost.innerHTML === tematicas[3]){
		post.className = 'post ' + colorBorde[3];
		tematicaPost.className = 'tematica ' + colorTematica[3];
	}
}
window.addEventListener('load', colorBordePost);