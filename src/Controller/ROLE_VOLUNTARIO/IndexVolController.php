<?php

namespace App\Controller\ROLE_VOLUNTARIO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/voluntario')]
#[IsGranted('ROLE_VOLUNTARIO')]

final class IndexVolController extends AbstractController
{
    #[Route('', name: 'app_voluntario')]
    public function index(): Response
    {
        return $this->render('voluntario/voluntario_inicio.html.twig');
    }
}
