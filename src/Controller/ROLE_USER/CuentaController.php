<?php

namespace App\Controller\ROLE_USER;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/cuenta_usuario')]
#[IsGranted('ROLE_USER')]

final class CuentaController extends AbstractController
{
    #[Route('', name: 'app_cuenta')]
    public function index(): Response
    {
        return $this->render('particular/cuenta_usuario/mi_cuenta.html.twig');
    }
}
