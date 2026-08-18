<?php

namespace App\Controller\ROLE_USER;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/ayuda')]
#[IsGranted('ROLE_USER')]

final class AyudaController extends AbstractController
{
    #[Route('', name: 'app_ayuda_part')]
    public function index(): Response
    {
        return $this->render('particular/ayuda/ayuda.html.twig');
    }
}
