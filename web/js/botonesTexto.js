
	//Script para insertar etiquetas html en funcion de lo que se desee insertar al post(tuits, videos, etc).

function iniciar(){

	//Variables disponibles globalmente
	var texto = document.getElementById('descripcion');
	var arrayTexto = new Array();
	contador = 0;
	
	
	function insertaEtiqueta(boton){
		
		var idBoton = boton.id;
		var inicio = texto.selectionStart;
		var fin = texto.selectionEnd;
		
		
		//Guardamos el texto antes de modificar en un array
		arrayTexto[contador] = texto.value;
		contador ++;
		
		//Cortamos el texto en 3 partes
		var principio = texto.value.slice(0, inicio);
		var medio = texto.value.slice(inicio, fin);
		var final = texto.value.slice(fin);
		
		//Concatenamos la etiqueta correspondiente al texto seleccionado(medio)
		switch(idBoton){
			case 'cursiva':
				medio = '<cite>' + medio + '</cite>';
			break;
			case 'negrita':
				medio = '<strong>' + medio + '</strong>';
			break;
			case 'imagen':
				medio = '<img src="' + medio + '" alt="imagen-post">';
				break;
			case 'tuit':
				medio = '<center class="tuit">' + medio + '</center>';
			break;
			case 'video':
				medio = '<div class="video">' + medio + '</div>';
			break;
		}
		
		//Unimos todas las partes para obtener el texto ya con las etiquetas insertadas
		texto.value = principio + medio + final;
	
	}

	
	//Funcion para deshacer las etiquetas introducidas
	function recuperarTexto(indicador){
		if(contador > 0){
			if(indicador === 'atras'){ 
				contador --;
				texto.value = arrayTexto[contador];
			}
		}
	}
		
	//Añadimos los eventos
	document.getElementById('deshacer').addEventListener('click', function(){
		recuperarTexto('atras');
	});
	var botones = document.querySelectorAll('.boton');
	for(var i = 0; i < botones.length; i++){
		botones[i].addEventListener('click', function(){
			insertaEtiqueta(this);
		});
	}
	
}

window.addEventListener('load', iniciar);