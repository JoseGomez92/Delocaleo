<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contacto
 *
 * @ORM\Table(name="contacto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoRepository")
 */
class Contacto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * var text
     *
     * @ORM\Column(name="comentario", type="text")
     */
    private $comentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    private $fechaRegistro;



    /**
     * Get id
     *
     * @return int
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
     * @return Contacto
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Contacto
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contacto
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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Contacto
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return Contacto
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }
}
