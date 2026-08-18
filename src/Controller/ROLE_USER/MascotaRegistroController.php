<?php

namespace App\Controller\ROLE_USER;

use App\Entity\Mascota;
use App\Entity\TarjetaId;
use App\Form\MascotaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->redirectToRoute('app_mascota_new');
    }

    #[Route('/new', name: 'app_mascota_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        $mascota = new Mascota();

        $mascota->setUser($this->getUser());

        $form = $this->createForm(MascotaType::class, $mascota);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($mascota);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'La mascota fue registrada correctamente.'
            );

            return $this->redirectToRoute('app_mascota_registro');
        }

        return $this->render(
            'particular/registro_mascota/registro.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
