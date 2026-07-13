<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'El nombre es obligatorio.')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'El nombre debe tener al menos {{ limit }} caracteres.',
        maxMessage: 'El nombre no puede superar los {{ limit }} caracteres.'
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}\s]+$/u',
        message: 'Solo se permiten letras y espacios.'
    )]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'El apellido es obligatorio.')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'El apellido debe tener al menos {{ limit }} caracteres.',
        maxMessage: 'El apellido no puede superar los {{ limit }} caracteres.'
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}\s]+$/u',
        message: 'Solo se permiten letras y espacios.'
    )]
    private ?string $apellido = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotBlank(message: 'El DNI es obligatorio.')]
    #[Assert\Regex(
        pattern: '/^\d{7,8}$/',
        message: 'El DNI debe contener únicamente 7 u 8 números.'
    )]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/',
        message: 'El DNI solo puede contener números.'
    )]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La dirección es obligatoria.')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'La dirección es demasiado corta.'
    )]
    private ?string $direccion = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'El teléfono es obligatorio.')]
    #[Assert\Length(
        min: 10,
        max: 13,
        minMessage: 'El teléfono debe tener al menos {{ limit }} dígitos.',
        maxMessage: 'El teléfono no puede superar los {{ limit }} dígitos.'
    )]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/',
        message: 'El teléfono solo puede contener números.'
    )]
    private ?string $telefono = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaAlta = null;

    #[ORM\Column]
    private ?bool $activo = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'persona', orphanRemoval: true)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeImmutable
    {
        return $this->fechaAlta;
    }

    public function setFechaAlta(\DateTimeImmutable $fechaAlta): static
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setPersona($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPersona() === $this) {
                $user->setPersona(null);
            }
        }

        return $this;
    }
}
