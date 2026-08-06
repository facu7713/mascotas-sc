<?php

namespace App\Controller\ROLE_USER;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/vacunas')]
#[IsGranted('ROLE_USER')]

final class VacunasController extends AbstractController
{
    #[Route('', name: 'app_vacunas')]
    public function index(): Response
    {
        return $this->render('particular/vacunas/vacunas.html.twig');
    }
}
