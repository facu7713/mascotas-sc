<?php

namespace App\Controller\ROLE_USER;

use App\Entity\Mascota;
use App\Entity\TarjetaId;
use App\Form\MascotaType;
use App\Service\QrCodeGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
        EntityManagerInterface $em,
        QrCodeGeneratorService $qrCodeGenerator
    ): Response {

        $tarjetaId = new TarjetaId();
        $tarjetaId->setFechaEmision(new \DateTimeImmutable());

        $mascota = new Mascota();
        $mascota->setUser($this->getUser());
        $mascota->setTarjetaId($tarjetaId);

        $form = $this->createForm(MascotaType::class, $mascota);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 1. Manejo de la foto de la mascota
            $file = $form->get('imagen')->getData();

            if ($file) {
                $nombreImagen = uniqid() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/mascotas_registro',
                    $nombreImagen
                );
                $mascota->setFoto('uploads/mascotas_registro/' . $nombreImagen);
            }

            // 2. Primer flush para persistir y obtener el ID autogenerado de la mascota
            $em->persist($tarjetaId);
            $em->persist($mascota);
            $em->flush();

            // 3. Generar la URL absoluta a la que apuntará el QR
            $payloadUrl = $this->generateUrl(
                'app_tarjeta_id', 
                [], 
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            // 4. Generar la imagen del QR
            $qrPath = $qrCodeGenerator->generateForMascota($mascota->getId(), $payloadUrl);

            // 5. Asignar la ruta del QR directamente en la entidad Mascota
            $mascota->setCodigoQR($qrPath);
            $em->flush();

            $this->addFlash('success', 'La mascota fue registrada correctamente.');

            return $this->redirectToRoute('app_mascota_registro');
        }

        return $this->render('particular/registro_mascota/registro.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}