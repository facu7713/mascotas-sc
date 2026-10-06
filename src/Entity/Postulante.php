<?php

namespace App\Entity;

use App\Repository\PostulanteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulanteRepository::class)]
class Postulante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motivo = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $disponibilidad = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infoAdicional = null;

    #[ORM\Column(length: 20)]
    private ?string $estado = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaPostulacion = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false, unique: true)]
    private ?Persona $persona = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): static
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getDisponibilidad(): ?string
    {
        return $this->disponibilidad;
    }

    public function setDisponibilidad(string $disponibilidad): static
    {
        $this->disponibilidad = $disponibilidad;

        return $this;
    }

    public function getInfoAdicional(): ?string
    {
        return $this->infoAdicional;
    }

    public function setInfoAdicional(?string $infoAdicional): static
    {
        $this->infoAdicional = $infoAdicional;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFechaPostulacion(): ?\DateTimeImmutable
    {
        return $this->fechaPostulacion;
    }

    public function setFechaPostulacion(\DateTimeImmutable $fechaPostulacion): static
    {
        $this->fechaPostulacion = $fechaPostulacion;

        return $this;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): static
    {
        $this->persona = $persona;

        return $this;
    }
}
