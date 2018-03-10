<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\CambioClaveType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UsuarioController extends Controller
{

    /**
     * @Route("/usuarios", name="usuarios_listar")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listarUsuariosConPuntos()
    {
        $datos = $this->getDoctrine()->getRepository('AppBundle:Usuario')->findUsuarios();
       // dump($datos); exit;
        return $this->render('users/index.html.twig', [
            'usuarios' => $datos
        ]);
    }
    /**
     * @Route("/usuario/clave", name="usuario_cambiar_clave")
     * @Security("is_granted('ROLE_USER')")
     */
    public function cambiarClave(Request $request, UserPasswordEncoder $userPasswordEncoder)
    {
        /** @var Usuario $usuario */
        $usuario = $this->getUser();
        $formulario = $this->createForm(CambioClaveType::class, $usuario);
        $formulario->handleRequest($request);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $textoPlano = $formulario->get('nuevaClave')->get('first')->getData();
            try {
                $usuario->setPassword(
                    $userPasswordEncoder->encodePassword($usuario, $textoPlano)
                );
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('info', 'Contraseña cambiada con éxito');
                return $this->redirectToRoute('inicio');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render('users/cambio_clave.html.twig', [
            'formulario' => $formulario->createView()
        ]);
    }
}