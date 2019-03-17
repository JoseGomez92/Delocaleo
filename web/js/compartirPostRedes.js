//Script JS para compartir un Post por la redes sociales

//funcion que recibe el id del elemento que dispara el evento y abre un pop-up en funcion de eso
function enlazaRedes(){

    url = location.href;
    titulo = document.querySelector('.post h3').innerHTML;
    parrafo = document.querySelector('.descripcion-post p').innerHTML + "...";

    facebook = document.getElementById('facebook');
    facebook.href = 'http://facebook.com/sharer.php?u='+ url +'','gplusshare','toolbar=0,status=0,width=548,height=325';

    twitter = document.getElementById('twitter');
    twitter.href = 'https://twitter.com/intent/tweet?url='+url+'&text='+titulo+'&via=DeLocaleo&original_referer='+url+'';

    tumblr = document.getElementById('tumblr');
    tumblr.href = 'http://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=&url='+url+'&posttype=link&title='+titulo+'&caption='+parrafo+'&content='+url+'','gplusshare','toolbar=0,status=0,width=620,height=600';

    whatsapp = document.getElementById('whatsapp');
    whatsapp.href = "whatsapp://send?text= " + url;
}

//Funcion para ocultar whatsapp en dispositivos que no sean moviles
function ocultaWhatsapp(){
    whatsapp = document.getElementById('whatsapp');
    if(window.innerWidth > 480){
        whatsapp.style.display = 'none';
    }
}

window.addEventListener('load', function(){
    enlazaRedes();
    ocultaWhatsapp();
});
