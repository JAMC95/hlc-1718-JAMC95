<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\EventoType;
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
        $juergas =  $this->getDoctrine()->getRepository('AppBundle:Usuario')->findEventosconNAsistentes($juergas);

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
        $asistentes = $this->getDoctrine()->getRepository('AppBundle:Usuario')->findAsistentesNombre($evento);

        return $this->render('juergas/eventdetail.html.twig', [
            'juerga' => $juerga,
            'asistentes' => $asistentes
        ]);
    }


    /**
     * @Route(path="/eventonew/", name="nuevo_evento")
     * */

    public function JuergaNew(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();


        $evento = new Evento();
        $em->persist($evento);
        $form = $this->createForm(EventoType::class, $evento);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                return $this->redirectToRoute('mostrar_juergas');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render('juergas/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}
