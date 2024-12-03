<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFine = null;

    #[ORM\Column(length: 255)]
    private ?string $nomFormation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebue(): ?\DateTimeInterface
    {
        return $this->dateDebue;
    }

    public function setDateDebue(\DateTimeInterface $dateDebue): static
    {
        $this->dateDebue = $dateDebue;

        return $this;
    }

    public function getDateFine(): ?\DateTimeInterface
    {
        return $this->dateFine;
    }

    public function setDateFine(\DateTimeInterface $dateFine): static
    {
        $this->dateFine = $dateFine;

        return $this;
    }

    public function getNomFormation(): ?string
    {
        return $this->nomFormation;
    }

    public function setNomFormation(string $nomFormation): static
    {
        $this->nomFormation = $nomFormation;

        return $this;
    }
}
