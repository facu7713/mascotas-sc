<?php

namespace App\Controller;

use App\Repository\MascotaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VerMascotaController extends AbstractController
{
    #[Route('/mascota/{id}', name: 'app_ver_mascota')]
    public function index_ver_mascota(
        int $id,
        MascotaRepository $mascotaRepository
    ): Response {

        $mascota = $mascotaRepository->find($id);

        if (!$mascota) {
            throw $this->createNotFoundException(
                'La mascota no existe.'
            );
        }

        return $this->render('ver_mascota/index.html.twig', [
            'mascota' => $mascota,
        ]);
    }
}