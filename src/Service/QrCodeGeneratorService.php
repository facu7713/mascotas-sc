<?php

namespace App\Service;

use Chillerlan\QRCode\QRCode;
use Chillerlan\QRCode\QROptions;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class QrCodeGeneratorService
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/public/uploads/cod_qr')]
        private string $targetDirectory
    ) {}

    public function generateForMascota(int $mascotaId, string $payloadUrl): string
    {
        // Crear directorio si no existe
        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        $options = new QROptions([
            'outputType'  => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'    => QRCode::ECC_L,
            'scale'       => 3,
            'imageBase64' => false,
        ]);

        $filename = sprintf('qr_mascota_%d_%s.png', $mascotaId, uniqid());
        $filePath = $this->targetDirectory . '/' . $filename;

        // Generar y guardar la imagen en disco
        (new QRCode($options))->render($payloadUrl, $filePath);

        // Devuelve la ruta relativa dentro de public/
        return 'uploads/cod_qr/' . $filename;
    }
}