<?php

namespace App\Entity;

use App\Repository\VisitaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitaRepository::class)]
class Visita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valoracion = null;

    #[ORM\Column(length: 256, nullable: true)]
    private ?string $comentario = null;

    #[ORM\ManyToOne(inversedBy: 'visitas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Restaurante $restaurante = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValoracion(): ?int
    {
        return $this->valoracion;
    }

    public function setValoracion(int $valoracion): static
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): static
    {
        $this->restaurante = $restaurante;

        return $this;
    }
}
