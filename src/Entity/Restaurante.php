<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestauranteRepository::class)]
class Restaurante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 256)]
    private ?string $nombre = null;

    #[ORM\Column(length: 256)]
    private ?string $direccion = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 256, nullable: true)]
    private ?string $tipoCocina = null;

    #[ORM\OneToMany(mappedBy: 'restaurante', targetEntity: Visita::class, orphanRemoval: true)]
    private Collection $visitas;

    public function __construct()
    {
        $this->visitas = new ArrayCollection();
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

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTipoCocina(): ?string
    {
        return $this->tipoCocina;
    }

    public function setTipoCocina(?string $tipoCocina): static
    {
        $this->tipoCocina = $tipoCocina;

        return $this;
    }

    /**
     * @return Collection<int, Visita>
     */
    public function getVisitas(): Collection
    {
        return $this->visitas;
    }

    public function addVisita(Visita $visita): static
    {
        if (!$this->visitas->contains($visita)) {
            $this->visitas->add($visita);
            $visita->setRestaurante($this);
        }

        return $this;
    }

    public function removeVisita(Visita $visita): static
    {
        if ($this->visitas->removeElement($visita)) {
            // set the owning side to null (unless already changed)
            if ($visita->getRestaurante() === $this) {
                $visita->setRestaurante(null);
            }
        }

        return $this;
    }
}
