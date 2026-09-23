<?php

namespace App\Form;

use App\Entity\ReporteMascota;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MascotaPerdidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ubicacion', ChoiceType::class, [
                'label' => 'Barrio donde fue vista por última vez',
                'choices' => [
                    'Barriodo'=>'Barriodo',
                    'Texas'=>'Texas',
                    'San Martín'=>'San Martín',
                    'Juan XXIII'=>'Juan XXIII',
                    'San José'=>'San José',
                    'Juan Caparroz'=>'Juan Caparroz',
                    'Belgrano'=>'Belgrano',
                    'Palermo'=>'Palermo',
                    'Mariano Moreno'=>'Mariano Moreno',
                    'Rivadavia'=>'Rivadavia',
                    'Tiro Federal'=>'Tiro Federal',
                    'Pelegrini'=>'Pelegrini',
                    'Sgto Bustamante'=>'Sgto Bustamante',
                ],
                'placeholder' => 'Seleccionar barrio',
            ])

            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Indique dónde fue vista, cuándo, características del lugar, etc.',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReporteMascota::class,
        ]);
    }
}