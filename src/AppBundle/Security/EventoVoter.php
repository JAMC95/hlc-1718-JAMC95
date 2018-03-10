<?php

namespace AppBundle\Security;


use AppBundle\Entity\Evento;
use AppBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventoVoter extends Voter
{
    const VER = 'EVENTO_VER';
    const MODIFICAR = 'EVENTO_MODIFICAR';
    const ELIMINAR = 'EVENTO_ELIMINAR';
    private $decisionManager;
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        // indicar si el Voter soporta el atributo y el sujeto indicados
        // si el sujeto no es una idea, devolver false
        if (!$subject instanceof Evento) {
            return false;
        }
        // si no es uno de los atributos definidos arriba, devolver false
        if (!in_array($attribute, [self::VER, self::MODIFICAR, self::ELIMINAR], true)) {
            return false;
        }
        return true;
    }
    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // si estamos aquí, es seguro que el sujeto es una idea y el atributo uno de los definidos arriba
        $user = $token->getUser();
        if (!$user instanceof Usuario) {
            // debería haber un usuario activo en la aplicación, denegar si no es así
            return false;
        }
        // si el usuario tiene ROLE_ADMIN, siempre tiene permiso
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }
        switch ($attribute) {
            case self::VER:
                return $this->puedeVer($subject, $token, $user);
            case self::MODIFICAR:
                return $this->puedeModificar($subject, $token, $user);
            case self::ELIMINAR:
                return $this->puedeEliminar($subject, $token, $user);
        }
        // por defecto, denegar el permiso
        return false;
    }
    private function puedeVer(Evento $evento, TokenInterface $token, Usuario $user)
    {
        // todos pueden ver las ideas publicadas
        return true;
    }

    private function puedeModificar(Evento $evento, TokenInterface $token, Usuario $user)
    {
        // solo el propietario y un administrador pueden modificar una idea
        if ($evento->getAutor() === $user) {
            // es el autor
            return true;
        }
        return $this->decisionManager->decide($token, ['ROLE_ADMIN']);
    }
    private function puedeEliminar(Evento $evento, TokenInterface $token, Usuario $user)
    {
        // solo el propietario y el administrador pueden eliminar una idea
        if ($evento->getAutor() === $user) {
            // es el autor
            return true;
        }
        return $this->decisionManager->decide($token, ['ROLE_ADMIN']);
    }

}