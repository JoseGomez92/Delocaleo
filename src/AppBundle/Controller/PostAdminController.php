<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostAdminController extends CRUDController
{

    public function asdfAction(Request $request){
        $post = new Post();
        $form = $this->createForm(ProductType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $post->getImagen();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $post->setImagen($fileName);
                $this->addFlash(
                    'notificacion',
                    'Post creado correctamente.'
                );
            } catch (FileException $e) {
                $this->addFlash(
                    'notificacion',
                    'Post creado correctamente.'
                );
            }
            return $this->render('post/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->add('create', $this->getRouterIdParameter().'/create');
        $collection->add('asdf', $this->getRouterIdParameter().'/asdf');
    }

}
