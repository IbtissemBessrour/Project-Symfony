<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la Reclamation ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la Reclamation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $utilisateur = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la Reclamation ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la Reclamation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $description = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la Reclamation ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la Reclamation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $statut = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?string
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(string $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
