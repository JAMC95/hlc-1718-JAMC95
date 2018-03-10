<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Evento;
use Doctrine\ORM\EntityRepository;

class UsuarioRepository  extends EntityRepository
{
    public function findEventosConNAsistentes($juergas) {
        $asistentes[] = null;
        $i = 1;

        foreach ($juergas as $item) {
            $asistente = $this->createQueryBuilder('u')
                ->select('u.nombreUsuario')
                ->join('u.eventos', 'e')
                ->where('e.id = :evento')
                ->setParameter('evento', $item)
                ->getQuery()
                ->getResult();

                array_push($asistentes, $asistente);




        }

        foreach ($juergas as $item) {

                $item->nAsistentes = count($asistentes[$i]);
                $i++;

        }

        return $juergas;
    }

    public function findAsistentesNombre($evento) {
        return $this->createQueryBuilder('u')
            ->select('u.nombreUsuario')
            ->join('u.eventos', 'e')
            ->where('e.id = :evento')
            ->setParameter('evento', $evento)
            ->getQuery()
            ->getResult();


    }

    public function findUsuarios() {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->getQuery()
            ->getResult();


    }

}