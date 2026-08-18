<?php

namespace App\Form;

use App\Entity\Mascota;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MascotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagen', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])

            ->add('nombre', TextType::class)

            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Perro' => 'perro',
                    'Gato' => 'gato',
                ],
                'placeholder' => 'Seleccionar el tipo de mascota',
            ])

            ->add('genero', ChoiceType::class, [
                'choices' => [
                    'Macho' => 'macho',
                    'Hembra' => 'hembra',
                ],
                'placeholder' => 'Seleccionar el género de la mascota',
            ])

            ->add('color', TextType::class)

            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Callejero' => 'callejero',
                    'Con propietario' => 'con propietario',
                ],
                'placeholder' => 'Seleccionar el estado de la mascota',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mascota::class,
        ]);
    }
}