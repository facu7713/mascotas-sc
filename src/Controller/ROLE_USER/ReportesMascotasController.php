<?php

namespace App\Controller\ROLE_USER;

use App\Entity\ReporteMascota;
use App\Form\ReporteType;
use App\Repository\ReporteMascotaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/reportes_mascotas')]
#[IsGranted('ROLE_USER')]

final class ReportesMascotasController extends AbstractController
{
    #[Route('', name: 'app_reportes_mascotas')]
    public function index(
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $reporte = new ReporteMascota();

        $form = $this->createForm(
            ReporteType::class,
            $reporte
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reporte->setFechaReporte(new \DateTimeImmutable());

            $persona = $this->getUser()->getPersona();

            $reporte->setPersonaReporta(
                (string) $persona->getId()
            );

            $file = $form->get('foto')->getData();

            if ($file) {

                $nombreFoto = uniqid() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/mascotas_reportadas',
                    $nombreFoto
                );

                $reporte->setFoto(
                    'uploads/mascotas_reportadas/' . $nombreFoto
                );
            }

            $reporte->setMascota(null);

            $em->persist($reporte);
            $em->flush();

            $this->addFlash(
                'success',
                'El reporte fue registrado correctamente.'
            );

            return $this->redirectToRoute('app_reportes_mascotas');
        }

        return $this->render(
            'particular/reportes_mascotas/form_reporte.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/perdidos', name: 'app_reportes_perdidos')]
    public function perdidos(
        ReporteMascotaRepository $reporteMascotaRepository
    ): Response {

        $reportes = $reporteMascotaRepository->findBy(
            ['tipoReporte' => 'perdido'],
            ['fechaReporte' => 'DESC']
        );

        return $this->render(
            'particular/reportes_mascotas/perdidos.html.twig',
            [
                'reportes' => $reportes,
            ]
        );
    }

    #[Route('/encontrados', name: 'app_reportes_encontrados')]
    public function encontrados(
        ReporteMascotaRepository $reporteMascotaRepository
    ): Response {

        $reportes = $reporteMascotaRepository->findBy(
            ['tipoReporte' => 'encontrado'],
            ['fechaReporte' => 'DESC']
        );
        
        return $this->render(
            'particular/reportes_mascotas/encontrados.html.twig',
            [
                'reportes' => $reportes,
            ]
        );

    }
}
