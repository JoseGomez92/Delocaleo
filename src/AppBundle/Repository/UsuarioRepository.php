<?php

namespace AppBundle\Repository;

/**
 * UsuarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsuarioRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Encuentra el usuario que coincida con el nombre y/o email indicados.
     */
    public function findByNameOrEmail($nombre, $email){
        $em = $this->getEntityManager();
        //Se forma la consulta DQL
        $dql = "SELECT u FROM AppBundle:Usuario u WHERE u.nombre='$nombre' or u.email='$email'";
        //Se crea el objeto consulta para obtener la entidade usuario que coincida con los criterios
        $query = $em->createQuery($dql);
        //Se obtienen los resultados de la consulta
        $user = $query->getResult()[0];

        return $user;
    }
}
