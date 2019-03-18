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
        //Se obtienen las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se obtiene el post
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBy(array('slug' => $slug));
        if($post != null){
            //Se obtienen los slugs (correspondientes al post anterior y al posterior de la misma categoria)
            $slugs = $this->getDoctrine()->getRepository('AppBundle:Post')->getSlugsPosts($post);
            //Se renderiza la vista para el post
            return $this->render('articulo/post.html.twig', [
                'categorias' => $categorias,
                'post' => $post,
                'slugAnterior' => $slugs['slugAnterior'],
                'slugPosterior' => $slugs['slugPosterior'],
            ]);
        }
        else{
            return $this->render('base.html.twig');
        }
    }

}
