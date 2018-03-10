<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\EventoType;
use AppBundle\Security\EventoVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     */

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
     * @Route(path="/eventoedit/{evento}", name="editar_evento")
     * @Security("is_granted('ROLE_JUERGUISTA')")
     * */

    public function JuergaNew(Request $request, Evento $evento = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if(null === $evento) {
            $evento = new Evento();
            $evento->setAutor($this->get('security.token_storage')->getToken()->getUser());
            $em->persist($evento);
            $form = $this->createForm(EventoType::class, $evento, ['admin' => $this->isGranted('ROLE_ADMIN')]);
        } else {
            $form = $this->createForm(EventoType::class, $evento, [
                'disabled' => !$this->isGranted(EventoVoter::MODIFICAR, $evento),
           'admin' => $this->isGranted('ROLE_ADMIN')]);


        }


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

            'formulario' => $form->createView(),
            'evento' => $evento
        ]);
    }

    /**
     * @Route("/eventoeliminar/{id}", name="evento_eliminar")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function eliminarAction(Request $request, Evento $evento)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            try {

                $em->remove($evento);
                $em->flush();
                return $this->redirectToRoute('mostrar_juergas');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar la juerga');
            }
        }
        return $this->render('juergas/eliminar.html.twig', [
            'juerga' => $evento
        ]);
    }

}
