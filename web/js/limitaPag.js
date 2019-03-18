//Funcion para limitar la pagina maxima de busqueda(si se introduce una pagina mayor, automaticamente rescribe a la pagina maxima)

function limitaPagina(){

	//Se obtiene el valor de pagina indicado
	pagina = document.getElementById('pagina');
	//Convertimos a number para poder evaluar si es mayor o menor como numero y no como string
	max = +(pagina.placeholder.substring(4));
	pagina.addEventListener('change', function(){
		//Se verifica que se haya indicado un entero
		if(isNaN(parseInt(pagina.value))){
			pagina.value = 1;
		}
		else if(pagina.value > max){
			pagina.value = max;
		}
		else if(pagina.value < 1){
			pagina.value = 1;
		}
	});
}

window.addEventListener('load', limitaPagina);