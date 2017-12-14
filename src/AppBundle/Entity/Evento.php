<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventoRepository")
 * @ORM\Table(name="evento")
 */
class Evento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $fechaFin;

    /**
     * @ORM\Column(type="float")
     */
    private $precioPersona;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=false)
     * @var Usuario[]
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=false)
     * @var Categoria
     */
    private $categoria;

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param Categoria $categoria
     * @return Evento
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Evento
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Evento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param \DateTime $fechaInicio
     * @return Evento
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param \DateTime $fechaFin
     * @return Evento
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrecioPersona()
    {
        return $this->precioPersona;
    }

    /**
     * @param float $precioPersona
     * @return Evento
     */
    public function setPrecioPersona($precioPersona)
    {
        $this->precioPersona = $precioPersona;
        return $this;
    }

    /**
     * @return Usuario[]
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario[] $usuario
     * @return Evento
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }


}