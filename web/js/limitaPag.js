//Funcion para limitar la pagina maxima de busqueda(si se introduce una pagina mayor, automaticamente rescribe a la pagina maxima)

function limitaPagina(){
	
	pagina = document.getElementById('pagina');
	//Convertimos a number para poder evaluar si es mayor o menor como numero y no como string
	max = +(pagina.placeholder.substring(4));
	pagina.addEventListener('change', function(){
		if(+(pagina.value) > max){
			pagina.value = max;
		}
	});
}

window.addEventListener('load', limitaPagina);