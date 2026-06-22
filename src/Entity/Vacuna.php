<?php

namespace App\Entity;

use App\Repository\VacunaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacunaRepository::class)]
class Vacuna
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $tipoVacuna = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fechaAplicacion = null;

    #[ORM\Column(length: 100)]
    private ?string $veterinario = null;

    #[ORM\ManyToOne(inversedBy: 'vacunas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mascota $mascota = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoVacuna(): ?string
    {
        return $this->tipoVacuna;
    }

    public function setTipoVacuna(string $tipoVacuna): static
    {
        $this->tipoVacuna = $tipoVacuna;

        return $this;
    }

    public function getFechaAplicacion(): ?\DateTime
    {
        return $this->fechaAplicacion;
    }

    public function setFechaAplicacion(\DateTime $fechaAplicacion): static
    {
        $this->fechaAplicacion = $fechaAplicacion;

        return $this;
    }

    public function getVeterinario(): ?string
    {
        return $this->veterinario;
    }

    public function setVeterinario(string $veterinario): static
    {
        $this->veterinario = $veterinario;

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
