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
        // 1. Configurar las opciones de Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true); // Permite cargar imágenes externas o locales

        // 2. Instanciar Dompdf
        $dompdf = new Dompdf($pdfOptions);

        // 3. Renderizar la plantilla Twig a una cadena HTML
        $html = $this->renderView('pdf.html.twig', [
            'mascota' => $mascota,
            'project_dir' => $this->getParameter('kernel.project_dir'),
        ]);

        // 4. Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

        // 5. Configurar el tamaño y orientación de página ('portrait' o 'landscape')
        $dompdf->setPaper('A4', 'portrait');

        // 6. Renderizar el PDF
        $dompdf->render();

        // 7. Enviar la respuesta al navegador
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                // 'inline' abre el PDF en la pestaña; 'attachment' fuerza la descarga directa:
                'Content-Disposition' => 'inline; filename="ficha_mascota_' . $mascota->getId() . '.pdf"',
            ]
        );
    }
}
