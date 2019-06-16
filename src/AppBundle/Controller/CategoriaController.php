<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contacto;
use AppBundle\Form\ContactoType;
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
            //Se obtienen los post mas visitados
            $postMasVisitados = $this->getDoctrine()->getRepository('AppBundle:Post')->getMoreVisited();
            //Se obtiene el numero de paginas para la categoria
            $numPags = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->getNumPagesByCategory($category);
            return $this->render('categoria/categoria.html.twig', [
                'categoria' => $category,
                'posts' => $posts,
                'categorias' => $categories,
                'postMasVisitados' => $postMasVisitados,
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
            //Se obtienen los post mas visitados
            $postMasVisitados = $this->getDoctrine()->getRepository('AppBundle:Post')->getMoreVisited();
            //Se obtiene el numero de paginas para la categoria
            $numPags = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->getNumPagesByCategory($category);
            return $this->render('categoria/categoria.html.twig', [
                'categoria' => $category,
                'posts' => $posts,
                'categorias' => $categories,
                'postMasVisitados' => $postMasVisitados,
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
        $contacto = new Contacto();
        //Se obtiene la instancia del formulario
        $form = $this->createForm(ContactoType::class, $contacto, array());
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            //Se indica la fecha actual para el contacto
            $contacto->setFechaRegistro(new \DateTime("now"));
            $em->persist($contacto);
            $em->flush();
            //Se indica el mensaje flash
            $this->addFlash(
                'notificacion',
                '¡Mensaje Enviado! Contactaremos contigo a la mayor brevedad posible'
            );
        }
        //Se obtienen las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();

        return $this->render('contacto/contacto.html.twig', array(
            'form' => $form->createView(),
            'categorias' => $categorias
        ));
    }

}
