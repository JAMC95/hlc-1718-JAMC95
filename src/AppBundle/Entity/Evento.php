<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
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
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     * @Assert\Range(
     *      min = "now",
     *      max = "first day of January next year UTC",
     *      maxMessage="La fecha no puede ser anterior a la actual",
     *      minMessage="La fecha no puede ser superior al 1 de enero del próximo año"
     * )
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date")
     * @Assert\Range(
     *      min = "now",
     *      max = "first day of January next year UTC",
     *      maxMessage="La fecha no puede ser anterior a la actual",
     *      minMessage="La fecha no puede ser superior al 1 de enero del próximo año"
     * )
     * @var \DateTime
     */
    private $fechaFin;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="integer",
     *     message="Ponga un valor decimal"
     *     )
     */
    private $precioPersona;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=false)
     * @var Usuario[]
     */
    private $usuarios;

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
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param Usuario[] $usuario
     * @return Evento
     */
    public function setUsuarios($usuarios)
    {
        $this->usuarios = $usuarios;
        return $this;
    }


}