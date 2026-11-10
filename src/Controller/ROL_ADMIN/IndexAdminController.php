<?php

namespace App\Controller\ROL_ADMIN;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]

final class IndexAdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/admin_inicio.html.twig');
    }
}
