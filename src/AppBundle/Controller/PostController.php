<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}", name="{slug}")
     */
    public function viewAction(Request $request, $slug){
        //Se obtienen las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se obtiene el post
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBy(array('slug' => $slug));
        if($post != null){
            //Se renderiza la vista para el post
            return $this->render('articulo/post.html.twig', [
                'categorias' => $categorias,
                'post' => $post,
            ]);
        }
        else{
            return $this->render('base.html.twig');
        }
    }

}
