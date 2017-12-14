<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Evento;
use Doctrine\ORM\EntityRepository;

class EventoRepository  extends EntityRepository
{
    public function findEventos($juergas) {
        $asistentes= $this->createQueryBuilder('n')
            ->addselect( 'SIZE(e.usuario)')
            ->from('AppBundle:Evento', 'e')
            ->getQuery()
            ->getResult();

        foreach ($juergas as $item) {
            foreach ($asistentes as $item2) {
                $item->nAsistentes = $item2[1];
            }
        }

        return $juergas;
    }

    public function findAsistentesNombre($evento) {
        return $this->createQueryBuilder('a')
            ->addselect( 'u.nombreUsuario')
            ->from('AppBundle:Evento', 'e')
            ->join('e.usuario', 'u')
            ->where('e.id = :evento')
            ->setParameter('evento', $evento)
            ->getQuery()
            ->getResult();


    }

}