<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BusquedaController extends Controller
{
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
