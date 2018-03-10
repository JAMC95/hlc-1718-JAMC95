<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categoria")
 */
class Categoria
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
     * @ORM\Column(type="string")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Evento", mappedBy="categoria")
     * @var evento[]
     */
    private $eventos;

    /**
     * @return evento[]
     */
    public function getEventos()
    {
        return $this->eventos;
    }

    /**
     * @param evento[] $eventos
     * @return Categoria
     */
    public function setEventos($eventos)
    {
        $this->eventos = $eventos;
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
     * @return Categoria
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
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return Categoria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function __toString()
    {
        return (string)$this->nombre;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evento.
     *
     * @param \AppBundle\Entity\Evento $evento
     *
     * @return Categoria
     */
    public function addEvento(\AppBundle\Entity\Evento $evento)
    {
        $this->eventos[] = $evento;

        return $this;
    }

    /**
     * Remove evento.
     *
     * @param \AppBundle\Entity\Evento $evento
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEvento(\AppBundle\Entity\Evento $evento)
    {
        return $this->eventos->removeElement($evento);
    }
}
