<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

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
            
                'invalid_message' => 'Las nuevas contraseñas no coinciden.',
            
                'mapped' => false,
            
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debes ingresar una nueva contraseña.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                        'max' => 4096,
                    ]),
                ],
            ]);

    }

}