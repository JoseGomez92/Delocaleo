/*
 * Script para controlar el registro de los usuarios y los compenentes que intervienen en este proceso.
 */



/*
 * Muestra la modal para que el usuario se registre en el sistema
 */
function habilitarDeshabilitarModalRegistro(){
    let modal = document.getElementById('modalRegistro');
    (modal.style.display == 'none')? modal.style.display = 'flex' : modal.style.display = 'none';
}


/*
 * Verifica si el valor que el usuario ha indicado para los campos son validos
 */
 function validacionesUsuario(){
    //Se oculta el contenedor con el mensaje de registro
    mostrarOcultarMensajeRegistro();
    let c = false;
    let mensaje = '';
    let nombre = document.getElementById('appbundle_usuario_nombre');
    let email = document.getElementById('appbundle_usuario_email');
    let pass = document.getElementById('appbundle_usuario_password');
    let img = document.getElementById('appbundle_usuario_imagen');
    //Se oculta el mensaje de error
    document.getElementById('contenedorMensajeRegistro').style.display = 'none';
    //Se realizan las validaciones
    if(nombre.value.length >= 3){
        if((/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i).test(email.value)){
            if(pass.value.length >= 4){
                if((/\.(jpg|png)$/i).test(img.value)){
                    c = true;
                }
                else{
                    mensaje = 'Debe indicar una imagen JPG o PNG';
                }
            }
            else{
                mensaje = 'La clave debe tener al menos 4 caracteres'
            }
        }
        else{
            mensaje = 'Debe indicar un email válido';
        }
    }
    else{
        mensaje = 'El nombre debe contener al menos 3 caracteres';
    }
    //Si todo es correcto se registra al usuario en caso contrario se muestra el mensaje de error
    (c)? registrarUsuario(nombre, email, pass, img) : mostrarOcultarMensajeRegistro(mensaje);
 }


 /**
  * Envia el formulario para registrar al usuario (mediante AJAX)
  */
 function registrarUsuario(nombre, email, pass, img){
    let form = document.getElementById('formRegistro');
    //Se obtiene el path (ruta) a la que se enviará el formulario
    let pathEnvioForm = form.getAttribute('action');
    let datosForm = new FormData();
    //Se obtiene la imagen que se enviará al usuario
    let imgObj = img.files[0];
    //Se añaden los datos al objeto formulario que se enviará
    datosForm.append('nombre', nombre.value);
    datosForm.append('email', email.value);
    datosForm.append('password', pass.value);
    datosForm.append('imgUsuario', imgObj)
    let ajax = new XMLHttpRequest();
    ajax.open("POST", pathEnvioForm, true);
    //Se envia el objeto formulario creado
    ajax.send(datosForm);
    ajax.addEventListener('load', function(){
        let contenedor = document.querySelector('#contenedorMensajeRegistro');
        let mensaje = document.querySelector('#contenedorMensajeRegistro p');
        let json = JSON.parse(ajax.responseText);
        //Se muestra el contendor con el mensaje
        contenedor.style.display = 'block';
        //Se procesa la respuesta a la peticion
        if(ajax.status >= 200 && ajax.status < 300){
            mensaje.style.color = '#1ff1ae';
            mensaje.innerHTML = '¡Se ha registrado correctamente! Inicie sesion para dejar su primer comentario.';
        }
        else{ //Se indica el mensaje de error
            mensaje.innerHTML = json.message;
            contenedor.sytle.display = 'block';
        }
    });
 }
 

 /*
  * Muestra el elemento para mostrar el mensaje con el contenido que recibe la funcion como parametro
  */
 function mostrarOcultarMensajeRegistro(mensaje){
    let contenedorMensaje = document.getElementById('contenedorMensajeRegistro');
    let parrafoMensaje = document.querySelector('#contenedorMensajeRegistro p');
    if(mensaje != null){ //Se muestra el contenedor con el mensaje de error
        parrafoMensaje.innerHTML = mensaje;
        parrafoMensaje.style.color = 'red';
        contenedorMensaje.style.display = 'block';
    }
    else{ //Se oculta el mensaje de registro
        contenedorMensaje.style.display = 'none';
    }
 }




//Eventos
document.getElementById('submitFormRegistro').addEventListener('click', validacionesUsuario);
(document.getElementById('registroButton') != null)? document.getElementById('registroButton').addEventListener('click', habilitarDeshabilitarModalRegistro) : false;
(document.getElementById('cerrarModalRegistro') != null)? document.getElementById('cerrarModalRegistro').addEventListener('click', habilitarDeshabilitarModalRegistro) : false;
(document.getElementById('submitFormRegistro') != null)? document.getElementById('submitFormRegistro').addEventListener('click', validacionesUsuario) : false;