<?php

namespace App\Entity;

use App\Repository\ReporteMascotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReporteMascotaRepository::class)]
class ReporteMascota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $tipoReporte = null;

    #[ORM\Column(length: 100)]
    private ?string $nombreMascota = null;

    #[ORM\Column(length: 50)]
    private ?string $tipoMascota = null;

    #[ORM\Column(length: 50)]
    private ?string $color = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $ubicacion = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaReporte = null;

    #[ORM\Column(length: 150)]
    private ?string $personaReporta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\ManyToOne(inversedBy: 'reportes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mascota $mascota = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoReporte(): ?string
    {
        return $this->tipoReporte;
    }

    public function setTipoReporte(string $tipoReporte): static
    {
        $this->tipoReporte = $tipoReporte;

        return $this;
    }

    public function getNombreMascota(): ?string
    {
        return $this->nombreMascota;
    }

    public function setNombreMascota(string $nombreMascota): static
    {
        $this->nombreMascota = $nombreMascota;

        return $this;
    }

    public function getTipoMascota(): ?string
    {
        return $this->tipoMascota;
    }

    public function setTipoMascota(string $tipoMascota): static
    {
        $this->tipoMascota = $tipoMascota;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUbicacion(): ?string
    {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): static
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    public function getFechaReporte(): ?\DateTimeImmutable
    {
        return $this->fechaReporte;
    }

    public function setFechaReporte(\DateTimeImmutable $fechaReporte): static
    {
        $this->fechaReporte = $fechaReporte;

        return $this;
    }

    public function getPersonaReporta(): ?string
    {
        return $this->personaReporta;
    }

    public function setPersonaReporta(string $personaReporta): static
    {
        $this->personaReporta = $personaReporta;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

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
