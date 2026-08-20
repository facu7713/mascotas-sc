<?php

namespace App\Service;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRSvg;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class QrCodeGeneratorService
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/public/uploads/cod_qr')]
        private string $targetDirectory
    ) {
    }

    public function generateForMascota(
        int $mascotaId,
        string $payloadUrl
    ): string {

        // Crear la carpeta si no existe
        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        // Configuración para salida SVG (NO requiere la extensión ext-gd)
        $options = new QROptions();
        $options->outputType = QRSvg::class;
        $options->outputBase64 = false;
        $options->eccLevel = EccLevel::H;
        $options->scale = 3;

        // Nombre del archivo guardado como .svg
        $filename = sprintf(
            'qr_mascota_%d_%s.svg',
            $mascotaId,
            uniqid()
        );

        $filePath = $this->targetDirectory . '/' . $filename;

        // Generar el marcado SVG limpio
        $qrCode = new QRCode($options);
        $svgData = $qrCode->render($payloadUrl);

        // Guardar explícitamente la cadena del SVG en disco
        if (file_put_contents($filePath, $svgData) === false) {
            throw new \RuntimeException(
                'No se pudo escribir el archivo QR en el disco.'
            );
        }

        // Comprobar que el archivo exista y no esté vacío
        if (!file_exists($filePath) || filesize($filePath) === 0) {
            throw new \RuntimeException(
                'El archivo QR no se creó o está vacío.'
            );
        }

        // Ruta relativa para la base de datos
        return 'uploads/cod_qr/' . $filename;
    }
}