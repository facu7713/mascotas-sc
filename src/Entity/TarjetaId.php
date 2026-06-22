<?php

namespace App\Entity;

use App\Repository\TarjetaIdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarjetaIdRepository::class)]
class TarjetaId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numeroTarjeta = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaEmision = null;

    #[ORM\OneToOne(mappedBy: 'tarjetaId', targetEntity: Mascota::class)]
    private ?Mascota $mascota = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroTarjeta(): ?string
    {
        return $this->numeroTarjeta;
    }

    public function setNumeroTarjeta(string $numeroTarjeta): static
    {
        $this->numeroTarjeta = $numeroTarjeta;

        return $this;
    }

    public function getFechaEmision(): ?\DateTimeImmutable
    {
        return $this->fechaEmision;
    }

    public function setFechaEmision(\DateTimeImmutable $fechaEmision): static
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    public function getMascota(): ?Mascota
    {
        return $this->mascota;
    }

    public function setMascota(?Mascota $mascota): static
    {
        $this->mascota = $mascota;

        return $this;
    }
}
