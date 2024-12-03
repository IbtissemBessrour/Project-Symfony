<?php

namespace App\Entity;

use App\Repository\BibliothequeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BibliothequeRepository::class)]
class Bibliotheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titreDoc = null;

    #[ORM\Column(length: 255)]
    private ?string $auteurDoc = null;

    #[ORM\Column(length: 255)]
    private ?string $typeDoc = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDoc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreDoc(): ?string
    {
        return $this->titreDoc;
    }

    public function setTitreDoc(string $titreDoc): static
    {
        $this->titreDoc = $titreDoc;

        return $this;
    }

    public function getAuteurDoc(): ?string
    {
        return $this->auteurDoc;
    }

    public function setAuteurDoc(string $auteurDoc): static
    {
        $this->auteurDoc = $auteurDoc;

        return $this;
    }

    public function getTypeDoc(): ?string
    {
        return $this->typeDoc;
    }

    public function setTypeDoc(string $typeDoc): static
    {
        $this->typeDoc = $typeDoc;

        return $this;
    }

    public function getDateDoc(): ?\DateTimeInterface
    {
        return $this->dateDoc;
    }

    public function setDateDoc(\DateTimeInterface $dateDoc): static
    {
        $this->dateDoc = $dateDoc;

        return $this;
    }
}
