<?php

namespace App\Controller\ROLE_USER;

use App\Entity\Mascota;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/vacunas')]
#[IsGranted('ROLE_USER')]

final class VacunasController extends AbstractController
{
    #[Route('/{id}', name: 'app_vacunas')]
    public function index(Mascota $mascota): Response
    {
        return $this->render(
            'particular/mis_mascotas/vacunas.html.twig',
            [
                'mascota' => $mascota,
                'vacunas' => $mascota->getVacunas(),
            ]
        );
    }
    #[Route('', name: 'app_vacunas_campania')]
    public function campania_vacunacion(): Response
    {
        return $this->render(
            'particular/vacunas/campania_vacuna.html.twig',
        );
    }
}
