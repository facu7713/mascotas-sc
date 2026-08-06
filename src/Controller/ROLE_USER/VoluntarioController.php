<?php

namespace App\Controller\ROLE_USER;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/ser_voluntario')]
#[IsGranted('ROLE_USER')]

final class VoluntarioController extends AbstractController
{
    #[Route('', name: 'app_voluntario')]
    public function index(): Response
    {
        return $this->render('particular/ser_voluntario/ser_voluntario.html.twig');
    }
}
