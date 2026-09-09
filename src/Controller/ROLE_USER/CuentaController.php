<?php

namespace App\Controller\ROLE_USER;

use App\Form\EditarPerfilType;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/cuenta_usuario')]
#[IsGranted('ROLE_USER')]

final class CuentaController extends AbstractController
{
    #[Route('', name: 'app_cuenta')]
    public function index(): Response
    {
        $usuario = $this->getUser();

        return $this->render(
            'particular/cuenta_usuario/mi_cuenta.html.twig',
            [
                'usuario' => $usuario,
            ]
        );
    }

    #[Route('/editar_perfil', name: 'app_edit_cuenta')]
    public function editar_cuenta(Request $request, EntityManagerInterface $em): Response
    {
        $usuario = $this->getUser();

        $form = $this->createForm(EditarPerfilType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Tus datos personales fueron actualizados correctamente.');

            return $this->redirectToRoute('app_cuenta');
        }

        return $this->render('particular/cuenta_usuario/edit_cuenta.html.twig', [
            'form' => $form->createView(),
            'usuario' => $usuario,
        ]);
    }


    #[Route('/cambiar-contrasena', name: 'app_cambiar_contrasena')]
    public function cambiarContrasena(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {

        $usuario = $this->getUser();

        $form = $this->createForm(
            ChangePasswordType::class
        );

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $currentPassword =
                $form->get('currentPassword')->getData();

            $newPassword =
                $form->get('newPassword')->getData();


            if (
                !$passwordHasher->isPasswordValid(
                    $usuario,
                    $currentPassword
                )
            ) {

                $this->addFlash(
                    'error',
                    'La contraseña actual es incorrecta.'
                );

                return $this->redirectToRoute(
                    'app_cambiar_contrasena'
                );

            }


            $hashedPassword =
                $passwordHasher->hashPassword(
                    $usuario,
                    $newPassword
                );


            $usuario->setPassword(
                $hashedPassword
            );


            $em->flush();


            $this->addFlash(
                'success',
                'Tu contraseña fue actualizada correctamente.'
            );


            return $this->redirectToRoute(
                'app_cuenta'
            );

        }


        return $this->render(
            'particular/cuenta_usuario/cambiar_contrasena.html.twig',
            [
                'form' => $form->createView(),
            ]
        );

    }

}