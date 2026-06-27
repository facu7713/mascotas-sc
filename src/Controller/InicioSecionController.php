<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/secion')]

final class InicioSecionController extends AbstractController
{
    #[Route('', name: 'app_inicio_sesion')]
    public function index(): Response
    {
        return $this->render('inicio/inicio_sesion.html.twig', [
            'controller_name' => 'InicioSecionController',
        ]);
    }
}
