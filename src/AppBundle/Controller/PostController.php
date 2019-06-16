<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}/{idComentario}", name="view_post")
     */
    public function viewAction(Request $request, $slug, $idComentario = null){
        $session = new Session();
        $em = $this->getDoctrine()->getEntityManager();
        //Se obtiene el post
        $post = $em->getRepository('AppBundle:Post')->findOneBy(array('slug' => $slug));
        //Se obtienen las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        if($post != null){
            //Se aumentan las visitas del post
            $post->setVisitas($post->getVisitas() + 1);
            $em->flush();
            //Se crea el formulario de registro para el usuario
            $form = $this->createForm(UsuarioType::class, (new Usuario()), array());
            //Se obtienen los comentarios del post
            $comentarios = $em->getRepository('AppBundle:Comentario')->findByPost($post);
            //Se obtienen los slugs (correspondientes al post anterior y al posterior de la misma categoria)
            $slugs = $this->getDoctrine()->getRepository('AppBundle:Post')->getSlugsPosts($post);
            //Se obtienen los post mas visitados
            $postMasVisitados = $this->getDoctrine()->getRepository('AppBundle:Post')->getMoreVisited();
            //Se renderiza la vista para el post
            return $this->render('articulo/post.html.twig', [
                'categorias' => $categorias,
                'post' => $post,
                'formUsuario' => $form->createView(),
                'comentarios' => $comentarios,
                'slugAnterior' => $slugs['slugAnterior'],
                'slugPosterior' => $slugs['slugPosterior'],
                'postMasVisitados' => $postMasVisitados,
            ]);
        }
        else{
            return $this->render('base.html.twig');
        }
    }

    /**
     * @Route("/resultados_busqueda", name="view_result_search")
     */
    public function viewResultAction(Request $request)
    {
        //Se obtienen todas las categorias de la BBDD
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se recogen los criterios de busqueda
        $text = $request->get("buscar");
        $title = $request->get("titulo");
        $tags = $request->get("tags");
        //Se obtienen los post en base a los criterios de busqueda
        $posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findBySearch($text, $title, $tags);
        //Se obtienen los post mas visitados
        $postMasVisitados = $this->getDoctrine()->getRepository('AppBundle:Post')->getMoreVisited();
        return $this->render('busqueda/resultados.html.twig', [
            'posts' => $posts,
            'categorias' => $categories,
            'postMasVisitados' => $postMasVisitados,
        ]);
    }

}
