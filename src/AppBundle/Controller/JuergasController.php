<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Evento;
class JuergasController extends Controller
{
    /**
     * @Route(path="/eventos", name="mostrar_juergas")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $juergas = $em->getRepository('AppBundle:Evento')->findAll();
        $asistentes= $em->createQueryBuilder()
            ->select( 'SIZE(e.usuario)')
            ->from('AppBundle:Evento', 'e')
            ->getQuery()
            ->getResult();

        foreach ($juergas as $item) {
            foreach ($asistentes as $item2) {
                 $item->nAsistentes = $item2[1];
            }
        }

        return $this->render('juergas/index.html.twig', [
            'juergas' => $juergas
        ]);
    }


    /**
     * @Route(path="/evento/{evento}", name="mostrar_asistentes")
     * */

    public function JuergaAction(Request $request, $evento)
    {
        $eventosAsistente[0] = ['evento' => 'Fiesta aprobados HLC', 'asistente'=> ['Juan','Maria', 'Diego'] ];
        $eventosAsistente[1] = ['evento' => 'Fiesta estudiosos', 'asistente'=> ['Paco','Maria', 'Diego'] ];
        $eventosAsistente[1] = ['evento' => 'Viaje a Despeñaperros', 'asistente'=> [] ];
        $eventoAsistente = null;
        foreach ($eventosAsistente as $item) {
            if($item['evento'] == $evento) {
                $eventoAsistente = $item;
            }
        }

        return $this->render('juergas/eventdetail.html.twig', [
            'juerga' => $eventoAsistente
        ]);
    }
}
