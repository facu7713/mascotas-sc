<?php

namespace App\Controller\ROLE_USER;

use App\Entity\Mascota;
use App\Form\MascotaType;
use App\Repository\MascotaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/{id}/actualizar', name: 'app_mascota_actualizar')]
    public function actualizar(
        Mascota $mascota,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        // Seguridad:
        // verificamos que la mascota pertenezca al usuario que está conectado
        if ($mascota->getUser() !== $this->getUser()) {

            throw $this->createAccessDeniedException(
                'No tenés permiso para modificar esta mascota.'
            );
        }

        $fotoAnterior = $mascota->getFoto();

        $form = $this->createForm(MascotaType::class, $mascota);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Obtener nueva imagen
            $file = $form->get('imagen')->getData();

            if ($file) {

                $nombreImagen = uniqid() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('kernel.project_dir')
                    . '/public/uploads/mascotas_registro',
                    $nombreImagen
                );

                $mascota->setFoto(
                    'uploads/mascotas_registro/' . $nombreImagen
                );

                // Eliminar la foto anterior
                if ($fotoAnterior) {

                    $fotoAnteriorPath =
                        $this->getParameter('kernel.project_dir')
                        . '/public/' . ltrim($fotoAnterior, '/');

                    if (file_exists($fotoAnteriorPath)) {
                        unlink($fotoAnteriorPath);
                    }
                }
            }

            $em->flush();

            $this->addFlash(
                'success',
                'Los datos de la mascota fueron actualizados correctamente.'
            );

            return $this->redirectToRoute(
                'app_tarjeta_id',
                ['id' => $this->getUser()->getId()]
            );
        }

        return $this->render(
            'particular/mis_mascotas/actualizar.html.twig',
            [
                'form' => $form->createView(),
                'mascota' => $mascota,
            ]
        );
    }

    #[Route('/{id}/eliminar', name: 'app_mascota_eliminar', methods: ['POST'])]
    public function eliminar(
        Mascota $mascota,
        EntityManagerInterface $em
    ): Response {
        // Verificamos que la mascota pertenezca al usuario que inició sesión
        if ($mascota->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException(
                'No tenés permiso para eliminar esta mascota.'
            );
        }

        $fotoDelete = $mascota->getFoto();

        $QrDetelete = $mascota->getCodigoQr();

        // Eliminar la foto de la mascota

        if ($fotoDelete) {

            $fotoDeletePath =
                $this->getParameter('kernel.project_dir')
                . '/public/' . ltrim($fotoDelete, '/');

            if (file_exists($fotoDeletePath)) {
                unlink($fotoDeletePath);
            }
        }

        // Eliminar la qr de la mascota

        if ($QrDetelete) {

            $QrDeteletePath =
                $this->getParameter('kernel.project_dir')
                . '/public/' . ltrim($QrDetelete, '/');

            if (file_exists($QrDeteletePath)) {
                unlink($QrDeteletePath);
            }
        }

        // Eliminamos la mascota
        $em->remove($mascota);
        $em->flush();

        $this->addFlash(
            'success',
            'La mascota fue eliminada correctamente.'
        );

        return $this->redirectToRoute('app_tarjeta_id');
    }
}