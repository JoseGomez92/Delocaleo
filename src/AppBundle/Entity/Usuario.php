<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 * 
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nombre", type="string")
     * 
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(name="email", type="string")
     * 
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string")
     * 
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(name="img", type="string")
     */
    private $imagen;

    /**
     * @ORM\Column(name="fecha_alta", type="datetime")
     * 
     * @Assert\DateTime
     */
    private $fechaAlta;


    public function __construct()
    {
        $this->fechaAlta = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Usuario
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set imagen
     * 
     * @param string $imagen
     * 
     * @return Usuario
     */
    public function setImagen($imagen){
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     * 
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }


}
