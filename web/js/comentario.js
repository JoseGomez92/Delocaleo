/*
 * Script para el control de los comentarios en la vista del post
 */

var path = window.location.href; //Localizacion del archivo PHP en el servidor


        
/*
 * Muestra la modal del login si esta no ha sido mostrada ya.
 */
function habilitarDeshabilitarModalLogin(){
    let modal = document.getElementById('modalLogin');
    (modal.style.display == 'none')? modal.style.display = 'flex' : modal.style.display = 'none';
}


/*
 * Realiza una peticion AJAX para loguear al usuario 
 */
function loguearUsuario(){
    var pathLogin = path.replace(/post(.+)/, 'login'); //Se forma la ruta a la que se realizará la peticion
    //Se forman los parametros que se enviarán en la peticion
    let user = document.querySelector('#user').value;
    let pass = document.querySelector('#pass').value;
    var parametros = 'user=' + user + '&pass=' + pass;
    var ajax = new XMLHttpRequest();
    ajax.open('POST', pathLogin, true);//Peticion asincrona
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
    ajax.send(parametros); //Parametros para la peticion
    ajax.addEventListener('load', function(){
        let contenedor = document.querySelector('#contenedorMensajeLogin');
        let mensajeAviso = document.querySelector('#contenedorMensajeLogin p');
        let json = JSON.parse(ajax.responseText);
        if(ajax.status >= 200 && ajax.status < 300){
            mensajeAviso.style.color = '#1ff1ae';
            mensajeAviso.innerHTML = 'Se ha registrado correctamente';
            window.setTimeout(location.reload(), 3000); //Se recarga la pagina para cargar los datos del usuario (nombre, imagen, etc).
        }
        else{ //Se indica el mensaje de error
            contenedor.style.display = 'block';
            mensajeAviso.innerHTML = json.message;
            contenedor.sytle.display = 'block';
        }
    });
    
}


/*
 * Envia el comentario si este es valido (se dan las condiciones necesarias) 
 */
function enviarComentario(){
    let comentario = document.getElementById('comentarioText').value;
    //Se verifica que el contenido del comentario sea apropiado
    if(comentario.length >= 15 && (comentario.split(' ')).length > 2){
        //Se envia el formulario para publicar el comentario
        document.getElementById('formComentario').submit();
    }
    else{
        alert('Su comentario debe contener al menos 3 palabras y 15 letras.');
    }
}


/*
 * Realiza scroll hasta el comentario cuyo ID se corresponda con el ID de la URL
 */
function realizarScrollComentario(){
    let idComentario = path.substring(path.lastIndexOf('/') + 1);
    let comentario =  document.querySelector('#comentario-' + idComentario);
    if(comentario != null){
        let posYComentario = comentario.getBoundingClientRect().top;
        let contScrollY = 0;
        var inter = window.setInterval(function(){ //Se realiza scroll hasta el comentario
            contScrollY += 5;
            window.scrollBy(0, contScrollY);
            if(window.scrollY >= (posYComentario - comentario.clientHeight) ||  window.scrollY >= (document.body.scrollHeight - screen.height)){
                clearInterval(inter);
            }
        }, 10);
    }
}


/**
 * Cambia el tipo de input entre text y password para mostrar u ocultar la contraseña del usuario
 */
function mostrarOcultarClave(elem){
    let inputPass = document.getElementById('pass');
    (elem.checked)? inputPass.type = 'text' : inputPass.type = 'password';
}



//Eventos
(document.getElementById('loginButton') != null)? document.getElementById('loginButton').addEventListener('click', habilitarDeshabilitarModalLogin) : false;
(document.getElementById('submitFormLogin') != null)? document.getElementById('submitFormLogin').addEventListener('click', loguearUsuario) : false;
(document.getElementById('cerrarModalLogin') != null)? document.getElementById('cerrarModalLogin').addEventListener('click', habilitarDeshabilitarModalLogin) : false;
(document.getElementById('mostrarClave') != null)? document.getElementById('mostrarClave').addEventListener('change', function(){ mostrarOcultarClave(this) }) : false;
(document.getElementById('enviarFormComentario'))? document.getElementById('enviarFormComentario').addEventListener('click', enviarComentario) : false;
window.addEventListener('load', function(){
    realizarScrollComentario();
});