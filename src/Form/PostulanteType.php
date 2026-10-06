<?php

namespace App\Form;

use App\Entity\Postulante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulanteType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('motivo', TextareaType::class, [
                'label' => '¿Por qué querés ser voluntario?',
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Contanos por qué querés formar parte como voluntario...',
                ],
            ])
            ->add('disponibilidad', TextareaType::class, [
                'label' => '¿Cuál es tu disponibilidad?',
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Por ejemplo: fines de semana, por la tarde, etc.',
                ],
            ])
            ->add('infoAdicional', TextareaType::class, [
                'label' => 'Información adicional',
                'required' => false,
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Podés agregar cualquier información que consideres importante.',
                ],
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Postulante::class,
        ]);
    }
}