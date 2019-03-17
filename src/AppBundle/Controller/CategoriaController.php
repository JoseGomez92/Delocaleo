<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoriaController extends Controller
{
    /**
     * @Route("/categoria/{categoryName}", name="ver_categoria")
     */
    public function viewAction(Request $request, $categoryName)
    {
        //Se obtiene la categoria
        $category = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findOneBy(array('nombre' => $categoryName));

        if($category != null){
            //Se obtienen los post de la categoria
            $posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findPagedByCategory($category);
            //Se obtienen todas las categorias de la BBDD
            $categories = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
            return $this->render('categoria/categoria.html.twig', [
                'categoria' => $category,
                'posts' => $posts,
                'categorias' => $categories,
             ]);
        }
        else{
            return $this->render('base.html.twig');
        }
    }


    /**
     * @Route("/contacto", name="contacto")
     */
    public function contactoAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => 'contacto',
        ]);
    }

}
