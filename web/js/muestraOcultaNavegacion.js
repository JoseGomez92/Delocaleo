//Script para mostrar u ocultar el menu de navegacion

function muestraOcultaNavegacion(){
	
	//Elemento menu
	var menu = document.getElementById('navegacion');
	
	//Mostrar menu
	var botonMostrarMenu = document.getElementById('expandeMenu');
	botonMostrarMenu.addEventListener('click', function(){
		if(menu.className === 'navegacion ocultar'){ menu.className = 'navegacion'; }
	});
	
	//Ocultar menu
	var cerrar = document.getElementById('cerrar');
	cerrar.addEventListener('click', function(){
		if(menu.className === 'navegacion'){ menu.className = 'navegacion ocultar'; }
	});	
}

window.addEventListener('load', muestraOcultaNavegacion);