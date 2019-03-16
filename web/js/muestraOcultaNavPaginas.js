//Script para ocultar o motrar el formulario para ir a una pagina determinada

function muestraOcultaNavPaginas(){
	
	//Variables
	var numeroPagina = document.getElementById('numeroPagina');
	var buscarPagina = document.getElementById('buscarPagina');
	
	//Eventos
	numeroPagina.addEventListener('click', function(){
		if(buscarPagina.className === 'buscar-pagina ocultar'){
			buscarPagina.className = 'buscar-pagina';
		}
	});
	
	window.addEventListener('dblclick', function(){
		buscarPagina.className = 'buscar-pagina ocultar';
	});
	
}
window.addEventListener('load', muestraOcultaNavPaginas);