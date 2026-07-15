<?php

namespace App\Controller\ROLE_USER;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular')]
#[IsGranted('ROLE_USER')]

final class IndexUserController extends AbstractController
{
    #[Route('', name: 'app_particular')]
    public function index(): Response
    {
        return $this->render('particular/particular_inicio.html.twig');
    }
}
