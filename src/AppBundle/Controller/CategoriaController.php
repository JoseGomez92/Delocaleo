<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoriaController extends Controller
{
    /**
     * @Route("/actualidad", name="actualidad")
     */
    public function actualidadAction(Request $request)
    {
        //Se obtiene la categoria
        $category = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findOneBy(array('nombre' => 'actualidad'));
        //Se obtienen los post cuya categoria sea actualidad
        $posts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findByCategory($category);

        // replace this example code with whatever you need
        return $this->render('categoria/categoria.html.twig', [
            'categoria' => $category,
            'posts' => $posts,
        ]);
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/humor", name="humor")
     */
    public function humorAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('categoria/categoria.html.twig', [
            'base_dir' => 'humor',
        ]);
    }

    /**
     * @Route("/curiosidad", name="curiosidad")
     */
    public function curiosidadAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('categoria/categoria.html.twig', [
            'base_dir' => 'curiosidad',
        ]);
    }

    /**
     * @Route("/reflexion", name="reflexion")
     */
    public function reflexionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('categoria/categoria.html.twig', [
            'base_dir' => 'reflexion',
        ]);
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
