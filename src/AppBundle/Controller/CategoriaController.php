<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoriaController extends Controller
{
    /**
     * @Route("/categoria/{categoryName}", name="view_categoria_paged_post")
     */
    public function viewPostAction(Request $request, $categoryName)
    {
        //Se obtiene la categoria
        $category = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findOneBy(array('nombre' => $categoryName));

        if($category != null){
            //Se obtienen todas las categorias de la BBDD
            $categories = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
            //Se obtiene la pagina (si no se ha indicado se asigna 1 por defecto)
            $pag = ($request->get("pagina") != null) ? $request->get("pagina") : 1;
            //Se obtienen los post de la categoria
            $posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findPagedByCategory($category, $pag);
            //Se obtiene el numero de paginas para la categoria
            $numPags = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->getNumPagesByCategory($category);
            return $this->render('categoria/categoria.html.twig', [
                'categoria' => $category,
                'posts' => $posts,
                'categorias' => $categories,
                'pagina' => $pag,
                'numPags' => $numPags,
             ]);
        }
        else{
            return $this->render('base.html.twig');
        }
    }

    /**
     * @Route("/categoria/{categoryName}/{pag}", name="view_categoria_paged_url")
     */
    public function viewAction(Request $request, $categoryName, $pag)
    {
        //Se obtiene la categoria
        $category = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findOneBy(array('nombre' => $categoryName));

        if($category != null){
            //Se obtienen todas las categorias de la BBDD
            $categories = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
            //Se obtienen los post de la categoria
            $posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findPagedByCategory($category, $pag);
            //Se obtiene el numero de paginas para la categoria
            $numPags = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->getNumPagesByCategory($category);
            return $this->render('categoria/categoria.html.twig', [
                'categoria' => $category,
                'posts' => $posts,
                'categorias' => $categories,
                'pagina' => $pag,
                'numPags' => $numPags,
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
