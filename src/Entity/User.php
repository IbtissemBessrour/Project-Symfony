<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Username is required.")]
    #[Assert\Length(
        min: 3,
        max: 50,
        maxMessage: "Username cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9]+$/",
        message: "Username can only contain letters and numbers."
    )]
    private ?string $nom = null;
   

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Username is required.")]
    #[Assert\Length(
        min: 3,
        max: 50,
        maxMessage: "Username cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9]+$/",
        message: "Username can only contain letters and numbers."
    )]
    private ?string $prenom = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Password is required.")]
    #[Assert\Length(
        min: 8,
        minMessage: "Password must be at least {{ limit }} characters long."
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }
}