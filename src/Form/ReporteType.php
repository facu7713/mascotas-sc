<?php

namespace App\Form;

use App\Entity\ReporteMascota;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipoReporte', ChoiceType::class, [
                'label' => 'Tipo de reporte',
                'choices' => [
                    'Mascota perdida' => 'perdido',
                    'Mascota encontrada' => 'encontrado',
                ],
                'placeholder' => 'Seleccionar tipo de reporte',
            ])

            ->add('nombreMascota', TextType::class, [
                'label' => 'Nombre de la mascota',
                'required' => true,
            ])

            ->add('tipoMascota', ChoiceType::class, [
                'label' => 'Tipo de mascota',
                'choices' => [
                    'Perro' => 'perro',
                    'Gato' => 'gato',
                ],
                'placeholder' => 'Seleccionar tipo de mascota',
            ])

            ->add('color', TextType::class, [
                'label' => 'Color',
                'required' => true,
            ])

            ->add('ubicacion', ChoiceType::class, [
                'label' => 'Barrio',
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
                    'placeholder' => 'Describa dónde fue vista o encontrada la mascota...',
                ],
            ])

            ->add('foto', FileType::class, [
                'label' => 'Foto de la mascota',
                'mapped' => false,
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReporteMascota::class,
        ]);
    }
}