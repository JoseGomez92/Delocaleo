<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    //Constante para indicar la cantidad de post que recuperaran por cada pagina
    const limit = 2;


    //Metodo para obtener todos los post de una categoria
    public function findByCategory($category){
        return $this->getEntityManager()
            ->createQuery(
            'SELECT p FROM AppBundle:Post p WHERE p.categoria = :categoria ORDER BY p.id DESC')
            ->setParameter('categoria', $category)
            ->getResult();
    }


    //Metodo para obtener post paginados (independientemente de su categoria)
    public function findPaged($page = 1){
        //Se forma la consulta
        $query = $this->getEntityManager()
            ->createQuery('SELECT p FROM AppBundle:Post p ORDER BY p.id DESC');
        //Se indica la paginacion para la consulta
        $queryPaginated = $this->paginate($query, $page)->getQuery();
        //Se devuelven los registros
        return $queryPaginated->getResult();
    }


    //Metodo para obtener una cantidad determinada de post(mediante paginacion)
    public function findPagedByCategory($category, $page = 1){
        //Se forma la consulta
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Post p WHERE p.categoria = :categoria ORDER BY p.id DESC')
            ->setParameter('categoria', $category);
        //Se indica la paginacion para la consulta
        $queryPaginated = $this->paginate($query, $page)->getQuery();
        //Se devuelven los registros
        return $queryPaginated->getResult();
    }


    //Metodo para obtener posts en base a los criterios de busqueda (titulo, tags o ambos)
    public function findBySearch($text, $title, $tags){
        $query = '';
        //Se forma la consulta en base a los criterios especificados
        if(!is_null($title) && is_null($tags)){ //Busqueda por titulo
            $query = $this->getEntityManager()
                ->createQuery(
                    "SELECT p FROM AppBundle:Post p WHERE p.titulo LIKE :titulo")
                ->setParameter('titulo', '%'.$text.'%');
        }
        else if(is_null($title) && !is_null($tags)){ //Busqueda por tags
            $query = $this->getEntityManager()
                ->createQuery(
                    "SELECT p FROM AppBundle:Post p WHERE p.tags LIKE :tags")
                ->setParameter('tags', '%'.$text.'%');
        }
        else{ //Busqueda por titulo y tags
            $query = $this->getEntityManager()
                ->createQuery(
                    "SELECT p FROM AppBundle:Post p WHERE p.titulo LIKE :titulo OR p.tags LIKE :tags")
                ->setParameter('titulo', '%'.$text.'%')
                ->setParameter('tags', '%'.$text.'%');
        }
        return $query->getResult();
    }


    //Metodo para obtener los post mas visitados
    public function getMoreVisited(){
        return $this->getEntityManager()->getRepository('AppBundle:Post')
            ->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.visitas', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(5)
            ->getQuery()->getResult();
    }


    //Metodo para obtener el slug del post anterior y siguiente (de la misma categoria)
    public function getSlugsPosts($post){
        //Se obtienen todos los posts de la misma categoria
        $posts = $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Post p WHERE p.categoria = :categoria AND p.id > 1 ORDER BY p.id ASC')
            ->setParameter('categoria', $post->getCategoria())
            ->getResult();
        //Se obtiene el indice del posts en los resultados
        $slugs = array('slugAnterior' => null, 'slugPosterior' => null);
        for($i = 0; $i < count($posts); $i++){
            if($posts[$i] == $post){
                if($i > 0) $slugs['slugAnterior'] = $posts[$i - 1]->getSlug();
                if($i < count($posts) - 1) $slugs['slugPosterior'] = $posts[$i + 1]->getSlug();
            }
        }
        return $slugs;
    }


    //Metodo para obtener el numero de paginas total (correspondiente al numero de posts de todas las categorias)
    public function getNumPages(){
        $numPosts = $this->getEntityManager()
            ->createQuery(
                'SELECT count(p.id) FROM AppBundle:Post p')
            ->getSingleScalarResult();
        return ceil($numPosts / PostRepository::limit);
    }


    //Metodo para obtener el numero de pagins total para una categoria
    public function getNumPagesByCategory($category){
        $numPosts = $this->getEntityManager()
            ->createQuery(
                'SELECT count(p.id) FROM AppBundle:Post p WHERE p.categoria = :categoria')
            ->setParameter('categoria', $category)
            ->getSingleScalarResult();
        return ceil($numPosts / PostRepository::limit);
    }


    //Metodo para paginar
    public function paginate($dql, $page = 1)
    {
        //Se obtiene la instancia para paginar
        $paginator = new Paginator($dql);
        //Se añade la paginacion a la consulta
        $paginator->getQuery()
            ->setFirstResult(PostRepository::limit * ($page - 1)) // Offset
            ->setMaxResults(PostRepository::limit); // Limit
        return $paginator;
    }

}
