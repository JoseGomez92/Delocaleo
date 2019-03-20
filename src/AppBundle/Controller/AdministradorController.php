<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Form\CategoriaType;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use Symfony\Component\Filesystem\Filesystem;

class AdministradorController extends Controller
{
    /**
     * @Route("/administrador", name="admin_view")
     */
    public function viewResultAction(Request $request)
    {
        //Se renderiza la vista del menu de adminstracion
        return $this->render('administrador/menu.html.twig', []);
    }


    /**
     * @Route("/administrador/listar_posts", name="list_post")
     */
    public function listPostAction(Request $request){
        //Se recuperan todos los posts
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        //Se renderiza la vista para visualizar todos los posts
        return $this->render('administrador/post/listado.html.twig', [
            'posts' => $posts,
        ]);
    }


    /**
     * @Route("/administrador/anadir_post", name="add_post")
     */
    public function addPostAction(Request $request){
        //Se crea la instancia de post que se pasará al formulario
        $post = new Post();
        //Se obtiene la instancia del formulario
        $form = $this->createForm(PostType::class, $post, array());
        //Se obtienen las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $post->getImagen();
            $fileName =  md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move('uploads', $fileName);
                $post->setImagen($fileName);
                $post->setFechaCreacion(new \DateTime("now"));
                $post->setVisitas(0);
                $em->persist($post);
                $em->flush();
                $this->addFlash(
                    'notificacion',
                    'Post creado correctamente.'
                );
            }
            catch (FileException $e) {
                $this->addFlash(
                    'notificacion',
                    'Post creado correctamente.'
                );
            }
        }
        return $this->render('administrador/post/formulario.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/administrador/modificar_posts", name="list_modify_post")
     */
    public function listModifyPostAction(Request $request){
        //Se recuperan todos los posts
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        //Se renderiza la vista para visualizar todos los posts
        return $this->render('administrador/post/listado.html.twig', [
            'posts' => $posts,
            'modificar' => true,
        ]);
    }


    /**
     * @Route("/administrador/modificar_post/{post_id}", name="view_modify_post", requirements={"post_id"="\d+"})
     */
    public function viewModifyPostAction(Request $request, $post_id){
        //Se recupera el post
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($post_id);
        //Se carga la imagen (se indica un tipo file para el campo imagen
        if($post->getImagen()){
            $file = new \Symfony\Component\HttpFoundation\File\File('uploads/'.$post->getImagen());
            $post->setImagen($file);
        }
        //Se obtiene la instancia del formulario
        $form = $this->createForm(PostType::class, $post, array());

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $post->getImagen();
            $fileName =  md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move('uploads', $fileName);
                $post->setImagen($fileName);
                $post->setFechaCreacion(new \DateTime("now"));
                $post->setVisitas(0);
                $em->persist($post);
                $em->flush();
                $this->addFlash(
                    'notificacion',
                    'Post creado correctamente.'
                );
            }
            catch (FileException $e) {
                $this->addFlash(
                    'notificacion',
                    'Post creado correctamente.'
                );
            }
        }
        return $this->render('administrador/post/formulario.html.twig', [
            'form' => $form->createView(),
            'modificar' => true,
        ]);
    }


    /**
     * @Route("/administrador/borrar_posts", name="list_delete_post")
     */
    public function listDeletePostAction(Request $request){
        //Se recuperan todos los posts
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        //Se renderiza la vista para visualizar todos los posts
        return $this->render('administrador/post/listado.html.twig', [
            'posts' => $posts,
            'eliminar' => true,
        ]);
    }


    /**
     * @Route("/administrador/borrar_posts/{post_id}", name="delete_post", requirements={"post_id"="\d+"})
     */
    public function deletePostAction(Request $request, $post_id){
        $em = $this->getDoctrine()->getManager();
        //Se recuperan el post a eliminar
        $post = $em->getRepository('AppBundle:Post')->find($post_id);
        //Se elimina la imagen
        $filename = $post->getImagen();
        $filesystem = new Filesystem();
        $filesystem->remove('uploads/'.$filename);
        //Se elimina el post
        $em->remove($post);
        $em->flush();
        //Se indica un mensaje (flash) para notificar al administrador
        $this->addFlash(
            'notificacion',
            'Post eliminado correctamente.'
        );
        //Se obtienen todos los posts y se renderiza listado para borrar posts
        $posts = $em->getRepository('AppBundle:Post')->findAll();
        //Se renderiza la vista para visualizar todos los posts
        return $this->render('administrador/post/listado.html.twig', [
            'posts' => $posts,
            'eliminar' => true,
        ]);
    }


    /**
     * @Route("/administrador/listar_categorias", name="list_categories")
     */
    public function listCategoryAction(Request $request){
        //Se recuperan todas las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se renderiza la plantilla para el listado de categorias
        return $this->render('administrador/categoria/listado.html.twig', [
           'categorias' => $categorias,
        ]);
    }


    /**
     * @Route("/administrador/anadir_categorias", name="add_category")
     */
    public function addCategoryAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        //Se crea la instancia de post que se pasará al formulario
        $categoria = new Categoria();
        //Se obtiene la instancia del formulario
        $form = $this->createForm(CategoriaType::class, $categoria, array());

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($categoria);
            $em->flush();
            $this->addFlash(
                'notificacion',
                'Categoria creada correctamente.'
            );
        }
        return $this->render('administrador/categoria/formulario.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/administrador/modificar_categorias", name="list_modify_category")
     */
    public function listModifyCategoryAction(Request $request){
        //Se recuperan todos las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        //Se renderiza la vista para visualizar todos los posts
        return $this->render('administrador/categoria/listado.html.twig', [
            'categorias' => $categorias,
            'modificar' => true,
        ]);
    }


    /**
     * @Route("/administrador/modificar_categoria/{category_id}", name="view_modify_category", requirements={"category_id"="\d+"})
     */
    public function modifyCategoryAction(Request $request, $category_id){
        $em = $this->getDoctrine()->getManager();
        //Se recupera la categoria
        $categoria = $em->getRepository('AppBundle:Categoria')->find($category_id);
        //Se obtiene la instancia del formulario
        $form = $this->createForm(CategoriaType::class, $categoria, array());
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //Se actuliazan los campos de la entidad
            $categoria->setNombre($form->get('nombre')->getData());
            $categoria->setColor($form->get('color')->getData());
            //Se actualiza la entidad
            $persist = $em->persist($categoria);
            $flush = $em->flush();
            $this->addFlash(
                'notificacion',
                'Categoria modificada correctamente.'
            );
        }
        return $this->render('administrador/categoria/formulario.html.twig', [
            'form' => $form->createView(),
            'categoria' => $categoria,
            'modificar' => true,
        ]);
    }


    /**
     * @Route("/administrador/eliminar_categorias", name="list_delete_category")
     */
    public function listDeleteCategoryAction(Request $request){
        //Se recuperan todos las categorias
        $categorias = $this->getDoctrine()->getRepository('AppBundle:Categoria')->findAll();
        return $this->render('administrador/categoria/listado.html.twig', [
            'categorias' => $categorias,
            'eliminar' => true,
        ]);
    }


    /**
     * @Route("/administrador/eliminar_categorias/{category_id}", name="delete_category", requirements={"category_id"="\d+"})
     */
    public function deleteCategoryAction(Request $request, $category_id){
        //Se recupera la categoria de la BBDD
        $em = $this->getDoctrine()->getManager();
        $categoria = $em->getRepository('AppBundle:Categoria')->find($category_id);
        //Se recuperan los posts de la categoria
        $posts = $em->getRepository('AppBundle:Post')->findByCategory($categoria);
        //Se eliminan los posts de la categoria
        if(count($posts) > 0){
            foreach($posts as $post){
                $filename = $post->getImagen();
                $filesystem = new Filesystem();
                $filesystem->remove('uploads/'.$filename);
                $em->remove($post);
            }
        }
        //Se elimina la categoria
        $em->remove($categoria);
        //Se guardan lso cambios en la BBDD
        $em->flush();
        $this->addFlash(
            'notificacion',
            'Categoria eliminada correctamente.'
        );
        $categorias = $em->getRepository('AppBundle:Categoria')->findAll();
        return $this->render('administrador/categoria/listado.html.twig', [
            'categorias' => $categorias,
            'modificar' => true,
        ]);
    }


    /**
     * @Route("/administrador/listar_mensajes", name="list_messages")
     */
    public function listMessages(Request $request){
        $em = $this->getDoctrine()->getManager();
        $mensajes = $em->getRepository('AppBundle:Contacto')->findBy(array(), array('id' => 'DESC'));
        //Se renderiza la plantilla para visualizar los mensajes
        return $this->render('administrador/contacto/listado.html.twig', [
            'mensajes' => $mensajes,
        ]);
    }


    /**
     * @Route("/administrador/eliminar_mensajes", name="list_delete_messages")
     */
    public function deleteMessageAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $mensajes = $em->getRepository('AppBundle:Contacto')->findBy(array(), array('id' => 'DESC'));
        //Se renderiza la plantilla para visualizar los mensajes
        return $this->render('administrador/contacto/listado.html.twig', [
            'mensajes' => $mensajes,
            'eliminar' => true,
        ]);
    }


    /**
     * @Route("/administrador/eliminar_mensajes/{message_id}", name="delete_message")
     */
    public function listDeleteMessageAction(Request $request, $message_id){
        $em = $this->getDoctrine()->getManager();
        $mensajeRepository = $em->getRepository('AppBundle:Contacto');
        //Se recupera el mensaje
        $mensaje = $mensajeRepository->find($message_id);
        //Se elimina y se guardan los cambios en la BBDD
        $em->remove($mensaje);
        $em->flush();
        $mensajes = $mensajeRepository->findBy(array(), array('id' => 'DESC'));
        //Se renderiza la plantilla para visualizar los mensajes
        return $this->render('administrador/contacto/listado.html.twig', [
            'mensajes' => $mensajes,
            'eliminar' => true,
        ]);
    }

}
