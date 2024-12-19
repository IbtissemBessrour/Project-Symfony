<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la Reponse ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la Reponse ne peut pas dépasser {{ limit }} caractères.")]  
      private ?string $contenu = '';

      #[ORM\Column(length: 255)]
      #[Assert\NotBlank(message: "Le nom de la Reponse ne peut pas être vide.")]
      #[Assert\Length(max: 255, maxMessage: "Le nom de la Reponse ne peut pas dépasser {{ limit }} caractères.")]  
    private ?string $utilisateur = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la Reponse ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la Reponse ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $reclamation = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la Reponse ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom de la Reponse ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $statut = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
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

    public function getReclamation(): ?string
    {
        return $this->reclamation;
    }

    public function setReclamation(string $reclamation): static
    {
        $this->reclamation = $reclamation;

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
