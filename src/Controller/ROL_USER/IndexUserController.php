<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexUserController extends AbstractController
{
    #[Route('/index/user', name: 'app_index_user')]
    public function index(): Response
    {
        return $this->render('particular/index.html.twig', [
            'controller_name' => 'IndexUserController',
        ]);
    }
}
