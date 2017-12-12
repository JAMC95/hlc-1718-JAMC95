<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JuergasController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $juergas[0] = ['evento' => 'Fiesta aprobados HLC', 'asistentes'=> 17, 'fechaInicio' => '17/07/2017', 'fechaFin' => '17/07/2017', 'precioPersona' => 17.50 ];
        $juergas[1] = ['evento' => 'Fiesta estudiosos', 'asistentes'=> 3, 'fechaInicio' => '19/07/2017', 'fechaFin' => '19/07/2017', 'precioPersona' => 16.00 ];
        $juergas[2] = ['evento' => 'Viaje a Despeñaperros', 'asistentes'=> 0, 'fechaInicio' => '1/08/2017', 'fechaFin' => '2/07/2017', 'precioPersona' => 50.00 ];
        return $this->render('juergas/index.html.twig', [
            'juergas' => $juergas
        ]);
    }
}
