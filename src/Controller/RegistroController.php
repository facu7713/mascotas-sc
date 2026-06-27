<?php

namespace App\Controller;

use App\Form\RegistroType;
use App\Entity\Persona;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/registro')]

final class RegistroController extends AbstractController
{
    #[Route('', name: 'app_registro')]
    public function registro(): Response
    {
        $persona = new Persona();
    
        $form = $this->createForm(
            RegistroType::class,
            $persona
        );
    
        return $this->render(
            'inicio/registro.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
