<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}", name="view_post")
     */
    public function viewAction(Request $request, $slug){
        $em = $this->getDoctrine()->getManager();
        //Se obtiene el post
        $post = $em->getRepository('AppBundle:Post')->findOneBy(array('slug' => $slug));
        //Se obtienen las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        if($post != null){
            //Se aumentan las visitas del post
            $post->setVisitas($post->getVisitas() + 1);
            $em->flush();
            //Se obtienen los slugs (correspondientes al post anterior y al posterior de la misma categoria)
            $slugs = $this->getDoctrine()->getRepository('AppBundle:Post')->getSlugsPosts($post);
            //Se obtienen los post mas visitados
            $postMasVisitados = $this->getDoctrine()->getRepository('AppBundle:Post')->getMoreVisited();
            //Se renderiza la vista para el post
            return $this->render('articulo/post.html.twig', [
                'categorias' => $categorias,
                'post' => $post,
                'slugAnterior' => $slugs['slugAnterior'],
                'slugPosterior' => $slugs['slugPosterior'],
                'postMasVisitados' => $postMasVisitados,
            ]);
        }
        else{
            return $this->render('base.html.twig');
        }
    }

}
