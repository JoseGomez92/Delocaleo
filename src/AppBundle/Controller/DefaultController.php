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
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();

        // replace this example code with whatever you need
        return $this->render('default/inicio.html.twig', [
            'posts' => $posts,
        ]);
    }
}
