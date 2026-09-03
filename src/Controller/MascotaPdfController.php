<?php

namespace App\Controller;

use App\Entity\Mascota;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MascotaPdfController extends AbstractController
{
    #[Route('/mascota/{id}/pdf', name: 'app_mascota_pdf')]
    public function descargarPdf(Mascota $mascota): Response
    {
        $projectDir = $this->getParameter('kernel.project_dir');

        $propietario = $mascota->getUser()->getPersona();

        // 1. Convertir la foto de la mascota a Base64
        $fotoBase64 = null;
        if ($mascota->getFoto()) {
            $fotoPath = $projectDir . '/public/' . ltrim($mascota->getFoto(), '/');
            if (file_exists($fotoPath)) {
                $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
                $fotoData = file_get_contents($fotoPath);
                $fotoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode($fotoData);
            }
        }

        // 2. Convertir el QR SVG a Base64
        $qrBase64 = null;
        if ($mascota->getCodigoQr()) {
            $qrPath = $projectDir . '/public/' . ltrim($mascota->getCodigoQr(), '/');
            if (file_exists($qrPath)) {
                $qrData = file_get_contents($qrPath);
                $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrData);
            }
        }

        // 3. Configurar Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($pdfOptions);

        // 4. Renderizar la plantilla Twig enviando las variables Base64
        $html = $this->renderView('pdf.html.twig', [
            'mascota'    => $mascota,
            'propietario' => $propietario,
            'fotoBase64' => $fotoBase64,
            'qrBase64'   => $qrBase64,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="ficha_mascota_' . $mascota->getId() . '.pdf"',
            ]
        );
    }
}