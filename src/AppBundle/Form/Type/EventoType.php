<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 1/03/18
 * Time: 11:11
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Categoria;
use AppBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', null, [
            'label' => 'Nombre'
        ])
            ->add('fechaInicio', null, [
                'label' => 'Fecha de Inicio'
            ])
            ->add('fechaFin', null, [
                'label' => 'Fecha de finalización'
            ])
            ->add('precioPersona', null, [
                'label' => 'Precio por persona'
            ])
            ->add('categoria',  EntityType::class, [
                'class' => Categoria::class,
                'label' => 'Categorias',
                'expanded' => true,
                'multiple' => false,
                'required' => true
            ])
            ->add('usuarios',  EntityType::class, [
            'class' => Usuario::class,
            'label' => 'Usuarios',
            'expanded' => true,
            'multiple' => true,
            'required' => false
        ]);

    }
}