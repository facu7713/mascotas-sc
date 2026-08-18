<?php

namespace App\Entity;

use App\Repository\MascotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MascotaRepository::class)]
class Mascota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    private ?string $tipo = null;

    #[ORM\Column(length: 50)]
    private ?string $color = null;

    #[ORM\Column(length: 20)]
    private ?string $genero = null;

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $codigoQr = null;

    #[ORM\Column(length: 30)]
    private ?string $estado = null;

    #[ORM\ManyToOne(inversedBy: 'mascotas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Vacuna>
     */
    #[ORM\OneToMany(targetEntity: Vacuna::class, mappedBy: 'mascota', orphanRemoval: true)]
    private Collection $vacunas;

    #[ORM\OneToOne(
        inversedBy: 'mascota',
        cascade: ['persist', 'remove']
    )]
    
    #[ORM\JoinColumn(nullable: false)]
    private ?TarjetaId $tarjetaId = null;

    /**
     * @var Collection<int, ReporteMascota>
     */
    #[ORM\OneToMany(targetEntity: ReporteMascota::class, mappedBy: 'mascota', orphanRemoval: true)]
    private Collection $reportes;

    public function __construct()
    {
        $this->vacunas = new ArrayCollection();
        $this->reportes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

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

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getCodigoQr(): ?string
    {
        return $this->codigoQr;
    }

    public function setCodigoQr(?string $codigoQr): static
    {
        $this->codigoQr = $codigoQr;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Vacuna>
     */
    public function getVacunas(): Collection
    {
        return $this->vacunas;
    }

    public function addVacuna(Vacuna $vacuna): static
    {
        if (!$this->vacunas->contains($vacuna)) {
            $this->vacunas->add($vacuna);
            $vacuna->setMascota($this);
        }

        return $this;
    }

    public function removeVacuna(Vacuna $vacuna): static
    {
        if ($this->vacunas->removeElement($vacuna)) {
            // set the owning side to null (unless already changed)
            if ($vacuna->getMascota() === $this) {
                $vacuna->setMascota(null);
            }
        }

        return $this;
    }

    public function getTarjetaId(): ?TarjetaId
    {
        return $this->tarjetaId;
    }

    public function setTarjetaId(TarjetaId $tarjetaId): static
    {
        $this->tarjetaId = $tarjetaId;

        return $this;
    }

    /**
     * @return Collection<int, ReporteMascota>
     */
    public function getReportes(): Collection
    {
        return $this->reportes;
    }

    public function addReporte(ReporteMascota $reporte): static
    {
        if (!$this->reportes->contains($reporte)) {
            $this->reportes->add($reporte);
            $reporte->setMascota($this);
        }

        return $this;
    }

    public function removeReporte(ReporteMascota $reporte): static
    {
        if ($this->reportes->removeElement($reporte)) {
            // set the owning side to null (unless already changed)
            if ($reporte->getMascota() === $this) {
                $reporte->setMascota(null);
            }
        }

        return $this;
    }
}
