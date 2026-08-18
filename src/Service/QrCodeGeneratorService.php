<?php

namespace App\Service;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class QrCodeGeneratorService
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/public/uploads/cod_qr')]
        private string $targetDirectory
    ) {}

    public function generateForMascota(int $mascotaId, string $payloadUrl): string
    {
        // 1. Crear el directorio si no existe
        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        // 2. Configurar opciones
        $options = new QROptions([
            'outputType'  => 'png',
            'eccLevel'    => EccLevel::H,
            'scale'       => 5,
            'imageBase64' => false, 
        ]);

        $filename = sprintf('qr_mascota_%d_%s.png', $mascotaId, uniqid());
        $filePath = $this->targetDirectory . '/' . $filename;

        // 3. Generar la imagen binaria en memoria
        $qrImageData = (new QRCode($options))->render($payloadUrl);

        // 4. Guardar explícitamente el binario en el archivo
        file_put_contents($filePath, $qrImageData);

        // 5. Devuelve la ruta relativa para guardar en la BD
        return 'uploads/cod_qr/' . $filename;
    }
}