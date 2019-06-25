<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JSONResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use \Symfony\Component\HttpFoundation\FileBag;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

class UsuarioController extends Controller
{

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function loginAction(Request $request){
        $response = new JSONResponse();
        $user = $request->get('user');
        $pass = $request->get('pass');
        try{
            //Se verifica si se han recibido los parametros para el login
            if(is_null($user) && is_null($pass)) throw new \Exception('No se recibieron los parametros adecuados');
            $em = $this->getDoctrine()->getEntityManager();
            //Se busca el usuario en base a los credendiales recibidos
            $usuario = $em->getRepository('AppBundle:Usuario')->findOneBy(
                array('nombre' => $user, 'password' => $pass)
            );
            //Se verifica que el usuario exista
            if(is_null($usuario)) throw new \Exception('Credenciales invalidos');
            $session = (is_null($request->getSession()))? new Session() : $request->getSession();
            $session->start();
            $session->set('usuario', $usuario);
        }
        catch(\Exception $e){
            $status = 400;
            $response->setStatusCode($status);
            $response->setContent(json_encode(array('status' => $status, 'message' => $e->getMessage())));
        }

        return $response;
    }


    /**
     * @Route("/registro", name="user_register", methods={"POST"})
     */
    public function userRegistrationAction(Request $request){
        $response = new JSONResponse();
        $status = 200;
        $nombre = $request->get('nombre');
        $email = $request->get('email');
        $password = $request->get('password');
        $img = $request->files->get('imgUsuario');
        try{
            $em = $this->getDoctrine()->getEntityManager();
            //Se verifica si se ha recibido el formulario
            if(is_null($nombre) || is_null($email) || is_null($password) || is_null($img)) throw new \Exception('No se recibieron los parametros adecuados');
            //Se verifica si ya existe un usuario con los credenciales (nombre y/o email) indicados
            if(count($em->getRepository('AppBundle:Usuario')->findByNameOrEmail($nombre, $email)) > 0) throw new \Exception ('Ya existe un usuario con el mismo nombre y/o email');
            $em = $this->getDoctrine()->getManager();            
            //Se obtiene un nombre unico para la imagen
            $imgName = md5(uniqid()).'.'.$img->guessExtension();
            //Se mueve la imagen al directorio web (se almacena)
            $img->move('uploads', $imgName);
            //Se crea la entidad Usuario y se dan los valores para esta
            $usuario = new Usuario();
            $usuario->setNombre($nombre);
            $usuario->setEmail($email);
            $usuario->setPassword($password);
            $usuario->setImagen($imgName);
            $em->persist($usuario);
            $em->flush();
            //Se indican los valores para la respuesta
            $response->setStatusCode($status);
            $response->setContent(json_encode(array('status' => $status, 'message' => 'Usuario registrado correctamente')));
        }
        catch(\Exception $e){
            $status = 400;
            $response->setStatusCode($status);
            $response->setContent(json_encode(array('status' => $status, 'message' => $e->getMessage())));
        }

        return $response;
    }


}