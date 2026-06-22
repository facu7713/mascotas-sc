<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InicioController extends AbstractController
{
    #[Route('/', name: 'app_inicio')]
    public function index(): Response
    {
        return $this->render('inicio/index.html.twig', [
            'controller_name' => 'InicioController',
        ]);
    }

    #[Route('/info', name: 'app_info')]
    public function info(): Response
    {
        return $this->render('inicio/info.html.twig', [
            'controller_name' => 'InicioController',
        ]);
    }

    #[Route('/ayuda', name: 'app_ayuda')]
    public function ayuda(): Response
    {
        return $this->render('inicio/ayuda.html.twig', [
            'controller_name' => 'InicioController',
        ]);
    }
}
