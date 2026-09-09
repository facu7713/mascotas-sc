<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {

        $builder

            ->add('currentPassword', PasswordType::class, [
                'label' => 'Contraseña actual',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                'first_options' => [
                    'label' => 'Nueva contraseña',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],

                'second_options' => [
                    'label' => 'Repetir nueva contraseña',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],

                'invalid_message' =>
                    'Las nuevas contraseñas no coinciden.',

                'mapped' => false,
            ]);

    }

}