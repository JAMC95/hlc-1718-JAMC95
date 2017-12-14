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
        $juergas =  $this->getDoctrine()->getRepository('AppBundle:Evento')->findEventos($juergas);

        return $this->render('juergas/index.html.twig', [
            'juergas' => $juergas
        ]);
    }


    /**
     * @Route(path="/evento/{evento}", name="mostrar_asistentes")
     * */

    public function JuergaAction(Request $request, Evento $evento)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $juerga = $em->getRepository('AppBundle:Evento')->findOneBy(['id'=>  $evento->getId()]);
        $asistentes = $this->getDoctrine()->getRepository('AppBundle:Evento')->findAsistentesNombre($evento);

        return $this->render('juergas/eventdetail.html.twig', [
            'juerga' => $juerga,
            'asistentes' => $asistentes
        ]);
    }
}
