<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Entity\User;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/registro')]
class RegistroController extends AbstractController
{
    #[Route('', name: 'app_registro')]
    public function registro(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {

        $persona = new Persona();

        $form = $this->createForm(
            RegistroType::class,
            $persona
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = new User();

            $user->setEmail(
                $form->get('email')->getData()
            );

            $user->setRoles([
                'ROLE_USER'
            ]);

            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $persona->setFechaAlta(
                new \DateTimeImmutable()
            );

            $persona->setActivo(false);

            $user->setPersona($persona);

            $entityManager->persist($persona);
            $entityManager->persist($user);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'La cuenta fue creada correctamente. Ahora puedes iniciar sesión.'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'inicio/registro.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
