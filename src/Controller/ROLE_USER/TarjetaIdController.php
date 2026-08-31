<?php

namespace App\Controller\ROLE_USER;

use App\Repository\MascotaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/mis_mascotas')]
#[IsGranted('ROLE_USER')]

final class TarjetaIdController extends AbstractController
{
    #[Route('', name: 'app_tarjeta_id')]
    public function index(
        MascotaRepository $mascotaRepository
    ): Response {

        $usuario = $this->getUser();

        $mascotas = $mascotaRepository->findByUser($usuario);

        if (!$mascotas) {
            $this->addFlash(
                'warning',
                'No tenés mascotas registradas.'
            );
        }

        return $this->render(
            'particular/mis_mascotas/tarjetas_id.html.twig',
            [
                'mascotas' => $mascotas,
            ]
        );
    }
}