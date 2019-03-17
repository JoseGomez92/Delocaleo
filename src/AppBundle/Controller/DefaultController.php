<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function indexAction(Request $request)
    {
        //Se obtienen las categorias
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se obtiene la pagina (si no se ha indicado se asigna 1 por defecto)
        $pag = ($request->get("pagina") != null) ? $request->get("pagina") : 1;
        //Se obtienen los posts
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findPaged($pag);
        //Se obtiene el numero de paginas
        $numPags = $this->getDoctrine()->getRepository('AppBundle:Post')->getNumPages();
        return $this->render('default/inicio.html.twig', [
            'posts' => $posts,
            'categorias' => $categories,
            'pagina' => $pag,
            'numPags' => $numPags,
        ]);
    }

    /**
     * @Route("/{page}", name="inicioPagina")
     */
    public function pageAction(Request $request, $page)
    {
        //Se obtienen las categorias
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se obtienen los posts
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findPaged($page);
        //Se obtiene el numero de paginas
        $numPags = $this->getDoctrine()->getRepository('AppBundle:Post')->getNumPages();
        // replace this example code with whatever you need
        return $this->render('default/inicio.html.twig', [
            'posts' => $posts,
            'categorias' => $categories,
            'pagina' => $page,
            'numPags' => $numPags,
        ]);
    }

}
