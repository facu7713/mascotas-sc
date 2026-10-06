<?php

namespace App\Form;

use App\Entity\Vacuna;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VacunaType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('tipoVacuna', TextType::class, [
                'label' => 'Tipo de vacuna',
                'attr' => [
                    'placeholder' => 'Ej: Antirrábica',
                ],
            ])
            ->add('fechaAplicacion', DateType::class, [
                'label' => 'Fecha de aplicación',
                'widget' => 'single_text',
            ])
            ->add('veterinario', TextType::class, [
                'label' => 'Veterinario',
                'attr' => [
                    'placeholder' => 'Nombre del veterinario',
                ],
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Vacuna::class,
        ]);
    }
}