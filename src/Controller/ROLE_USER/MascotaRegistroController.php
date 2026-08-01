<?php

namespace App\Controller\ROLE_USER;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/registro_mascota')]
#[IsGranted('ROLE_USER')]

final class MascotaRegistroController extends AbstractController
{
    #[Route('', name: 'app_mascota_registro')]
    public function index(): Response
    {
        return $this->render('particular/registro_mascota/registro.html.twig');
    }
}
