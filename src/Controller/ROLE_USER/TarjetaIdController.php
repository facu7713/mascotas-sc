<?php

namespace App\Controller\ROLE_USER;

use App\Entity\Mascota; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/mis_mascotas')]
#[IsGranted('ROLE_USER')]

final class TarjetaIdController extends AbstractController
{
    #[Route('/{id}', name: 'app_tarjeta_id')]
    public function index(Mascota $mascota): Response
    {
        return $this->render('particular/mis_mascotas/tarjetas_id.html.twig', [
            'mascota' => $mascota,
        ]);
    }
}