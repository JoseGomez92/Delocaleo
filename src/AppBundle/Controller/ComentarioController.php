<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Comentario;
use AppBundle\Entity\Usuario;

class ComentarioController extends AbstractController{

    /**
     * @Route("/comentario/crear/{slug}", name="create_comment")
     */
    public function publicCommentAction(Request $request, $slug){
        $em = $this->getDoctrine()->getEntityManager();
        $session = $request->getSession();
        $usuario = $session->get('usuario');
        //Se recupera el usuario de BBDD
        $usuario = $em->getRepository('AppBundle:Usuario')->findOneById($usuario->getId());
        //Se recupera el texto del comentario
        $textoComentario = $request->get('texto_comentario');
        //Se recupera el post
        $post = $em->getRepository('AppBundle:Post')->findOneBySlug($slug);
        //Se crea el comentario
        $comentario = new Comentario();
        $comentario->setUsuario($usuario);
        $comentario->setPost($post);
        $comentario->setTexto($textoComentario);
        $em->persist($comentario);
        $em->flush();
        
         //Se redirige al post pasando el ID del comentario recien publicado para hacer scroll hasta este con JS
        return $this->redirectToRoute('view_post', ['slug' => $slug, 'idComentario' => $comentario->getId()]);
    }

}