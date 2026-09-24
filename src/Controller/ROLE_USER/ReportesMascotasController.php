<?php

namespace App\Controller\ROLE_USER;

use App\Entity\ReporteMascota;
use App\Form\ReporteType;
use App\Repository\ReporteMascotaRepository;
use App\Repository\PersonaRepository;
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
        ReporteMascotaRepository $reporteMascotaRepository,
        PersonaRepository $personaRepository
    ): Response {

        $reportes = $reporteMascotaRepository->findBy(
            ['tipoReporte' => 'perdido'],
            ['fechaReporte' => 'DESC']
        );

        $nombresPersonas = [];

        foreach ($reportes as $reporte) {
            $persona = $personaRepository->find(
                (int) $reporte->getPersonaReporta()
            );

            $nombresPersonas[$reporte->getId()] = $persona
                ? $persona->getNombre() .' '. $persona->getApellido()
                : 'No disponible';
        }


        return $this->render(
            'particular/reportes_mascotas/perdidos.html.twig',
            [
                'reportes' => $reportes,
                'nombresPersonas' => $nombresPersonas,
            ]
        );
    }

    #[Route('/encontrados', name: 'app_reportes_encontrados')]
    public function encontrados(
        ReporteMascotaRepository $reporteMascotaRepository,
        PersonaRepository $personaRepository
    ): Response {

        $reportes = $reporteMascotaRepository->findBy(
            ['tipoReporte' => 'encontrado'],
            ['fechaReporte' => 'DESC']
        );

        $nombresPersonas = [];

        foreach ($reportes as $reporte) {
            $persona = $personaRepository->find(
                (int) $reporte->getPersonaReporta()
            );

            $nombresPersonas[$reporte->getId()] = $persona
                ? $persona->getNombre() .' '. $persona->getApellido()
                : 'No disponible';
        }

        
        return $this->render(
            'particular/reportes_mascotas/encontrados.html.twig',
            [
                'reportes' => $reportes,
                'nombresPersonas' => $nombresPersonas,
            ]
        );

    }

    #[Route( '/reporte/{id}/encontrado', name: 'app_reporte_marcar_encontrado', methods: ['POST'] )]
    public function marcarEncontrado(
        ReporteMascota $reporte,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // Verificar el token de seguridad del formulario
        if (!$this->isCsrfTokenValid(
            'encontrado' . $reporte->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Token de seguridad inválido.'
            );
        }
    
        // Si el reporte pertenece a una mascota registrada,
        // actualizar también el estado de esa mascota.
        $mascota = $reporte->getMascota();
    
        if ($mascota !== null) {
            $mascota->setEstado('con propietario');
        }
    
        // Cambiar el tipo del reporte para que pase a Encontrados
        $reporte->setTipoReporte('encontrado');
    
        $em->flush();
    
        $this->addFlash(
            'success',
            'El reporte fue actualizado como encontrado.'
        );
    
        return $this->redirectToRoute('app_reportes_perdidos');
    }

    #[Route('/reporte/{id}/eliminar', name: 'app_reporte_eliminar', methods: ['POST'] )]
    public function eliminar(
        ReporteMascota $reporte,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // Validar el token de seguridad
        if (!$this->isCsrfTokenValid(
            'eliminar_reporte' . $reporte->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Token de seguridad inválido.'
            );
        }
    
        // Si el reporte no está vinculado a una mascota registrada
        if ($reporte->getMascota() === null) {
    
            $foto = $reporte->getFoto();
    
            if ($foto) {
                $fotoPath = $this->getParameter('kernel.project_dir')
                    . '/public/'
                    . ltrim($foto, '/');
    
                // Evitar eliminar archivos fuera de la carpeta de reportes
                $directorioReportes = realpath(
                    $this->getParameter('kernel.project_dir')
                    . '/public/uploads/mascotas_reportadas'
                );
    
                $directorioFoto = realpath(dirname($fotoPath));
    
                if (
                    $directorioReportes !== false
                    && $directorioFoto === $directorioReportes
                    && is_file($fotoPath)
                ) {
                    unlink($fotoPath);
                }
            }
        }
    
        // Eliminar el reporte, esté o no vinculado a una mascota
        $em->remove($reporte);
        $em->flush();
    
        $this->addFlash(
            'success',
            'El reporte fue eliminado correctamente.'
        );
    
        // Volver a la lista correspondiente
        if ($reporte->getTipoReporte() === 'encontrado') {
            return $this->redirectToRoute('app_reportes_encontrados');
        }
    
        return $this->redirectToRoute('app_reportes_perdidos');
    }
}
